<?php

	class Prim extends \BackendModule 
	{
		protected $strTemplate = 'be_prim';
		
		protected function compile() 
		{
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
					$import = file_get_contents($target_file);
					if(isset($import) && $import != '') {
						$importarr = unserialize($import);
						if(sizeof($importarr) > 0) {
							if(isset($importarr['products']) && isset($importarr['variants'])) {
								$pram = sizeof($importarr['products']);
								$vaam = sizeof($importarr['variants']);
								$this->import($importarr);
								$this->Template->sts = 'Status: Import abgeschlossen';
								$this->Template->scc = "Import erfolgreich (Produkte: $pram, Varianten: $vaam)";
							}
						}
					}
				}
			} else {
				$this->Template->err = "Fehler beim importieren.";
			}
		}

		public function import($importarr) {
			//TODO
		}

	}

?>