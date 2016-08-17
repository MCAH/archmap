<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Church List</title>
	
	<script language="javascript">
		function resizeWindow() {
			//alert(screen.width);
			self.resizeTo(screen.width, screen.height);
		}
			
		function openImageWindow(id, filename) {
			//alert(url + " " + w + " " + h);
			
			url = 'http://www.learn.columbia.edu/archmap/media/buildings/001000/'+id+'/images/1300/'+filename;
			//alert(url);
			window.open(url);


		}
		
		function choose(building_id) {
			
		
		}
	
	</script>
	
	
</head>


<body class="structural">
	
	<div style="margin-bottom:10;font-size:11;">[ <a href="/mgf/index.php">Mapping Gothic France</a> ]</div>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	$db = new Database();
	
	// all gothic images in image table
	//$q = 'select i.building_id, t.name,b.name, b.beg_year, count(*) as count from image i, building b, place t   where  i.id>30000 and i.building_id=b.id and t.id=b.town_id group by i.building_id order by t.name asc';
	$q = 'select * from building  where style=11 order by name asc';
	$rows = $db->queryAssoc($q);
	
	//if ($rows) {
	print('<table><tr><td valign="top">');
		
		
		
		/* 
		 *
		 * BUILDING LIST IN SIDEBAR
		 */
		print('<iframe name="list" src="/archmap/phpPages/imageGalleryList.php?building_id='.$bid.'" width="350" height="650"> </iframe>');
		
		
	print('</td><td valign="top">');
	
		$bid = 1007;
		if ($_GET["building_id"]) {
			$bid = $_GET["building_id"];
		}
		print('<iframe name="profile" src="/archmap/phpPages/buildingProfile.php?building_id='.$bid.'" width="600" height="650"> </iframe>');
		
	
	print("</td></tr></table>");

	
	//}
	
	

?>