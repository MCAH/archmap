<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Church List</title>
</head>


<body class="structural">
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Collection.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/HistoricalEvent.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Place.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Publication.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Person.php');

	$tables[20] = "historicalevent";
	$tables[30] = "place";
	$tables[40] = "building";
	$tables[50] = "person";
	$tables[60] = "publication";
	$tables[70] = "collection";
	
	foreach($tables as $key=>$val) {
		$entity_ids[$val] = $key;
	}

	print('<div><b>MAke Aliases</b> </div>');
	
	$table = "collection";
	
	$db = new Database();

	$rows = $db->queryAssoc('select * from '.$table);
	
	print("<table>");
	foreach ($rows as $row) {
		$entity_id  = $entity_ids[$table];
		$item_id    = $row['id'];
		$name 		= $row['name'];
		$metaphone	= metaphone($name);
		$lang		= "en";
		
		$q = 'DELETE FROM aliases WHERE entity_id='.$entity_id.' AND item_id='.item_id.' AND name="'.$name.'"';
		//$db->submit($q);
		
		$q = 'INSERT INTO aliases (entity_id, item_id, name, metaphone, lang) VALUES ('.$entity_id.','.$item_id.',"'.$name.'","'.$metaphone.'","'.$lang.'")';
		//$db->submit($q);
		
		print('<tr><td width="100">' .$entity_id . '</td><td width="100"> '.$item_id."</td> <td>".$name."</td> <td>".$metaphone."</td> <td>".$lang."</td>  </tr>");
		
	}

	
	print("</table>");
?>