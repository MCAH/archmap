<?php

		ini_set("memory_limit","256M");
		
		error_reporting(E_ERROR | E_PARSE);
	
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');
	
		println("All authors");
	
	
		$db = new Database();
		
		$sql = 'select id, filepath from image where image_type="node"';
		
		$rows =  $db->queryAssoc($sql);
		
		foreach($rows as $row) {
		
			$image = new Image('ROW', $row);
			
			$filepath = $image->getFilesystemBFolderPath() . '/'.$row['id'];
			
			print($row['id'].' -- ' .$row['filepath']. ' --- ' .$filepath.'<br>');
			
			$image->set('filepath', $filepath);
			
			//$image->saveChanges();
		}



?>