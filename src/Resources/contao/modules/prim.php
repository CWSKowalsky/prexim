<?php

	class Prim extends \BackendModule 
	{
		protected $strTemplate = 'be_prim';
		
		protected function compile() 
		{
			$this->checkUpload();
			$this->Template->sts = 'Status: Import ausstehend';
			$this->Template->sts = 'Status: Import abgeschlossen';
		}

		public function checkUpload() {
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 0;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if(isset($_POST["submit"])) {
				if($imageFileType == "prex") {
					$uploadOk = 1;
				}
			}
			if($uploadOk == 1 && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$this->Template->scc = "Die Datei wurde erfolgreich hochgeladen!";
			} else {
				$this->Template->err = "Die Datei konnte nicht hochgeladen werden.";
			}
			$import = file_get_contents($target_file);
			$this->import($import);
		}

		public function import($import) {
			$this->Template->sts = 'Status: Import ausstehend: '.strlen($import);
		}

	}

?>