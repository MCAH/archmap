<?php
	
	class EssayStudio extends Component {
	
	
		function EssayStudio($m = null) {
			parent::Component();
			
			if (! isset($model) ) {
				if($_GET['id']) {
					$m = new Essay($_REQUEST['id']);
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Essay/EssayStudio";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
		function setModelWithId($id) {
			$m = new Essay($id);
			$this->setModel($m);
		}
		
	}





?>