<?php

	class Prim extends \BackendModule 
	{
		protected $strTemplate = 'be_prim';
		
		protected function compile() 
		{
			//$this->import("Database");

			$this->Template->sts = 'Status: Warten auf Upload';
			$this->checkUpload();
			$this->checkImport();

			if($_GET['fixattr'] == 'prd') {
				$result = \Database::getInstance()->prepare("SELECT id, lsShopProductAttributesValues FROM tl_ls_shop_product")->execute();
				$result = $result->fetchAllAssoc();
				foreach($result as $row) {
					$attr = unserialize($row['lsShopProductAttributesValues']);
					$attr_str = json_encode($attr);
					\Database::getInstance()->prepare("UPDATE tl_ls_shop_product SET lsShopProductAttributesValues='$attr_str' WHERE id=".$row['id'])->execute();
				}
			} else if($_GET['fixattr'] == 'vrt') {
				$result = \Database::getInstance()->prepare("SELECT id, lsShopProductVariantAttributesValues FROM tl_ls_shop_variant")->execute();
				$result = $result->fetchAllAssoc();
				foreach($result as $row) {
					$attr = unserialize($row['lsShopProductVariantAttributesValues']);
					$attr_str = json_encode($attr);
					\Database::getInstance()->prepare("UPDATE tl_ls_shop_variant SET lsShopProductVariantAttributesValues='$attr_str' WHERE id=".$row['id'])->execute();
				}
			}

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
								$this->runimport($importarr);
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

		public function runimport($importarr) {
			$error_array = $this->importProductsAndVariants($importarr);
		}

		public function importProductsAndVariants($importarr) {
			$productarr = $importarr['products'];
			$variantarr = $importarr['variants'];

			$conn = \Database::getInstance();
			$import_errors = array();

			$future_ids = array();
			$cautoincr = $conn->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$GLOBALS['TL_CONFIG']['dbDatabase']."' AND TABLE_NAME='tl_ls_shop_product';")->execute()->fetchAllAssoc()[0]['AUTO_INCREMENT'];
			for($i = 0; $i < sizeof($productarr); $i++) {
				$productarr[$i]['id'] = $cautoincr;
				$future_ids[$productarr[$i]['alias']] = $cautoincr;
				$cautoincr++;
			}

			$cautoincrv = $conn->prepare("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$GLOBALS['TL_CONFIG']['dbDatabase']."' AND TABLE_NAME='tl_ls_shop_variant';")->execute()->fetchAllAssoc()[0]['AUTO_INCREMENT'];
			for($i = 0; $i < sizeof($variantarr); $i++) {
				$variantarr[$i]['id'] = $cautoincrv;
				$cautoincrv++;
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
						$nproduct[$key] = "'".$pages."'";
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
						$nav = json_encode($nav);
						$nproduct[$key] = "'".$nav."'";
					} else if($key == 'lsShopProductSteuersatz') {
						$id = $conn->prepare("SELECT id FROM tl_ls_shop_steuersaetze WHERE alias='".$value."'")->execute()->fetchAllAssoc()[0]['id'];
						if(isset($id)) {
							$nproduct[$key] = $id;
						} else {
							array_push($import_errors, 'Couldn\'t find tax rate with alias: '.$value);
						}
					} else if($key == 'lsShopProductDeliveryInfoSet') {
						$id = $conn->prepare("SELECT id FROM tl_ls_shop_delivery_info WHERE alias='".$value."'")->execute()->fetchAllAssoc()[0]['id'];
						if(isset($id)) {
							$nproduct[$key] = $id;
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
							$nproduct[$key] = "'".$prds."'";
						} else {
							$nproduct[$key] = "''";
						}
					} else {
						$nproduct[$key] = "'".$value."'";
					}
				}
				array_push($nproducts, $nproduct);
			}


			$nvariants = array();
			foreach($variantarr as $variant) {
				$nvariant = array();
				foreach($variant as $key => $value) {
					if($key == 'lsShopProductVariantMainImage') {
						$nvariant[$key] = $value;
					} else if($key == 'configurator') {
						if(isset($value)) {
							$id = $conn->prepare("SELECT id FROM tl_ls_shop_configurator WHERE alias='$value'")->execute()->fetchAllAssoc()[0]['id'];
							if(isset($id)) {
								$nvariant[$key] = $id;
							} else {
								array_push($import_errors, 'Couldn\'t find configurator with alias: '.$value);
							}
						}
					} else if($key == 'lsShopProductVariantAttributesValues') {
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
						$nvariant[$key] = "'".$nav."'";
					} else if($key == 'lsShopVariantDeliveryInfoSet') {
						$id = $conn->prepare("SELECT id FROM tl_ls_shop_delivery_info WHERE alias='".$value."'")->execute()->fetchAllAssoc()[0]['id'];
						if(isset($id)) {
							$nvariant[$key] = $id;
						} else {
							array_push($import_errors, 'Couldn\'t find shop delivery info with alias: '.$value);
						}
					} else if($key == 'pid') {
						$id = $conn->prepare("SELECT id FROM tl_ls_shop_product WHERE alias='".$value."'")->execute()->fetchAllAssoc()[0]['id'];
						if(isset($id)) {
							$nvariant[$key] = $id;
						} else {
							if(isset($future_ids[$value])) {
								$nvariant[$key] = $future_ids[$value];
							} else {
								array_push($import_errors, 'Couldn\'t find product with alias: '.$value);
							}
						}
					}else {
						$nvariant[$key] = "'".$value."'";
					}
				}
				array_push($nvariants, $nvariant);


			}

			$this->importArray('tl_ls_shop_product', $nproducts);
			$this->importArray('tl_ls_shop_variant', $nvariants);

			return array_unique($import_errors);
		}
		
		public function importArray($table, $array) {

			$conn = \Database::getInstance();

			$columns = $conn->prepare("SHOW COLUMNS FROM $table;")->execute()->fetchAllAssoc();
			$fields = array();
			foreach($columns as $column) {
				array_push($fields, $column['Field']);
			}

			//INSERT INTO tl_ls_shop_product (col1, col2, col3, col4, col5) VALUES ('val1', 'val2', 'val3', 'val4', 'val5');

			$cols = implode(', ', $fields);
			foreach($array as $entry) {
				$sql = "INSERT INTO $table ($cols) VALUES (";
				foreach($fields as $field) {
					$val = $entry[$field];
					if(isset($val)) {
						$sql .= $val.', ';
					} else {
						$sql .= "'', ";
					}
				}
				$sql = substr($sql, 0, -2);

				$sql.=');';
				//echo $sql.'<br><br><br>';
				$conn->prepare($sql)->execute();
			}

		}

	}

?>