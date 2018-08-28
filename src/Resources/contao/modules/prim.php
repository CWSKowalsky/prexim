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
            if($_GET['validate'] === 'sp1') {
                $this->Template->sts = 'Validation about to start';
                $conn = \Database::getInstance();
                $response = $conn->prepare("SELECT id, scalePrice FROM tl_ls_shop_product;")->execute();
                $array = $response->fetchAllAssoc();
                $i = 0;
                foreach($array as $row) {
                    $id = $row['id'];
                    $scalePrice = json_encode(unserialize($row['scalePrice']));
                    $conn->prepare("UPDATE tl_ls_shop_product SET scalePrice='$scalePrice' WHERE id='$id';")->execute();
                    $i++;
                }
                $this->Template->sts = 'Validated '.$i.' scale prices';
            } else if($_GET['validate'] === 'sp2') {
                $this->Template->sts = 'Validation about to start';
                $conn = \Database::getInstance();
                $response = $conn->prepare("SELECT id, scalePrice FROM tl_ls_shop_product;")->execute();
                $array = $response->fetchAllAssoc();
                $i = 0;
                foreach($array as $row) {
                    $id = $row['id'];
                    $scalePrice = json_decode($row['scalePrice']);
                    $nscalePrice = [];
                    $j = 1;
                    $subarray = [];
                    foreach($scalePrice as $elm) {
                        array_push($subarray, $elm);
                        if($j % 2 == 0) {   //even
                            array_push($nscalePrice, $subarray);
                            $subarray = [];
                        }
                        $j++;
                    }
                    $nscalePrice = json_encode($nscalePrice);
                    $conn->prepare("UPDATE tl_ls_shop_product SET scalePrice='$nscalePrice' WHERE id='$id';")->execute();
                    $i++;
                }
                $this->Template->sts = 'Validated '.$i.' scale prices';
            } else if($_GET['validate'] == 'risp') {
                $conn = \Database::getInstance();
                $str = '{"FT100-7027":"a:0:{}","FT100-7101":"a:0:{}","FT100-7026":"a:0:{}","FT100-7025":"a:0:{}","FT100-7010":"a:0:{}","FT100-7005":"a:0:{}","FT100-7001":"a:0:{}","FT100-7140":"a:0:{}","FT100-7141":"a:0:{}","FT100-7142":"a:0:{}","FT100-7150":"a:0:{}","FT100-7201":"a:0:{}","FT100-7301":"a:0:{}","FT100-7341":"a:0:{}","FT100-7342":"a:0:{}","FT100-7343":"a:0:{}","FT100-7401":"a:0:{}","FT100-7601":"a:0:{}","FT100-7998":"a:0:{}","FT100-7999 M":"a:0:{}","FT100-7999 W":"a:0:{}","SO100-4702 M":"a:0:{}","SO100-4706 M":"a:0:{}","SO100-4709 M":"a:0:{}","SO100-4712 M":"a:0:{}","FT100-7904 M":"a:0:{}","FT100-7905 M":"a:0:{}","FT100-7006":"a:0:{}","FT100-7153":"a:0:{}","SI100-1000 X":"a:0:{}","VW015-1846 X":"a:0:{}","VW015-1847 X":"a:0:{}","VW015-1848 X":"a:0:{}","VW015-1849 X":"a:0:{}","VW015-1850 X":"a:0:{}","AR070-4200 X":"a:0:{}","AR070-4202 X":"a:0:{}","ADD - AR070-4202 X":"a:0:{}","AR070-4204 X":"a:0:{}","AR070-4206 X":"a:0:{}","ADD - AR070-4206 X":"a:0:{}","AR070-4208 X":"a:0:{}","AR070-4211 X":"a:0:{}","AR070-4213 X":"a:0:{}","AR070-4219 M":"a:0:{}","AR070-4220 M":"a:0:{}","AR070-4218 M":"a:0:{}","VW015-1858 X":"a:0:{}","VW015-1861 X":"a:0:{}","VW015-1845 X":"a:0:{}","VW015-3520 X":"a:0:{}","SK018-4002 X":"a:0:{}","SK018-4003 X":"a:0:{}","SK018-4041 X":"a:0:{}","SK018-4044 X":"a:0:{}","SK016-4026 M":"a:0:{}","SK016-4027 M":"a:0:{}","SK016-4028 M":"a:0:{}","SK018-4031 M":"a:0:{}","SK018-4006 M":"a:0:{}","SK018-4046 X":"a:10:{i:0;s:1:\"1\";i:1;s:3:\"636\";i:2;s:1:\"5\";i:3;s:3:\"613\";i:4;s:2:\"16\";i:5;s:3:\"594\";i:6;s:2:\"26\";i:7;s:3:\"576\";i:8;s:2:\"51\";i:9;s:3:\"558\";}","SK018-4049 X":"a:10:{i:0;s:1:\"1\";i:1;s:4:\"1416\";i:2;s:2:\"10\";i:3;s:4:\"1234\";i:4;s:2:\"20\";i:5;s:4:\"1097\";i:6;s:2:\"30\";i:7;s:4:\"1051\";i:8;s:2:\"40\";i:9;s:4:\"1051\";}","SI100-1001 X":"a:0:{}","RE003-4260 M":"a:0:{}","RE003-4261 M":"a:0:{}","BB018-1000 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"299\";i:2;s:2:\"50\";i:3;s:6:\"224.25\";i:4;s:3:\"200\";i:5;s:6:\"194.35\";i:6;s:3:\"500\";i:7;s:6:\"164.45\";}","BB018-1010 X":"a:8:{i:0;s:1:\"1\";i:1;s:2:\"85\";i:2;s:2:\"50\";i:3;s:2:\"51\";i:4;s:3:\"200\";i:5;s:2:\"51\";i:6;s:3:\"500\";i:7;s:2:\"51\";}","BB018-1020 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"209\";i:2;s:2:\"50\";i:3;s:6:\"156.75\";i:4;s:3:\"200\";i:5;s:6:\"135.85\";i:6;s:3:\"500\";i:7;s:5:\"94.05\";}","BB018-1030 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"379\";i:2;s:2:\"50\";i:3;s:6:\"284.25\";i:4;s:3:\"200\";i:5;s:6:\"246.35\";i:6;s:3:\"500\";i:7;s:6:\"170.55\";}","BB018-1040 X":"a:8:{i:0;s:1:\"1\";i:1;s:2:\"99\";i:2;s:2:\"50\";i:3;s:4:\"59.4\";i:4;s:3:\"200\";i:5;s:4:\"59.4\";i:6;s:3:\"500\";i:7;s:4:\"59.4\";}","BB018-1050 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"249\";i:2;s:2:\"50\";i:3;s:6:\"186.75\";i:4;s:3:\"200\";i:5;s:6:\"161.85\";i:6;s:3:\"500\";i:7;s:6:\"112.05\";}","BB018-1060 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"499\";i:2;s:2:\"50\";i:3;s:6:\"374.25\";i:4;s:3:\"200\";i:5;s:6:\"324.35\";i:6;s:3:\"500\";i:7;s:6:\"224.55\";}","BB018-1070 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"129\";i:2;s:2:\"50\";i:3;s:4:\"77.4\";i:4;s:3:\"200\";i:5;s:4:\"77.4\";i:6;s:3:\"500\";i:7;s:4:\"77.4\";}","BB018-1080 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"339\";i:2;s:2:\"50\";i:3;s:6:\"254.25\";i:4;s:3:\"200\";i:5;s:6:\"220.35\";i:6;s:3:\"500\";i:7;s:6:\"152.55\";}","BB017-1090 X":"a:6:{i:0;s:1:\"1\";i:1;s:3:\"600\";i:2;s:2:\"50\";i:3;s:3:\"504\";i:4;s:3:\"200\";i:5;s:3:\"408\";}","BB018-1036 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"169\";i:2;s:2:\"50\";i:3;s:6:\"126.75\";i:4;s:3:\"200\";i:5;s:6:\"109.85\";i:6;s:3:\"500\";i:7;s:5:\"76.05\";}","BB018-1046 X":"a:8:{i:0;s:1:\"1\";i:1;s:2:\"33\";i:2;s:2:\"50\";i:3;s:5:\"19.80\";i:4;s:3:\"200\";i:5;s:5:\"19.80\";i:6;s:3:\"500\";i:7;s:5:\"19.80\";}","BB018-1056 X":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"119\";i:2;s:2:\"50\";i:3;s:5:\"89.25\";i:4;s:3:\"200\";i:5;s:5:\"77.35\";i:6;s:3:\"500\";i:7;s:5:\"53.55\";}","CI019-19 2 00":"a:4:{i:0;s:1:\"2\";i:1;s:4:\"2700\";i:2;s:1:\"5\";i:3;s:4:\"2550\";}","CI019-19 2 03":"a:0:{}","CI019-19 2 10":"a:0:{}","CI019-19 2 11":"a:0:{}","CI019-19 2 13":"a:0:{}","CI019-19 2 14":"a:0:{}","CI019-19 2 15":"a:0:{}","CI019-19 2 17":"a:0:{}","CI019-19 2 18":"a:0:{}","CI019-19 2 19":"a:0:{}","CO017-1005 X":"a:4:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";}","CI019-19 2 21":"a:0:{}","CI019-19 2 22":"a:0:{}","CI019-19 2 23":"a:0:{}","CI019-19 2 25":"a:0:{}","CI019-19 3 00":"a:4:{i:0;s:1:\"2\";i:1;s:4:\"1440\";i:2;s:1:\"5\";i:3;s:4:\"1360\";}","CI019-19 3 03":"a:0:{}","CI019-19 3 10":"a:0:{}","CI019-19 3 11":"a:0:{}","CI019-19 3 13":"a:0:{}","CO018-1021":"a:4:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";}","CI019-19 3 14":"a:0:{}","CI019-19 3 15":"a:0:{}","CI019-19 4 00":"a:4:{i:0;s:1:\"2\";i:1;s:4:\"1170\";i:2;s:1:\"5\";i:3;s:4:\"1105\";}","CI019-19 4 03":"a:0:{}","CO018-1019":"a:4:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";}","CI019-19 4 10":"a:0:{}","CI019-19 4 11":"a:0:{}","CO017-1007 X":"a:4:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";}","CI019-19 4 13":"a:0:{}","CI019-19 4 14":"a:0:{}","CI019-19 4 15":"a:0:{}","CI019-19 1 00":"a:4:{i:0;s:1:\"2\";i:1;s:3:\"630\";i:2;s:1:\"5\";i:3;s:3:\"595\";}","CI019-19 1 03":"a:0:{}","CI019-19 1 10":"a:0:{}","CI019-19 1 11":"a:0:{}","CI019-19 5 00":"a:4:{i:0;s:1:\"2\";i:1;d:504;i:2;s:1:\"5\";i:3;d:476;}","CI019-19 5 10":"a:0:{}","CI019-19 5 11":"a:0:{}","CI019-19 6 00":"a:4:{i:0;s:1:\"1\";i:1;d:490;i:2;s:1:\"5\";i:3;d:245;}","CI019-19 6 10":"a:0:{}","CI019-11 11 13":"a:0:{}","CI019-19 6 15":"a:0:{}","CI019-11 11 16":"a:0:{}","CI019-19 2 50":"a:0:{}","CI019-19 2 60":"a:0:{}","CI019-11 12 51":"a:0:{}","CI019-19 2 70":"a:0:{}","CI019-19 2 30":"a:0:{}","CI019-19 2 32":"a:0:{}","CI019-19 2 31":"a:0:{}","CI019-19 2 33":"a:0:{}","CI019-11 11 10":null,"CO018-1017":"a:4:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";}","CO018-1015":"a:4:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";}","SM100-3953 M":null,"SK018-4014 M":"a:0:{}","AR070-4214 X":"a:0:{}","AR070-4215 X":"a:0:{}","SM100-3952 M":null,"CI019-19 1 30":"a:0:{}","CI019-19 1 31":"a:0:{}","CI019-19 1 32":"a:0:{}","CI019-19 1 33":"a:0:{}","CO018-1005":"a:6:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";i:4;s:1:\"5\";i:5;s:3:\"450\";}","CO018-1010":"a:6:{i:0;s:1:\"1\";i:1;s:3:\"650\";i:2;s:1:\"2\";i:3;s:3:\"550\";i:4;s:1:\"5\";i:5;s:3:\"450\";}","BB018 - 893645001736":"a:6:{i:0;s:1:\"1\";i:1;s:3:\"600\";i:2;s:2:\"50\";i:3;s:3:\"504\";i:4;s:3:\"200\";i:5;s:3:\"408\";}","BB018 - 893645001743":"a:6:{i:0;s:1:\"1\";i:1;s:3:\"600\";i:2;s:2:\"50\";i:3;s:3:\"504\";i:4;s:3:\"200\";i:5;s:3:\"408\";}","BB - SP - 893645001514":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"299\";i:2;s:2:\"50\";i:3;s:6:\"224.25\";i:4;s:3:\"200\";i:5;s:6:\"194.35\";i:6;s:3:\"500\";i:7;s:6:\"164.45\";}","BB - SP - 893645001521":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"299\";i:2;s:2:\"50\";i:3;s:6:\"224.25\";i:4;s:3:\"200\";i:5;s:6:\"194.35\";i:6;s:3:\"500\";i:7;s:6:\"164.45\";}","BB - SP - 893645001538":"a:8:{i:0;s:1:\"1\";i:1;s:3:\"299\";i:2;s:2:\"50\";i:3;s:6:\"224.25\";i:4;s:3:\"200\";i:5;s:6:\"194.35\";i:6;s:3:\"500\";i:7;s:6:\"164.45\";}","AR070-4209 X":"a:0:{}","AR070-4212 X":"a:0:{}","AR070-4210 X":"a:0:{}","Aktion - SK018-4044 X":"a:4:{i:0;s:1:\"5\";i:1;s:9:\"1007.7500\";i:2;s:2:\"10\";i:3;s:6:\"971.25\";}","Aktion - SK018-4041 X":"a:6:{i:0;s:1:\"1\";i:1;s:5:\"504.5\";i:2;s:1:\"5\";i:3;s:6:\"487.25\";i:4;s:2:\"16\";i:5;s:3:\"473\";}","CI019-19 1 00 - AKTION":"a:4:{i:0;s:1:\"2\";i:1;s:3:\"630\";i:2;s:1:\"5\";i:3;s:3:\"595\";}","CI019-19 2 00 - AKTION":"a:4:{i:0;s:1:\"2\";i:1;s:4:\"2700\";i:2;s:1:\"5\";i:3;s:4:\"2550\";}","CI019-19 1 10 - AKTION":"a:0:{}","CI019-19 2 10 - AKTION":"a:0:{}","CI019-19 2 11 - AKTION":"a:0:{}","CI019-19 2 13 - AKTION":"a:0:{}","CI019-19 2 14 - AKTION":"a:0:{}","CI019-19 2 03 - AKTION":"a:0:{}","CI019-19 2 15 - AKTION":"a:0:{}","CI019-19 2 17 - AKTION":"a:0:{}","CI019-19 2 19 - AKTION":"a:0:{}","CI019-19 2 18 - AKTION":"a:0:{}","CI019-19 2 21 - AKTION":"a:2:{i:0;s:0:\"\";i:1;s:0:\"\";}","CI019-19 2 22 - AKTION":"a:0:{}","CI019-19 2 23 - AKTION":"a:0:{}","CI019-19 2 25 - AKTION":"a:0:{}","CI019-19 2 50 - AKTION":"a:0:{}","CI019-19 2 60 - AKTION":"a:0:{}","CI019-19 3 00 - AKTION":"a:4:{i:0;s:1:\"2\";i:1;s:4:\"1440\";i:2;s:1:\"5\";i:3;s:4:\"1360\";}","CI019-19 3 03 - AKTION":"a:0:{}","CI019-19 3 10 - AKTION":"a:0:{}","CI019-19 3 11 - AKTION":"a:0:{}","CI019-19 3 13 - AKTION":"a:0:{}","CI019-19 3 14 - AKTION":"a:0:{}","CI019-19 3 15 - AKTION":"a:0:{}","CI019-19 4 00 - AKTION":"a:4:{i:0;s:1:\"2\";i:1;s:4:\"1170\";i:2;s:1:\"5\";i:3;s:4:\"1105\";}","CI019-19 4 03 - AKTION":"a:0:{}","CI019-19 4 10 - AKTION":"a:0:{}","CI019-19 4 11 - AKTION":"a:0:{}","CI019-19 4 13 - AKTION":"a:0:{}","CI019-19 4 14 - AKTION":"a:0:{}","CI019-19 4 15 - AKTION":"a:0:{}","CI019-19 1 03 - AKTION":"a:0:{}","CI019-19 1 11 - AKTION":"a:0:{}","CI019-19 2 04 - AKTION":null,"CI019-19 3 04 - AKTION":"a:0:{}","CI019-19 4 04 - AKTION":"a:0:{}","CI019-19 1 04 - AKTION":"a:0:{}","VW18-GaLaBau-2018-Messespecial":null}';
                $arr = json_decode($str);
                foreach($arr as $lsShopProductCode => $scalePrice) {
                    $conn->prepare("UPDATE tl_ls_shop_product SET scalePrice='$scalePrice' WHERE lsShopProductCode='$lsShopProductCode';")->execute();
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
						$av = json_encode($value);
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
						$av = json_encode($value);
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