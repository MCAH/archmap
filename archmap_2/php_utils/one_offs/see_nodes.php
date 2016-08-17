<?php

		ini_set("memory_limit","256M");
		
		error_reporting(E_ERROR | E_PARSE);
	
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');
	
		println("All nodes");
	
	
		$db = new Database();
		
		$sql = 'select i.id, i.building_id, i.filename, i.orig_filename, i.title, i.has_sd_tiles, b.name, b.id as bid from image i, building b  where i.image_type="node" and i.building_id=b.id order by b.name, i.id asc';
		
		$rows =  $db->queryAssoc($sql);
		
		foreach($rows as $row) {
			
			if ($previd != $row['building_id']) {
				print('<br>');
				print('<br>');
				print('<hr>');
				print('<h2>'.$row['name'].' ' . $row['building_id']. '</h2>');
				print('<hr>');
			}
			if ($row['orig_filename'] != "") {
				print('<input type="checkbox" checked="true" />');
			} else {
				print('<input type="checkbox" />');
			}
			
			print(' <b>' . $row['id'] . '</b> :: ' . $row['filename']. ' - ' . $row['title'] . ' ** '. $row['orig_filename'] . ' ** <br>');
			print('<img src="http://mappinggothic.org/media/buildings/001000/'.$row['bid'] .'/panos/'.$row['filename'].'.jpg" width="200" height="100" />');
			print('<br>');
			print('<br>');
			print('<br>');
			print('<br>');
			
			$previd = $row['building_id'];
		}
?>