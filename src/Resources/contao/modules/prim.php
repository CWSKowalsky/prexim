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

			if($_GET['test'] == 'exec') {
				$this->exec();
				echo 'OK';
				die();
			}

		}

		public function exec() {
			$str = 'a:152:{s:10:"FT100-7027";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7101";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7026";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7025";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7010";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7005";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7001";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7140";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7141";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7142";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7150";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7201";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7301";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7341";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7342";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7343";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7401";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7601";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7998";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:12:"FT100-7999 M";N;s:12:"FT100-7999 W";N;s:12:"SO100-4702 M";s:32:"34DCCD0FBD5011E69C9CFCAA142A08AA";s:12:"SO100-4706 M";s:32:"45CF0882BD5011E69C9CFCAA142A08AA";s:12:"SO100-4709 M";s:32:"AC076A04BD5111E69C9CFCAA142A08AA";s:12:"SO100-4712 M";s:32:"34DCCD06BD5011E69C9CFCAA142A08AA";s:12:"FT100-7904 M";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:12:"FT100-7905 M";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7006";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:10:"FT100-7153";s:32:"09D5AEB48B2011E69C9CFCAA142A08AA";s:12:"SI100-1000 X";s:32:"4B244AD1D91E11E69C9CFCAA142A08AA";s:12:"VW015-1846 X";s:32:"31D9892E6B7511E6AF0A1C872C5FA596";s:12:"VW015-1847 X";N;s:12:"VW015-1848 X";N;s:12:"VW015-1849 X";s:32:"D10E87108BD511E69C9CFCAA142A08AA";s:12:"VW015-1850 X";N;s:12:"AR070-4200 X";s:32:"B23E395BFCD211E6A579FCAA142DA146";s:12:"AR070-4202 X";s:32:"A447F197FCD811E6A579FCAA142DA146";s:18:"ADD - AR070-4202 X";s:32:"A447F197FCD811E6A579FCAA142DA146";s:12:"AR070-4204 X";s:32:"B23E3951FCD211E6A579FCAA142DA146";s:12:"AR070-4206 X";s:32:"A447F18EFCD811E6A579FCAA142DA146";s:18:"ADD - AR070-4206 X";s:32:"A447F18EFCD811E6A579FCAA142DA146";s:12:"AR070-4208 X";s:32:"B269B9CEFCD211E6A579FCAA142DA146";s:12:"AR070-4211 X";s:32:"0CE67C7DFCD811E6A579FCAA142DA146";s:12:"AR070-4213 X";s:32:"0A215669FCD811E6A579FCAA142DA146";s:12:"AR070-4219 M";s:32:"46D46833FCD911E6A579FCAA142DA146";s:12:"AR070-4220 M";s:32:"46D46833FCD911E6A579FCAA142DA146";s:12:"AR070-4218 M";s:32:"46D46833FCD911E6A579FCAA142DA146";s:12:"VW015-1858 X";s:32:"742CE7558BD311E69C9CFCAA142A08AA";s:12:"VW015-1861 X";s:32:"F1A923568BD611E69C9CFCAA142A08AA";s:12:"VW015-1845 X";s:32:"5E1BDE188BD811E69C9CFCAA142A08AA";s:12:"VW015-3520 X";N;s:12:"SK018-4002 X";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK018-4003 X";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK018-4041 X";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK018-4044 X";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK016-4026 M";s:32:"4D4586678AD611E69C9CFCAA142A08AA";s:12:"SK016-4027 M";s:32:"139448148AD911E69C9CFCAA142A08AA";s:12:"SK016-4028 M";s:32:"4BCE090B8ADB11E69C9CFCAA142A08AA";s:12:"SK018-4031 M";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK018-4006 M";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK018-4046 X";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SK018-4049 X";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"SI100-1001 X";s:32:"4B244AD1D91E11E69C9CFCAA142A08AA";s:12:"RE003-4260 M";s:32:"DC420603FCD911E6A579FCAA142DA146";s:12:"RE003-4261 M";s:32:"0CBBCB0AFCDA11E6A579FCAA142DA146";s:12:"BB018-1000 X";s:32:"3E83E1D13EF911E88A01FCAA142DA146";s:12:"BB018-1010 X";s:32:"3E83E1D13EF911E88A01FCAA142DA146";s:12:"BB018-1020 X";s:32:"3E83E1D13EF911E88A01FCAA142DA146";s:12:"BB018-1030 X";s:32:"3E64504E3EF911E88A01FCAA142DA146";s:12:"BB018-1040 X";s:32:"3E64504E3EF911E88A01FCAA142DA146";s:12:"BB018-1050 X";s:32:"3E64504E3EF911E88A01FCAA142DA146";s:12:"BB018-1060 X";s:32:"3E6450573EF911E88A01FCAA142DA146";s:12:"BB018-1070 X";s:32:"3E6450573EF911E88A01FCAA142DA146";s:12:"BB018-1080 X";s:32:"3E6450573EF911E88A01FCAA142DA146";s:12:"BB017-1090 X";s:32:"D9F90E0803EF11E7A579FCAA142DA146";s:12:"BB018-1036 X";s:32:"3E83E1DA3EF911E88A01FCAA142DA146";s:12:"BB018-1046 X";s:32:"3E83E1DA3EF911E88A01FCAA142DA146";s:12:"BB018-1056 X";s:32:"3E83E1DA3EF911E88A01FCAA142DA146";s:13:"CI019-19 2 00";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 03";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 10";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 11";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 13";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 14";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 15";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 17";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 18";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 19";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:12:"CO017-1005 X";s:32:"499F7CD8BDF511E69C9CFCAA142A08AA";s:13:"CI019-19 2 21";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 22";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 23";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 25";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 3 00";s:32:"013663E18EFA11E7A579FCAA142DA146";s:13:"CI019-19 3 03";s:32:"013663E18EFA11E7A579FCAA142DA146";s:13:"CI019-19 3 10";s:32:"013663E18EFA11E7A579FCAA142DA146";s:13:"CI019-19 3 11";s:32:"013663E18EFA11E7A579FCAA142DA146";s:13:"CI019-19 3 13";s:32:"013663E18EFA11E7A579FCAA142DA146";s:10:"CO018-1021";s:32:"8DB2159B30D011E88A01FCAA142DA146";s:13:"CI019-19 3 14";s:32:"013663E18EFA11E7A579FCAA142DA146";s:13:"CI019-19 3 15";s:32:"013663E18EFA11E7A579FCAA142DA146";s:13:"CI019-19 4 00";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:13:"CI019-19 4 03";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:10:"CO018-1019";s:32:"8DB2159B30D011E88A01FCAA142DA146";s:13:"CI019-19 4 10";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:13:"CI019-19 4 11";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:12:"CO017-1007 X";s:32:"499F7CD8BDF511E69C9CFCAA142A08AA";s:13:"CI019-19 4 13";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:13:"CI019-19 4 14";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:13:"CI019-19 4 15";s:32:"00FBA5838EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 00";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 03";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 10";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 11";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 5 00";s:32:"00FBA58E8EFA11E7A579FCAA142DA146";s:13:"CI019-19 5 10";s:32:"00FBA58E8EFA11E7A579FCAA142DA146";s:13:"CI019-19 5 11";s:32:"00FBA58E8EFA11E7A579FCAA142DA146";s:13:"CI019-19 6 00";s:32:"2F8102FAD92911E69C9CFCAA142A08AA";s:13:"CI019-19 6 10";s:32:"2F8102FAD92911E69C9CFCAA142A08AA";s:14:"CI019-11 11 13";s:32:"947015FCD92611E69C9CFCAA142A08AA";s:13:"CI019-19 6 15";s:32:"B14B7E23D92011E69C9CFCAA142A08AA";s:14:"CI019-11 11 16";s:32:"F342E61FD92711E69C9CFCAA142A08AA";s:13:"CI019-19 2 50";s:32:"E11FAA93D92A11E69C9CFCAA142A08AA";s:13:"CI019-19 2 60";s:32:"3789714FD92A11E69C9CFCAA142A08AA";s:14:"CI019-11 12 51";s:32:"947015FCD92611E69C9CFCAA142A08AA";s:13:"CI019-19 2 70";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 30";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 32";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 31";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:13:"CI019-19 2 33";s:32:"0123BD2B8EFA11E7A579FCAA142DA146";s:14:"CI019-11 11 10";s:32:"947015FCD92611E69C9CFCAA142A08AA";s:10:"CO018-1017";s:32:"8DB2159B30D011E88A01FCAA142DA146";s:10:"CO018-1015";s:32:"8DB2159B30D011E88A01FCAA142DA146";s:12:"SM100-3953 M";s:32:"BB5E589FD97511E69C9CFCAA142A08AA";s:12:"SK018-4014 M";s:32:"4C38644285DC11E69C9CFCAA142A08AA";s:12:"AR070-4214 X";s:32:"A447F197FCD811E6A579FCAA142DA146";s:12:"AR070-4215 X";s:32:"A447F18EFCD811E6A579FCAA142DA146";s:12:"SM100-3952 M";s:32:"C9269B835B1D11E7A579FCAA142DA146";s:13:"CI019-19 1 30";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 31";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 32";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:13:"CI019-19 1 33";s:32:"0123BD368EFA11E7A579FCAA142DA146";s:10:"CO018-1005";s:32:"8DB2159B30D011E88A01FCAA142DA146";s:10:"CO018-1010";s:32:"8DB2159B30D011E88A01FCAA142DA146";s:20:"BB018 - 893645001736";s:32:"3E9A32A03EF911E88A01FCAA142DA146";s:20:"BB018 - 893645001743";s:32:"3E9A32A03EF911E88A01FCAA142DA146";s:22:"BB - SP - 893645001514";s:32:"3E9A32A93EF911E88A01FCAA142DA146";s:22:"BB - SP - 893645001521";s:32:"3E9A32A93EF911E88A01FCAA142DA146";s:22:"BB - SP - 893645001538";s:32:"3E9A32A93EF911E88A01FCAA142DA146";s:12:"AR070-4209 X";s:32:"B269B9CEFCD211E6A579FCAA142DA146";s:12:"AR070-4212 X";s:32:"0A215669FCD811E6A579FCAA142DA146";s:12:"AR070-4210 X";s:32:"0CE67C7DFCD811E6A579FCAA142DA146";}';
			$arr = unserialize($str);

			$conn = \Database::getInstance();
			foreach($arr as $key => $item) {
				$conn->prepare("UPDATE tl_ls_shop_product SET lsShopProductMainImage=X'$item' WHERE lsShopProductCode='$value'")->execute();
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
						$nav = serialize($nav);
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