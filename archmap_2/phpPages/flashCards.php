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
	
	var ct = 0;
	function showAnswer() {
		if (ct > 0) {
			location.reload(true);
		} else {

		var ele = document.getElementById("answerField");
		//alert(ans + " ");
		ele.style.display = "block";
		
		}
		ct++;
	} 
	
	function choose(building_id) {
			
		
		}
	
	</script>
	
	
</head>


<body class="structural">
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Image.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	$db = new Database();
	
	// all gothic images in image table
	//$q = 'select i.building_id, t.name,b.building_name, b.from_year, count(*) as count from image i, building b, places t   where  i.id>30000 and i.building_id=b.building_id and t.id=b.town_id group by i.building_id order by t.name asc';
	$q = 'select count(*) from image i, building b   where b.style=11 and  i.building_id=b.id';
	$ct = $db->count($q);
	
	//print("count = " . $ct);
	
	
	$q = 'select i.id from image i, building b   where b.style=11 and  i.building_id=b.id';
	$rows = $db->queryAssoc($q);
	
	
	//print(' == '.sizeof($rows) . '<br />');
	
	shuffle($rows);
	//foreach($rows as $row) {
	//	print($row['id'] . '<br />');
	//}
	$img = new Image($rows[0]['id']);
	$bldg = new Building($img->get('building_id'));
	$town = $bldg->getTown();
	
	//print ($img->get('filename') . '<br />');
	//print_r($img->attrs);
	
	print('
		<div style="text-align:center;width:100%;" >
			<a href="javascript:showAnswer();">
			<img src="http://www.learn.columbia.edu/archmap/media/buildings/001000/'.$img->get('building_id').'/images/1300/'.$img->get('filename').'" />
			</a>
		</div>
	
	');
	
	
	
	print('
		<div style="margin-top:15;width:100%;text-align:center;">
			'.$img->get('title').'
		</div>
	
	');
	print('
		<div id="answerField" style="display: none;margin-top:15;font-size:18;width:100%;text-align:center;">
			
			<b>'.$town->get('name') . ' &nbsp; - &nbsp; <a href="http://www.learn.columbia.edu/archmap/phpPages/buildingProfile.php?building_id='.$img->get('building_id').'" target="_blank">' .$bldg->get('building_name').'</a></b>
		</div>
	
	');
	
	exit;
		

	
	

?>