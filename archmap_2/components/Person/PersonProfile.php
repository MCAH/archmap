<?php
	
	class PersonProfile extends Component {
	
	
		function PersonProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new Person($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Person/PersonProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
		function setModelWithId($id) {
			$m = new Person($id);
			$this->setModel($m);
		}
		
	}





?>