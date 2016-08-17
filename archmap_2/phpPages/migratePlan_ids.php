<?php

	require_once("../Database.php");
	header("Content-type:text/plain");
	$db = new Database();
	
	$doBourb = true;
	
	if ($doBourb) {
	
		// get post-bourb buildings
		$building_rows = $db->queryAssoc("SELECT * FROM building WHERE id < 350");
		
		foreach($building_rows as $building_row) {
			print "\n\n";
			
			$building = new Building($building_row);
			$plan_image_id = null;
			
			$iq = 'select * from image where building_id='.$building->get("id").' and element_type="pl"';
			
			//print($iq . "<br />");
			$irows = null;
			$irows = $db->queryAssoc($iq);
			
			
			print($building->get("id") . ' -- ' . sizeof($irows) . '..' . $irows[0]["id"]. '  ' . $irows[0]["filename"]);
					
		
			//$plan_image_id = $building->whichIsPosterRedux(21,2);
			if ( sizeof($irows) > 0){
				$plan_image_id = $irows[0]["id"];
			  
				print ( '<br /> ---------- ' . $building->get("name"). ' image_id = ' . $plan_image_id . "\n");
				
				if ($plan_image_id && $plan_image_id != "") {
					//$building->set("lat_section_image_id", $plan_image_id);
					$building->set("plan_image_id", $plan_image_id);
					$building->saveChanges();
				}
		
			}
			
		}
		
	} else {
	
		// get post-bourb buildings
		$building_rows = $db->queryAssoc("SELECT * FROM building WHERE id > 1000");
		
		foreach($building_rows as $building_row) {
			print "\n\n";
			
			$building = new Building($building_row);
			$plan_image_id = null;
			$plan_image_id = $building->whichIsPosterRedux(21,2);
			
			
			print ( $building->get("name"). ' image_id = ' . $plan_image_id . "\n");
			
			if ($plan_image_id && $plan_image_id != "") {
				$building->set("lat_section_image_id", $plan_image_id);
				$building->saveChanges();
			}
			
			
		}
	
	}

?>