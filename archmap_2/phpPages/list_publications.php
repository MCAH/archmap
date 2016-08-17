<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Publications List</title>
</head>


<body class="structural">
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Publication.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Database.php');


	print('<div><b>ArchMap Publications Page</b> </div>');
	
	$am_db = new Database();


	$q = 'select * from publication order by name';
	//$q = 'select * from publication p, publication_authors pa, person pp where p.id=pa.pub_id and pa.person_id=pp.id group by p.id order by name';
	
	$rows = $am_db->queryAssoc($q);
	
	print("<table><tr><td>");
	foreach ($rows as $row) {
		
		if ($row["id"] == $_GET["id"]) $pub = $row;
		if ($row["volume"] != "") {
			$vol = '<i>vol. '.$row["volume"] .'</i>';
		} else {
			$vol = null;
		}
		print('<nobr><a href="?id='.$row['id'].'">[ <span style="color:#ffaaaa;">'.$row['id'].' </span> ] <b><span style="color:#ffffff;">' .$row['name'] . '</span></b> (' . $row['date'] . ') '.$vol.' </a> ');
		$q = 'select db_name from publication_authors pa, person pp where pa.pub_id='.$row['id'].' and pa.person_id=pp.id';
		$arows = $am_db->queryAssoc($q);
		if ($arows) {
			foreach ($arows as $arow) {
				print(' <span style="color:#ccccff;">'.$arow["db_name"].';</span> ');
			}
		}
		print('</nobr><br />');
		//print ($q);

	}
	print('</td><td valign="top">');
	if ($person) {
		$rec = new Publication($person);
			
		print('<h2>' .$person['name'] . " " . $person['date'] . '</h2>');
		
			
			/*	
		$cols = $rec->getColumnsFromTable('person');
	
		foreach($cols as $key=>$val) {
			print($key . " " . $val.'<br />');

		}
		*/

	}
	print("</td></tr></table>");
?>