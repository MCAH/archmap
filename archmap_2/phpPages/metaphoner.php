<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Metaphoner</title>
</head>


<body class="structural">
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Database.php');


	print('<div><b>ArchMap Metaphoner</b> </div>');
	
	$am_db = new Database();

	$table = $_GET["table"];
	
	
	if (! $table || $table == "") {
		print("No table specified");
		exit;
	}

	$rows = $am_db->queryAssoc('select * from ' .$table. ' order by id desc');
	
	print("<table><tr><td> ");
	
		print('<table border="1">');
		foreach ($rows as $row) {
			
			
			
			print('<tr><td><a href="?id='.$row['id'].'">'.$row['id'].'</a> </td> <td> <nobr> ' . $row['name'] . '</nobr> </td>  <td>  ' . metaphone($row['name'] ) . ' </td>  </tr> ');
			
			$q = 'update '.$table.' set metaphone="'.metaphone($name).'" where id='.$row['id'];
			$am_db->submit($q);
			
		}
		print("</table>");
	
	print('</td><td valign="top">');
	print("</td></tr></table>");
?>