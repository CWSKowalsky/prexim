<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

 

// 'onsubmit_callback' => array ( 
//    array('Prex', 'submit')
// )
/**
 * Table tl_prex
 */
$GLOBALS['TL_DCA']['tl_prex'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s',
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_prex']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_prex']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'

			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_prex']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
			'exc' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_prex']['exc'],
				'icon'                => 'vendor/skowalsky/src/Resources/public/start_now.png',
				'attributes'          => 'onclick="Backend.getScrollOffset();"',
				'href'                => 'act=exc'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,products,allp'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_prex']['title'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'unique'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'products' => array
		(
			'label' => &$GLOBALS['TL_LANG']['tl_prex']['products'],
			'exclude' => true,
			'inputType' => 'ls_shop_productSelectionWizard',
			'sql'	=> "blob NULL"
		),
		'allp' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_prex']['allp'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => array(
                'doNotCopy' => true
            ),
			'filter' => true,
			'sql'	=> "int(1) NOT NULL default '0'"
        )
	)
);

function getConnection() {
	$servername = $GLOBALS['TL_CONFIG']['dbHost'];
	$username = $GLOBALS['TL_CONFIG']['dbUser'];
	$password = $GLOBALS['TL_CONFIG']['dbPass'];
	$dbname = $GLOBALS['TL_CONFIG']['dbDatabase'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	return $conn;
}

function execute($conn, $sql) {
	$result = $conn->query($sql);
	$array = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		array_push($array, $row);
	}
	return $array;
}

if($_GET['act'] == "exc" && $_GET['do'] == "prex") {
	$id = $_GET['id'];

	$conn = getConnection();
	$data = execute($conn, "SELECT * FROM tl_prex WHERE id=$id")[0];

	if($data['allp'] == 1) {
		$products = exportAllProducts($conn);
		$variants = exportAllVariants($conn);
		$export = array('products' => $products, 'variants' => $variants);
		$export_ser = serialize($export);
		$file = getFile();
		file_put_contents($file, $export_ser, FILE_APPEND | LOCK_EX);
		header("Location: ".parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?do=prex');
	}

	$conn->close();
}

function getFile() {
	$folder = '../ProductExports';
	if (!file_exists($folder)) {
		mkdir($folder);
	}
	$date = date('Y-m-d_H-i');
	$filename = 'product_export_'.$date.'.prex';
	$file = $folder.'/'.$filename;
	$extension = 2;
	while(file_exists($file)) {
		$filename = 'product_export_'.$date.'_'.$extension.'.prex';
		$file = $folder.'/'.$filename;
		$extension++;
	}
	return $file;
}

function exportAllProducts($conn) {
	$products = array();

	$data = execute($conn, "SELECT * FROM tl_ls_shop_product");
	
	foreach($data as $p) {
		$product = array();
		foreach($p as $key => $value) {
			$value = str_replace("'", "''", $value);
			if($key == 'lsShopProductMainImage') {
				$product[$key] = "UNHEX('".strtoupper(bin2hex($value))."')";
			} else if($key == 'configurator') {
				$alias = execute($conn, "SELECT alias FROM tl_ls_shop_configurator WHERE id='".$value."'")[0]['alias'];
				$product[$key] = $alias;
			} else if($key == 'pages') {
				$pages = unserialize($value);
				$npages = array();
				foreach($pages as $page) {
					$alias = execute($conn, "SELECT alias FROM tl_page WHERE id='".$page."'")[0]['alias'];
					array_push($npages, $alias);
				}
				$pages = serialize($npages);
				$product[$key] = $pages;
			} else if($key == 'lsShopProductAttributesValues') {
				$av = unserialize($value);
				$nav = array();
				foreach($av as $avi) {
					$attr = $avi[0];
					$val = $avi[1];
					$alias_a = execute($conn, "SELECT alias FROM tl_ls_shop_attributes WHERE id='".$attr."'")[0]['alias'];
					$alias_v = execute($conn, "SELECT alias FROM tl_ls_shop_attribute_values WHERE id='".$val."'")[0]['alias'];
					array_push($nav, array($alias_a, $alias_v));
				}
				$nav = serialize($nav);
				$product[$key] = $nav;
			} else if($key == 'lsShopProductSteuersatz') {
				$alias = execute($conn, "SELECT alias FROM tl_ls_shop_steuersaetze WHERE id='".$value."'")[0]['alias'];
				$product[$key] = $alias;
			} else if($key == 'lsShopProductDeliveryInfoSet') {
				$alias = execute($conn, "SELECT alias FROM tl_ls_shop_delivery_info WHERE id='".$value."'")[0]['alias'];
				$product[$key] = $alias;
			} else if($key == 'lsShopProductRecommendedProducts' || $key == 'associatedProducts') {
				$prds = unserialize($value);
				if(sizeof($prds) > 0) {
					$nprds = array();
					foreach($prds as $prd) {
						$alias = execute($conn, "SELECT alias FROM tl_ls_shop_product WHERE id='".$prd."'")[0]['alias'];
						array_push($nprds, $alias);
					}
					$prds = serialize($nprds);
					$product[$key] = $prds;
				} else {
					$product[$key] = '';
				}
			} else if(includes($key, 'description') || includes($key, 'title') || includes($key, 'keywords')) {
				$product[$key] = utf8_encode($value);
			} else {
				$product[$key] = $value;
			}

		}
		array_push($products, $product);
	}
	return $products;
}

function includes($haystack, $needle) {
	$includes = strpos(strtolower($haystack), $needle) !== false;;
	return $includes;
}

function exportAllVariants($conn) {
	$variants = array();

	$data = execute($conn, "SELECT * FROM tl_ls_shop_variant");
	
	foreach($data as $v) {
		$variant = array();
		foreach($v as $key => $value) {
			$value = str_replace("'", "''", $value);
			if($key == 'lsShopProductVariantMainImage') {
				$variant[$key] = "UNHEX('".strtoupper(bin2hex($value))."')";
			} else if($key == 'configurator') {
				$alias = execute($conn, "SELECT alias FROM tl_ls_shop_configurator WHERE id='".$value."'")[0]['alias'];
				$variant[$key] = $alias;
			} else if($key == 'lsShopProductVariantAttributesValues') {
				$av = unserialize($value);
				$nav = array();
				foreach($av as $avi) {
					$attr = $avi[0];
					$val = $avi[1];
					$alias_a = execute($conn, "SELECT alias FROM tl_ls_shop_attributes WHERE id='".$attr."'")[0]['alias'];
					$alias_v = execute($conn, "SELECT alias FROM tl_ls_shop_attribute_values WHERE id='".$val."'")[0]['alias'];
					array_push($nav, array($alias_a, $alias_v));
				}
				$nav = serialize($nav);
				$variant[$key] = $nav;
			} else if($key == 'lsShopVariantDeliveryInfoSet') {
				$alias = execute($conn, "SELECT alias FROM tl_ls_shop_delivery_info WHERE id='".$value."'")[0]['alias'];
				$variant[$key] = $alias;
			} else if($key == 'pid') {
				$alias = execute($conn, "SELECT alias FROM tl_ls_shop_product WHERE id='".$value."'")[0]['alias'];
				$variant[$key] = $alias;
			} else if(includes($key, 'description') || includes($key, 'title') || includes($key, 'keywords')) {
				$variant[$key] = utf8_encode($value);
			} else {
				$variant[$key] = $value;
			}

		}
		array_push($variants, $variant);
	}
	return $variants;
}



?>