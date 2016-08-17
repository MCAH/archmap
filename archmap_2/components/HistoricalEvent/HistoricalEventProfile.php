<?php
	
	class HistoricalEventProfile extends Component {
	
	
		function HistoricalEventProfile($m = null) {
			parent::Component();
			
			
			if (! isset($model) ) {
				
				if($_REQUEST['id']) {
				
					$m = new HistoricalEvent($_REQUEST['id']);
				} else {
					printline("NO ID");
				}
			}
			$this->setModel($m);
		}
		
		
		
		function getPathName() {
			return "HistoricalEvent/HistoricalEventProfile";
		}

		function setModel($m){
		
			parent::setModel($m);
			$this->attributes["greeting"] = "Hey Y'all!";
		}
		
		function setModelWithId($id) {
			$m = new HistoricalEvent($id);
			$this->setModel($m);
		}
		
	}





?>