<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>

		<title>MGF Church List Experimental</title>
		
		<style type="text/css">
			* {
				padding:0px;
				margin:0px; }
			body {
				background:white;
				padding:50px;
				font-family:Georgia,serif;
				color:#222; }
			a {
				color:royalblue;
				text-decoration:none; }
			a:hover {
				color:dodgerblue; }
			
			h4 {
				margin:5px 0px 15px 0px;
				font-size:.9em;
				font-family:monospace; }
			
			div#container {
				width:1000px;
				margin:auto auto; }
			
			div#building-list {
				width:185px;
				float:left; }
			#building-list ul {
				list-style:none; }
			#building-list ul li {
				display:block;
				margin-bottom:10px;
				overflow:hidden;
				background:whitesmoke;
				position:relative; }
			#building-list ul li a {
				display:block;
				text-decoration:none;
				color:steelblue;
				position:relative;
				z-index:10; }
			#building-list span {
				display:block;
				color:steelblue;
				visibility:hidden;
				font-size:1.3em;
				text-align:right;
				position:absolute;
				bottom:5px;
				right:5px; }
			#building-list small {
				font-size:.9em;
				color:firebrick;
				display:block;
				color:indigo;
				background:rgba(260,260,260,.8);
				margin:3px;
				padding:5px;
				text-decoration:underline; }
			#building-list small.place {
				color:firebrick;
				display:block;
				text-decoration:none;
				font-family: "HelveticaNeue","Helvetica Neue",Arial,Helvetica,sans-serif;				
				font-size:.8em;
				font-weight:bold;
				text-transform:uppercase; }
			#building-list ul li a:hover {
				background:white;
				background:rgba(260,260,260,.5); }
			#building-list ul li a:hover span {
				visibility:visible;}
			
			#building-list li img {
				position:absolute;
				z-index:0;
				top:-25px;
				left:-5px;
				opacity:.9;
				display:none; }
			
			#building-list li.current-building {
				background:steelblue; }
			
			div#images {
				width:700px;
				float:left;
				margin:0px 25px; }
			div#images h2 {
				font-family: "HelveticaNeue","Helvetica Neue",Arial,Helvetica,sans-serif;
				color:#888; }
			div#images ul {
				list-style:none; }
			div#images ul li {
				display:block;
				float:left;
				padding:10px; }
			div#images ul li a {
				}
			div#images img {
				height:199px;
				border:none; }
			div#images ul li a img {
				border-bottom:5px solid lightsalmon; }
			div#images ul li a:hover img {
				border-bottom-color:firebrick; }
			div#bigimage {
				width:725px;
				float:left;
				margin-left:25px;
				margin-bottom:25px; }
			
			div#metadata {
				width:500px;
				padding:25px;
				overflow:auto; }
			
			div#carousel {
				margin:0px 0px;
				height:75px;
				overflow:hidden;
				border-bottom:3px solid #eee;
				padding-left:1px;
				margin-right:40px; }
			div#carousel ul {
				list-style:none; }
			div#carousel ul li {
				float:left;
				margin:0px 10px 0px 0px; }
			div#carousel a {
				height:66px;
				overflow:hidden;
				width:66px;
				display:block; }
			div#carousel img {
				border:none; }
			
			div#versions {
				font-size:.8em;
				color:#aaa;
				margin-top:-30px; }
			div#versions a {
				background:royalblue;
				display:inline-block;
				color:white;
				padding:5px; }
			div#versions a:hover {
				background:dodgerblue; }
			
			<?php
				if(!$_GET['building']) {
					echo '
						div#container {
							width: 900px; }
						div#building-list {
							width:1000px; }
						div#building-list li {
							float:left;
							margin:0px 15px 15px 0px; }
						div#building-list li a {
							width:255px;
							height:255px;
							border:5px solid lightsteelblue; }
						#building-list li img {
							display:block;
							top:-45px;
							left:-75px; }';
				}
			?>
			
		</style>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				
				$('div#bigimage').each(function(){
					var filepath = $('div#actualimage').attr('rel');
					//$('div#metadata').load('metadater.php?filepath='+filepath);
					// fetch before & after photos remotely
					var params = $('div#carousel').attr('rel');
					$('div#carousel').load('carousel_rob.php'+params);
				});
				
				
				var carouselPos = parseInt($('div#bigimage').attr('rel'));
				
				var currentBuilding = $('h2').attr('rel');
				var listItem = null;
				$('#building-list li').each(function(){
					if($(this).attr('id') == currentBuilding) {
						$(this).addClass('current-building');
					}
				});
				
				$('div#carousel-controls a#next').click(function(){
					carouselPos = carouselPos + 8;
					var toLoad = 'carousel_rob.php?building='+currentBuilding+'&pos='+carouselPos;
					//$('div#carousel').slideUp("fast").load(toLoad).slideDown("slow");
					$('div#carousel')
						//.animate({opacity:0.0})
						.load(toLoad)
						//.animate({opacity:1.0});
					return false;
				});
				
				$('div#carousel-controls a#prev').click(function(){
					if(carouselPos > 0) {
						carouselPos = carouselPos - 8;
						var toLoad = 'carousel_rob.php?building='+currentBuilding+'&pos='+carouselPos;
						$('div#carousel')
							//.animate({marginLeft:"-400px",opacity:0.0})
							.load(toLoad)
							//.animate({marginLeft:"0px",opacity:1.0});
					}
					return false;
				});
			});
		</script>
	</head>


	<body class="structural">
	 <div id="container">
	
		<h4><a href="imageGallery_rob.php">Gothic Churches</a> :: <a href="/mgf/index.php">Mapping Gothic France</a></h4>
	
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Image.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Database.php');

	$db = new Database();
	
	// all gothic images in image table
	/*
	$q = 'select i.building_id, t.name,b.name, count(*) as count from image i, building b, places t   where  i.id>30000 and i.building_id=b.building_id and t.id=b.town_id group by i.building_id order by i.building_id asc';
	$rows = $db->queryAssoc($q);
	*/
	
	$q = 'select i.building_id, t.name,b.name, b.from_year, count(*) as count from image i, building b, places t   where  i.id>30000 and i.building_id=b.id and t.id=b.town_id group by i.building_id order by t.name asc';
	$rows = $db->queryAssoc($q);
		
		
		
		/* 
		 *
		 * BUILDING LIST IN SIDEBAR
		 */
		echo
			'<div id="building-list">
			  <ul>';
		foreach($rows as $row) {
			echo '
				 <li id="'.$row["building_id"].'">
				   <a href="?building='.$row["building_id"].'">
				    <small class="place">'.$row["name"].'</small>
				    <small class="building">'.$row["name"].'</small>
				    <span>
				     <span>'.$row["count"].'</span>
				    </span>
				   </a>';
			
			
			if(!$_GET['building']) {
				$i = 1;
				
				$html_link = '/archmap/media/buildings/001000/'.$row["building_id"].'/images/700/'.$row["building_id"];
				$server_link = '../media/buildings/001000/'.$row["building_id"].'/images/300/'.$row["building_id"];
				
				if(file_exists($server_link.'_00001_w.jpg'))
					echo '	   
					   <img src="'.$html_link.'_00001_w.jpg"/>';
				else {
					while($i < 10) {
						if(file_exists($server_link.'_0000'.$i.'_w.jpg')) {
							echo '	   
					   <img src="'.$html_link.'_0000'.$i.'_w.jpg"/>';
					   		break;
					   	}
					   	else {
					   		$i++; }
					}
				}
			}
			
			// close up the list item
			echo '
				 </li>';
		}
		echo '
			 <ul>
			</div>';
	
	
		/*
		 *
		 * PARTICULAR IMAGE OF A BUILDING
		 */
		
		if($_GET["photo"] && $_GET["building"]) {
			
			$photo = $_GET["photo"];
			$building = new Building($_GET["building"]);
			
			$html_link = '/archmap/media/buildings/001000/'.$_GET["building"].'/images/';
			
			echo '
				<div id="bigimage" rel="'.$_GET["pos"].'">
				 <div id="carousel" rel="?building='.$_GET["building"].'&pos='.$_GET["pos"].'"><!-- ajax carousel --></div>
				 <div id="carousel-controls">
				  <a href="#" id="prev">prev</a> // 
				  <a href="#" id="next">next</a></div>				
				 <h2 style="display:none" rel="'.$_GET["building"].'" style="margin-bottom:25px;">'.$building->get("name").'</h2>
				 <div id="actualimage" rel="archmap/media/buildings/001000/'.$_GET["building"].'/images/full/'.$photo.'">
				  <img src="'.$html_link.'700/'.$photo.'"/>
				 </div>
				 <div id="versions">';
			$sizes = array(50,100,300,700,1300,1700,"full");
			foreach($sizes as $size)
				  echo '
				  	<a href="'.$html_link.''.$size.'/'.$photo.'">'.$size.'</a> / ';
			
			echo '
				 </div> <!-- end of versions -->
				 <div id="metadata"><!-- ajax metadata --></div>';
			
			echo '
				 <div id="containing_slideshows">
				  Part of any slideshows?';
			
			// this is truly ugly code
			// it will be cleaned up soon
			
			$command = 'SELECT * FROM image WHERE building_id='.$_GET['building'].' AND filename="'.$photo.'"';
			$query = $db->queryAssoc($command);
			$image_id = $query[0]['id'];
			$command = 'SELECT * FROM slide WHERE image_id='.$image_id.'';
			$rows = $db->queryAssoc($command);
			
			//print_r($query);
			
			foreach($rows as $row) {
				echo '
					<a target="_blank" href="http://learn.columbia.edu/archmap/slides/edit.php?slideshow='.$row['slideshow_id'].'">
					'.$row['slideshow_id'].'</a> &nbsp;&nbsp;';
			}
			
			echo ' 
				 </div>';
			
			echo '
				</div>';
		}
		
		/* 
		 *
		 * IMAGES OF A BUILDING
		 */
	
		else if($_GET["building"]) {
		
			$building = new Building($_GET["building"]);
			
			echo '
				<div id="images">
				  <h2 rel="'.$_GET["building"].'">'.$building->get("name").'</h2>';
			
			$q = 'select * from image where building_id="'.$_GET["building"].'"';
			$rows = $db->queryAssoc($q);
			
				echo '
				   <ul>';
			
			foreach($rows as $key=>$row) {
				echo '
					<li>
					 <a href="?building='.$_GET['building'].'&photo='.$row["filename"].'&pos='.$key.'">
					  <img src="/archmap/media/buildings/001000/'.$_GET["building"].'/images/300/'.$row["filename"].'" />
					 </a>
					</li>';
			}
		
			echo '
				   <ul>
				</div>';
		}

?>
	</div> <!-- end of the container div -->
</body>
</html>