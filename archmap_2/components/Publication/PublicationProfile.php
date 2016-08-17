<?php
	
	class PublicationProfile extends Component {
	
	
		function PublicationProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new Publication($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Publication/PublicationProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			
		}
		
		function setModelWithId($id) {
			$m = new Publication($id);
			$this->setModel($m);
		}
		
	}





?>