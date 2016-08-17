<?php
	
	class Profile extends Component {
	
	
		function Profile($m = null) {
			parent::Component();
			if (! isset($model) ) {
				if($_GET['id']) {
					$m = new Building($_GET['id']);
				}
			}
			$this->setModel($m);
		}
		
		function getPathName() {
			return "Profile/Profile";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
	}





?>