<?php

	require_once("../Database.php");
	header("Content-type:text/html");
	$db = new Database();


	$sql = "SELECT p.id, p.image_id, i.building_id, i.orig_filename, i.width, i.height, p.xloc, p.yloc, p.pos_x, p.pos_y FROM image_plot p, image i WHERE i.id = p.image_id AND i.building_id=1016 AND xloc IS NOT NULL AND pos_x IS NULL LIMIT 0,200";
	
	//$sql = "SELECT p.id as pid, p.image_id, i.building_id, i.orig_filename, i.width, i.height, p.xloc, p.yloc, p.pos_x, p.pos_y FROM image_plot p LEFT JOIN image i WHERE i.building_id=1016 AND xloc IS NOT NULL AND pos_x IS NULL LIMIT 0,200";
	
	
	$rows = $db->queryAssoc($sql);
	
	$i = 1;
	
	foreach($rows as $row) {
		
		if ("".$row['width'] == "" || "".$row['height'] == "")
		{
			continue;
		}
			
		
		if ($row['width'] > $row['height']) 
		{
			$width = 700;
			
			$height = $width * $row['height']/$row['width'];
			
		}
		else 
		{
			$height = 700;
			
			$width = $height * $row['width']/$row['height'];
		
			
		}
		
		$pos_x = $row['xloc']  / $width;
		
		$pos_y =  $row['yloc'] / $height;

	
	
		print($i . ') ' . $row['building_id'] . " : " .$row['orig_filename'] . " : " . $row['width'] . ", " . $row['height'] . " :: " . $row['xloc']. ", " . $row['yloc']   . " ::-:: " . $width. ", " . $height   . "  ==> " . $pos_x. ", " . $pos_y);
	
		$sql = "UPDATE image_plot set pos_x=".$pos_x.',pos_y='.$pos_y.' WHERE id='.$row['id'];
		
		print('<br>'.$row['id'] . ' '. $row['image_id'] . " " .  $sql) ;
		
		$db->submit($sql);
	
	
		print('<hr>');

		$i++;
	}
?>