<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Church List</title>
</head>


<body class="structural">
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Person.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Database.php');


	print('<div><b>ArchMap People Page</b> </div>');
	
	$am_db = new Database();

	$rows = $am_db->queryAssoc('select * from person');
	
	print("<table><tr><td>");
	foreach ($rows as $row) {
		
		if ($row["id"] == $_GET["id"]) $person = $row;
		
		print('<a href="?id='.$row['id'].'">' .$row['honorific'] . " " . $row['firstname'] . " " . $row['lastname'] . " " .$row['postname'] .'</a><br />');
	}
	print('</td><td valign="top">');
	if ($person) {
		$rec = new Person($person);
				
		$cols = $rec->getColumnsFromTable('person');
				
		

		print('<h2>' .$person['honorific'] . " " . $person['firstname'] . " " . $person['lastname'] . " " .$person['postname'].'</h2>');
	
		foreach($cols as $key=>$val) {
			print($key . " " . $val.'<br />');

		}

	}
	print("</td></tr></table>");
?>