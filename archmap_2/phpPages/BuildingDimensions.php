<?
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/BuildingModel.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	$am_db = new Database();

	// $q = 'SELECT c.* FROM collection_item ci, collection c   where  ci.collection_id=1 and c.id=ci.item_id  order by name';
	$q = 'SELECT b.* FROM collection_item ci, building b   where  ci.collection_id=1 and ci.item_id=b.id  order by name';
	$rows = $am_db->queryAssoc($q);


	$xml = '<?xml version="1.0" encoding="UTF-8"?><models>';
//printline($q);

	
	foreach ($rows as $row) {
		
		//print($row['name'] . '<br>');
		$dims_rows = null;
		
		// GET THE NAVE MAIN VESSEL for this church
		$dims_q = 'select * from building_dims where building_id='.$row['id'] . ' and zone=1 and position=1';
		//$dims_q = 'SELECT b.* FROM collection_item ci, building b   where  ci.collection_id=1 and ci.item_id=b.id  order by name';
		$dims_rows = $am_db->queryAssoc($dims_q);
				
		if (isset($dims_rows)) {
			/*
			print($row['name'] . '<hr />');
			
			print('height: = ' .$dims_rows[1]['value'] . '<br />');
			print('spring: = ' .$dims_rows[2]['value'] . '<br />');
			print('width: = ' .$dims_rows[4]['value'] . '<br />');
			
			print('<br />');
			print('<br />');
			
			*/
			
			
			$building = new Building($row);
			$image = $building->floorplan();
			
			if ($dims_rows[4]['value']) {
				$xml .= '<model bid="'.$building->get("id").'" name="'.utf8_encode($row['name']).'"  planURL="'.$image->url(300).'" planWidth="'.$image->get('width').'" planHeight="'.$image->get('height').'" apex="'.$dims_rows[1]['value'].'" spring="'.$dims_rows[2]['value'].'" width="'.$dims_rows[4]['value'].'" />';
			}
		}		
	}


	$xml .= '</models>';
	
	echo $xml;









?>