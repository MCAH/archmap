<?php
	
	class EssayProfile extends Component {
	
	
		function EssayProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new Essay($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Essay/EssayProfile";
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