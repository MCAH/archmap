<?php
	
	class PlaceProfile extends Component {
	
	
		function PlaceProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new Place($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Place/PlaceProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			
		}
		
		function setModelWithId($id) {
			$m = new Place($id);
			$this->setModel($m);
		}
		
	}





?>