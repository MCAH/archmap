<?php
	
	class HistoricalObjectProfile extends Component {
	
	
		function HistoricalObjectProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new HistoricalObject($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "HistoricalObject/HistoricalObjectProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
		function setModelWithId($id) {
			$m = new HistoricalObject($id);
			$this->setModel($m);
		}
		
	}





?>