<?php
	ini_set("memory_limit","256M");
	
	error_reporting(E_ERROR | E_PARSE);

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');


	$id = $_REQUEST['id'];
	$request = $_REQUEST['request'];
	
	$b = new Building($id);
	
	if ($request) {
		switch($request) {
			case "floorplan":
			

				$image = $b->floorplan();
				
				echo $image->asXMLAttributes();
				break;
			case "lat_section":
				$image = $b->lat_section();
				echo $image->asXMLAttributes();
				break;
			
			
			case "lng_section":
				$image = $b->lng_section();
				echo $image->asXMLAttributes();
				break;
				
			case "drawings":
				$image_rows = $b->getRelatedItems('Image',false,'drawing');
				
				if ($image_rows) {
					foreach($image_rows as $image_row) {
						$image = new Image('ROW', $image_row);
						$xml .= $image->asXMLAttributes();
					}
				}
				echo '<drawings>'. $xml.'</drawings>';				 
				break;
		}
	}

	
	//$xml = $b->asXml();

//	print_r($xml);




?>