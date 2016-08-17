<head>
	<title>Archmap Old Authors to Archmap 2</title>
</head>


<body >
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');


	print('<div><b>ArchMap Authors Migration Page</b> </div>');
	
	$am_db = new Database("vincent.mcah.columbia.edu",   "arch_map", "mgf", "mgfmgfmgf");


	//$q = 'select pub.*,p.id as person_id   from publication_authors;
	$q = 'select pb.*, pp.id as person_id from publication pb, publication_authors c, person pp where pb.id=c.pub_id and c.person_id=pp.id';
	
	$pub_rows = $am_db->queryAssoc($q);
	
	
	foreach ($pub_rows as $pub_row) {
		
		$pub = new Publication($pub_row);
		
		$person = new Person($pub_row['person_id']);
		
		print('<div style="margin-bottom:20;">');
		
		print($pub->get('name') . ' => '. $person->get('name'));
		$pub->addRelation($person, 'author');
		print('</div>');
		/*
		$person = new Person($row);
		
		
		$sql = 'select i.* from collection_item ci, image i WHERE ci.collection_id='.$row['cid'].' AND item_entity_id=110 AND ci.item_id=i.id';
		
		$irows = $am_db->queryAssoc($sql);
		
		if ($irows && sizeof($irows)) {
			
			
			print('<div style="margin-bottom:20;">');
			print('<span>'.$row['name'].'</span>');
			foreach ($irows as $irow) {
				if ($irow) {
				
					$image = new Image($irow);
					print('<div>--> ['.$irow['id'].' :: '.$irow['orig_filename'].'] => z_related_items =>  [ 50 | '.$row['pid'].' || 100 | '.$irow['id'].' || depiction]   </div');
					
					//$person->addRelation($image, 'depiction');
					
				}
			}
			print('</div>');

		
		}
		
		
		//$am_db->submit($q);
		*/

	}
	print(" ");
?>

</body>