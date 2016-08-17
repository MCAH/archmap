<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>ArchMap Migrate Building Keys</title>
</head>


<body class="structural">
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Publication.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Database.php');


	print('<div><b>ArchMap Publications Page</b> </div>');
	
	$am_db = new Database("vincent.mcah.columbia.edu",   "arch_map", "mgf", "mgfmgfmgf");


	$q = 'select * from building where building_id < 1000 order by building_id';
	//$q = 'select * from publication p, publication_authors pa, people pp where p.id=pa.pub_id and pa.person_id=pp.id group by p.id order by title';
	
	$rows = $am_db->queryAssoc($q);
	
	print("<table><tr><td>");
	foreach ($rows as $row) {
		
		print('<nobr>[ <span style="color:#ffaaaa;">'.$row['building_id'].']  ['.$row['building_key'].']');
		
		if ($row['building_key'] && $row['building_key'] != "") {
			$q = 'update image set building_id="'.$row['building_id'].'" where building_key="'.$row['building_key'].'"';
			print(" " . $q);
			//$am_db->submit($q);
		}
		
		

	}
	print('</td><td valign="top">');
	print("</td></tr></table>");
?>