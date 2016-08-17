<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Church List</title>
	
	<script language="javascript">
		function resizeWindow() {
			//alert(screen.width);
			self.resizeTo(screen.width, screen.height);
		}
			
		function openImageWindow(building_id, filename) {
			//alert(url + " " + w + " " + h);
			
			url = 'http://www.learn.columbia.edu/archmap/media/buildings/001000/'+building_id+'/images/1300/'+filename;
			//alert(url);
			window.open(url);


		}
	
	</script>
	
	
</head>




<body class="structural">
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	$db = new Database();
	
		
		/* 
		 *
		 * IMAGES OF A BUILDING
		 */
	
		if ($_GET["building_id"]) {
		
			$building = new Building($_GET["building_id"]);
			//print('<h2>'.$building->get("building_name").'</h2>');			
			
			print('<div style="text-align:center;">');
			
		
			$q = 'select * from image where building_id="'.$_GET["building_id"].'"';
			$rows = $db->queryAssoc($q);
			foreach($rows as $row) {
				
				
				print('<img src="/archmap/media/buildings/001000/'.$_GET["building_id"].'/images/300/'.$row["filename"].'" />
				
				<br />
				
				<input type="button" style="font-size:6" name="test" value="Open Larger Version" onClick="openImageWindow(\''.$_GET["building_id"].'\',\''.$row["filename"].'\' )" />
				
				<br />
				
				<br />');
				
			}
			print('</div>');
		
		
		}
?>