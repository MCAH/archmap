<?
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
	
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Essay.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

	$am_db = new Database();
	
	$q = 'SELECT b.* FROM collection_item ci, building b   where  ci.collection_id=1 and ci.item_id=b.id  order by name';
	//$q = 'SELECT b.* FROM  building b   where  b.style=11  order by name';
	$rows = $am_db->queryAssoc($q);


	$xml = '<?xml version="1.0" encoding="UTF-8"?><models>';
//printline($q);
	
	
	
	$gote = new Essay(163); // gothic on the edge
	
	/*
	$cat = new Essay(219); // catalog
	
	$mgs = new Essay(227); // mapping gothic spain
	$mgf = new Essay(152); // mapping gothic france
	$mgg = new Essay(230); // mapping gothic germany
	$mgc = new Essay(138); // mapping gothic cyprus
	$mgl = new Essay(154); // mapping gothic levant
	$mge = new Essay(229); // mapping gothic england
	$mgi = new Essay(232); // mapping gothic italy
	
	$mg = new Essay(231); // mapping gothic
	
	
		$mgf = new Essay(152); // mapping gothic france
	
	
	$mgc = new Essay(138); // mapping gothic levant
	$rows = $mgc->getRelatedItems('Building', false);
	
	foreach ($rows as $row) {
		
		$b = new Building($row);
		//$gote->addRelation($b);
		$b->set("prec_windows", 1);
		$b->set("prec_stories", 2);
		$b->set("prec_elong", 2);
		$b->set("prec_thin", 2);
		$b->saveChanges();
		print($row['name'] . ' -'. $row['prec_stories'].'-<br>');
		
		
	}
	
	*/
	
	
	if (isset($_REQUEST["id"]) && $_REQUEST["id"] != "")
	{
		
	
		$bb = new Building($_REQUEST["id"]);
		
		
		if (isset($_REQUEST["prec_windows"]) && $_REQUEST["prec_windows"] != "")
			$bb->set("prec_windows", $_REQUEST["prec_windows"]);
		
		if (isset($_REQUEST["prec_stories"]) && $_REQUEST["prec_stories"] != "")
			$bb->set("prec_stories", $_REQUEST["prec_stories"]);
			
		if (isset($_REQUEST["prec_elong"]) && $_REQUEST["prec_elong"] != "")
			$bb->set("prec_elong", $_REQUEST["prec_elong"]);
			
		if (isset($_REQUEST["prec_thin"]) && $_REQUEST["prec_thin"] != "")
			$bb->set("prec_thin", $_REQUEST["prec_thin"]);
	
			print($bb->get("name") . ' <br>stories: ' . $bb->get("prec_stories"). '<br>windows: ' . $bb->get("prec_windows"). '<br>elong: ' . $bb->get("prec_elong") . '<br>thin: ' . $bb->get("prec_thin"));
	
		$bb->saveChanges();
	}
	
	
	
	
	
	

	echo ('<br><br><hr><form> id<input name="id"><br> stories: <input name="prec_stories"><br> windows: <input name="prec_windows"><br> elong: <input name="prec_elong"><br> thin: <input name="prec_thin"><br><input type="submit" value="Submit"></form>');


	$xml .= '</models>';
	
	echo $xml;









?>