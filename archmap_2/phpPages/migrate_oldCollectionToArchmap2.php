<head>
	<title>ArchMap Old Collections to Archmap 2</title>
</head>


<body >
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');


	print('<div><b>ArchMap Collection Migration Page</b> </div>');
	
	$am_db = new Database("vincent.mcah.columbia.edu",   "arch_map", "mgf", "mgfmgfmgf");


	$q = 'select c.id as cid, p.*  from person p, collection c where c.parent_entity_id=50 and c.statictype="image" and c.parent_item_id=p.id';
	//$q = 'select * from publication p, publication_authors pa, people pp where p.id=pa.pub_id and pa.person_id=pp.id group by p.id order by title';
	
	$rows = $am_db->queryAssoc($q);
	
	
	foreach ($rows as $row) {
		
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
					
					$person->addRelation($image, 'depiction');
					
				}
			}
			print('</div>');

		
		}
		
		
		//$am_db->submit($q);
		

	}
	print("</table>");
?>

</body>