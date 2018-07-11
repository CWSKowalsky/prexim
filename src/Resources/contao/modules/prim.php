<?php

	class Prim extends \BackendModule 
	{
		protected $strTemplate = 'be_prim';
		
		protected function compile() 
		{
			$this->import("Database");

			$this->Template->sts = 'Status: Warten auf Upload';
			$this->checkUpload();
			$this->checkImport();
		}

		public function checkUpload() {
			if(isset($_POST["submit"])) {
				$target_dir = "webuploads/";
				if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 0;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType == "prex") {
					$uploadOk = 1;
				}
				if($uploadOk == 1 && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$import = file_get_contents($target_file);
					$importarr = unserialize($import);
					$pram = sizeof($importarr['products']);
					$vaam = sizeof($importarr['variants']);
					if($pram > 0 || $vaam > 0) {
						$this->Template->sts = 'Status: Datei hochgeladen';
						$this->Template->scc = "Die Datei wurde erfolgreich hochgeladen (Produkte: $pram, Varianten: $vaam)";
						$this->Template->shimpbtn = true;
						$this->Template->ifile = $target_file;
					} else {
						$this->Template->sts = 'Status: Datei hochgeladen (fehlerhaft)';
						$this->Template->err = "Es wurden keine Produkte/Varianten in der Datei gefunden.";
					}
				} else {
					$this->Template->err = "Die Datei konnte nicht hochgeladen werden.";
				}
			}
		}

		public function checkImport() {
			if(isset($_POST['isubmit'])) {
				if(isset($_POST['ifile']) && file_exists($_POST['ifile'])) {
					$import = file_get_contents($_POST['ifile']);
					if(isset($import) && $import != '') {
						$importarr = unserialize($import);
						if(sizeof($importarr) > 0) {
							if(isset($importarr['products']) && isset($importarr['variants'])) {
								$pram = sizeof($importarr['products']);
								$vaam = sizeof($importarr['variants']);
								$this->import($importarr);
								$this->Template->sts = 'Status: Import abgeschlossen';
								$this->Template->scc = "Import erfolgreich (Produkte: $pram, Varianten: $vaam)";
								return;
							}
						}
					}
				}
				$this->Template->err = "Fehler beim importieren.";
			}
		}

		public function import($importarr) {
			$error_array = $this->importProducts($importarr['pr
			oducts']);
			print_r($error_array);
		}

		public function importProducts($productarr) {
			$conn = \Database::getInstance();
			$import_errors = array();

			$future_ids = array();
			$cautoincr = $conn->query("SELECT 'AUTO_INCREMENT' FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$GLOBALS['TL_CONFIG']['dbDatabase']."' AND TABLE_NAME='tl_ls_shop_product';")->execute()->fetchAllAssoc()[0]['AUTO_INCREMENT'];
			foreach($productarr as $product) {
				$product['id'] = $cautoincr;
				$future_ids[$product['alias']] = $cautoincr;
				$cautoincr++;
			}
			
			$nproducts = array();
			foreach($productarr as $product) {
				$nproduct = array();
				foreach($product as $key => $value) {
					if($key == 'lsShopProductMainImage') {
						$nproduct[$key] = $value;
					} else if($key == 'configurator') {
						if(isset($value)) {
							$id = $conn->prepare("SELECT id FROM tl_ls_shop_configurator WHERE alias='$value'")->execute()->fetchAllAssoc()[0]['id'];
							if(isset($id)) {
								$nproduct[$key] = $id;
							} else {
								array_push($import_errors, 'Couldn\'t find configurator with alias: '.$value);
							}
						}
					} else if($key == 'pages') {
						$pages = unserialize($value);
						$npages = array();
						foreach($pages as $page) {
							$id = $conn->prepare("SELECT id FROM tl_page WHERE alias='".$page."'")->execute()->fetchAllAssoc()[0]['id'];
							if(isset($id)) {
								array_push($npages, $id);
							} else {
								array_push($import_errors, 'Couldn\'t find page with alias: '.$page);
							}
						}
						$pages = serialize($npages);
						$product[$key] = "'".$pages."'";
					} else if($key == 'lsShopProductAttributesValues') {
						$av = unserialize($value);
						$nav = array();
						foreach($av as $avi) {
							$attr = $avi[0];
							$val = $avi[1];
							$id_a = $conn->prepare("SELECT id FROM tl_ls_shop_attributes WHERE alias='".$attr."'")->execute()->fetchAllAssoc()[0]['id'];
							$id_v = $conn->prepare("SELECT id FROM tl_ls_shop_attribute_values WHERE alias='".$val."'")->execute()->fetchAllAssoc()[0]['id'];
							if(!isset($id_a)) {
								array_push($import_errors, 'Couldn\'t find attribute with alias: '.$attr);
							}
							if(!isset($id_v)) {
								array_push($import_errors, 'Couldn\'t find attribute value with alias: '.$val);
							}
							if(isset($id_a) && isset($id_v)) {
								array_push($nav, array($id_a, $id_v));
							}
						}
						$nav = serialize($nav);
						$product[$key] = "'".$nav."'";
					} else if($key == 'lsShopProductSteuersatz') {
						$id = $conn->prepare("SELECT id FROM tl_ls_shop_steuersaetze WHERE alias='".$value."'")->execute()->fetchAllAssoc()[0]['id'];
						if(isset($id)) {
							$product[$key] = $id;
						} else {
							array_push($import_errors, 'Couldn\'t find tax rate with alias: '.$value);
						}
					} else if($key == 'lsShopProductDeliveryInfoSet') {
						$id = $conn->prepare("SELECT id FROM tl_ls_shop_delivery_info WHERE alias='".$value."'")->execute()->fetchAllAssoc()[0]['id'];
						if(isset($id)) {
							$product[$key] = $id;
						} else {
							array_push($import_errors, 'Couldn\'t find shop delivery info with alias: '.$value);
						}
					} else if($key == 'lsShopProductRecommendedProducts' || $key == 'associatedProducts') {
						$prds = unserialize($value);
						if(sizeof($prds) > 0) {
							$nprds = array();
							foreach($prds as $prd) {
								if(isset($prd)) {
									$id = $conn->prepare("SELECT id FROM tl_ls_shop_product WHERE alias='".$prd."'")->execute()->fetchAllAssoc()[0]['id'];
									if(isset($id)) {
										array_push($nprds, $id);
									} else {
										if(isset($future_ids[$prd])) {
											array_push($nprds, $future_ids[$prd]);
										} else {
											array_push($import_errors, 'Couldn\'t find product with alias: '.$prd);
										}
									}
								}
							}
							$prds = serialize($nprds);
							$product[$key] = $prds;
						} else {
							$product[$key] = '';
						}
					} else {
						$nproduct[$key] = "'".$value."'";
					}
				}
				array_push($nproducts, $nproduct);
			}

			$this->importArray('tl_ls_shop_product', $nproducts);

			return array_unique($import_errors);
		}
		
		public function importArray($table, $array) {
			//$columns = \Database::getInstance()->prepare("SHOW COLUMNS FROM tl_ls_shop_product;")->execute()->fetchAllAssoc();$columns[0]['Field'];
		}

	}

?>