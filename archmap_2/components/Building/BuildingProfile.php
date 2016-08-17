<?php
	
	class BuildingProfile extends Component {
	
	
		function BuildingProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new Building($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Building/BuildingProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
		function setModelWithId($id) {
			$m = new Building($id);
			$this->setModel($m);
		}
		
	}





?>