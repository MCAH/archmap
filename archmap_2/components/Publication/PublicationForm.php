<?php
	
	class PublicationForm extends Component {
	
	
		function PublicationForm($m = null) {
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
			return "Publication/PublicationForm";
		}

		function setModel($m){
		
			parent::setModel($m);
			
			if ($m && $m->get('isCatalog')) {
				$this->attributes["isCatalogChecked"] = 'checked="true"';
			} else {
				$this->attributes["isCatalogChecked"] = "";

			}
			
			$this->attributes["greeting"] = "Hey Y'all!";
			$this->attributes["pubtypeName"] = $m->getPubtypeName();
			
		}
		
		function setModelWithId($id) {
			$m = new Publication($id);
			$this->setModel($m);
			$this->attributes["pubtypeName"] = getEntity($m->getPubtypeName());
			
		}
		
	}





?>