<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Database.php');
	
	if($_GET['building']) {
	
		$db = new Database();
	
		$building = new Building($_GET["building"]);
		
		$q = 'select * from image where building_id="'.$_GET["building"].'"';
		$rows = $db->queryAssoc($q);
		
			echo '
			   <ul>';
		
		// five before
		for($i = ($_GET['pos'] - 4); $i < $_GET['pos']; $i++) {
			if($rows[$i]["filename"]) {
				echo '
					<li>
					 <a href="?building='.$_GET['building'].'&photo='.$rows[$i]["filename"].'&pos='.$i.'">
					  <img src="/archmap/media/buildings/001000/'.$_GET["building"].'/images/100/'.$rows[$i]["filename"].'" />
					 </a>
					</li>';
			}
		}
		// five after
		for($i = $_GET['pos']; $i < ($_GET['pos'] + 5); $i++) {
			if($rows[$i]["filename"]) {
				echo '
					<li>
					 <a href="?building='.$_GET['building'].'&photo='.$rows[$i]["filename"].'&pos='.$i.'">
					  <img src="/archmap/media/buildings/001000/'.$_GET["building"].'/images/100/'.$rows[$i]["filename"].'"/>
					 </a>
					</li>';
			}
		}
		
		echo '
			</ul>';
	
	}

?>