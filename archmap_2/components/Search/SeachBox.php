<?php
	
	class SearchBox extends Component {
	
		function SearchBox($templateFile = null) {
			parent::Component($templateFile);
			

			$collection 		= new Collection(1);
			//$this->dataSource 	= $collection->getBuildings();
			
			//if (isset($_GET['id'])) {
			//	$this->model = new Building($_GET['id']);
			//} else {
			//	$this->model = $collection->getFirstBuilding();
				
			//}
		}


		function getPathName() {
			return "Search/SearchBox";
		}




		
	}





?>