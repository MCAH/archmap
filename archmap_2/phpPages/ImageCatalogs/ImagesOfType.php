<?
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
	
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Image.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Essay.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

	$am_db = new Database();
	
	// 139 tympana
	// 20 corbel
	// 24 sculpture
	
	
	
	$q = 'select b.name as bname, i.* from image i, image_keyword_values k, building b where k.keyword_id=20 and k.image_id=i.id and i.building_id=b.id  order by b.name';

	$rows = $am_db->queryAssoc($q);


//printline($q);
	
	print("<h2>Catalog</h2><hr>");
	
	print('<div>');
	foreach ($rows as $row) {
		$newBuilding = ( $lastbname == "" || $lastbname != $row['bname']);
		
		if ($lastbname != "" && $lastbname != $row['bname']){
			print('</div>');
		}
		if ( $newBuilding) {
			print('<div style="float: none; border: 1px solid #aaa;margin: 5;margin-bottom:25;padding: 5;"><b>'.$row['bname']."</b><br>");
			
		}
		$i = new Image($row);
		
		print('<img style=" margin:3;" src="'.$i->url(300) . '" />');
		
		$lastbname = $row['bname'];
		
	}
	print('</div>');
	print('</div>');


	








?>