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
		
		function choose(building_id) {
			
		
		}
	
	</script>
	
	
</head>


<body class="structural">
	
	
<?php

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	$db = new Database();
	
	// all gothic images in image table
	//$q = 'select i.building_id, t.name,b.building_name, b.beg_year, count(*) as count from image i, building b, place t   where  i.id>30000 and i.building_id=b.id and t.id=b.town_id group by i.building_id order by t.name asc';
	$q = 'select i.building_id, b.id, b.name, b.beg_year, count(*) as count from image i, building b   where  i.id>30000 and i.building_id=b.id group by i.building_id order by b.name asc';
	$rows = $db->queryAssoc($q);
	
		/* 
		 *
		 * BUILDING LIST IN SIDEBAR
		 */
		
		print('<table cellpadding="5"><tr><td>');
		foreach($rows as $row) {
				
			print("<tr>");
			print("<td>");
			print('<div  style="margin-bottom:10;border-style:solid;border-width:1;border-color:white;" >');
			
				print('<table >');
				print('		<tr>');
								// THUMBNAIL
				print('			<td width=100 valign="top"  align="center" style="background-color:555555;border-style:solid;border-width:1;border-color:gray;" > ');
				print('				<img src="/archmap/media/buildings/001000/'.$row["building_id"].'/images/100/'.$row["building_id"].'_00001_w.jpg" />');
				print("			</td>");
				
								// TITLE & TEXT
				print('			<td valign="top" >');
				print('				<div style="margin:5;">
									<b><a target="profile" href="/archmap/phpPages/buildingProfile.php?building_id='.$row["building_id"].'">' . $row['name'] . '</a></b> <span style="font-size:10;">(<span style="color: #ff7777;">'.$row["count"].'</span> images)</font>');
				print("				<br />");
				print('				<span style="font-size:8;">['. $row['building_id'].']</span> ' . $row['building_name'] . ' -- c. ' . $row['beg_year']);
				print("			</div></td>");
				print('		</tr>');
				print('</table>');

			
			print("</div>");
			
			print("</td>");
			print("</tr>");
			
			
		}
		print("</table>");
		

	
	

?>