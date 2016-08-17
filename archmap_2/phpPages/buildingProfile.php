<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Church List</title>
	
</head>
<body class="structural">
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	$db = new Database();
	
		
		/* 
		 *
		 * A BUILDING PROFILE VIEW
		 */
	
		if ($_GET["building_id"]) {
		
			$building = new Building($_GET["building_id"]);
			print('<h2>'.$building->get("building_name").'</h2>');			
			
			
			print('<div style="font-size:9;">');
			print($building->get("descript"));
			print('</div>');
			
			
			
			print('<table><tr>');
			print('<td width="200"> </td>');
			
			print('<td>');
			print('<iframe name="tiles" src="/archmap/codebase/phpPages/imageGalleryTiles.php?building_id='.$_GET["building_id"].'" width="330" height="550"> </iframe>');
			print('</td>');
		
			print('</tr></table>');
		}
?>

</body>