<?php
	
	class ListView extends Component {
	
		function ListView() {
			parent::Component();

		}
		function getPathName() {
			return "ListView";
		}


		
		function process($node = null) {
			$output = "";
			foreach($this->dataSource as $data) {
				$output .= '<div style="margin:3; padding:3;"><a style="text-decoration: none;" href="?id='.$data->get('id') .'">'.$data->get('name') . '</a></div>';		
			}
			return $output;
		}
	}





?>