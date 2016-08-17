<?php
	
	class ImageProfile extends Component {
	
	
		function ImageProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new Image($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "Image/ImageProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
		function setModelWithId($id) {
			$m = new Image($id);
			$this->setModel($m);
		}
		
	}





?>