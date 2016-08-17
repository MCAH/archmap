<?
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
	
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/models/Essay.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

	$am_db = new Database();
	
	$q = 'SELECT b.*,d.value FROM building b, building_dims d  where  (b.style= 11 || b.style= 13) and b.id=d.building_id and d.zone=1 and d.position=1 and d.dim=1 order by d.value DESC';
	//$q = 'SELECT b.* FROM  building b   where  b.style=11  order by name';
	$rows = $am_db->queryAssoc($q);

	
	foreach ($rows as $row) {
		$transverseApex = $row['value'];

		$b = new Building($row);

		
		$sql = 'select value from building_dims where building_id='.$b->get('id').' and zone=1 and position=1 and dim=2';
		$transverseSpring = $am_db->count($sql);
		
		$sql = 'select value from building_dims where building_id='.$b->get('id').' and zone=1 and position=2 and dim=1';
		$arcadeApex = $am_db->count($sql);

		$midStory = $transverseSpring-$arcadeApex;
		
		if ($midStory < 2) {
			print('<div style="color: red;">');
		} else {
			print("<div>");
		}
		print($row['name'] . ' [' .$transverseApex . '] ' .$transverseSpring .' : ' . $arcadeApex . ' -- ' . $midStory);
		
		
		print('</div>');
		
		
	}


	
	







?>