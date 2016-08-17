<head>
	<link rel="stylesheet" type="text/css" href="/mgf/styles.1.css" />
	<title>MGF Scanned Images</title>
	
	<script src="http://code.jquery.com/jquery-latest.js">
	</script>
	
	<script>
		$(document).ready(function() {
			
			setUpRatingBox();
			
		});
		
	</script>
	
	<script>
		function setUpRatingBox() {
			$('.ratingbox').click(function(event) {
					var id = event.target.id;
					var parts = new Array();
					parts = id.split('-');
					var image_id = parts[0];
					var newrating = parts[1];
					//alert("image_id=" + image_id + ", new rating: " + newrating);
					
					for (i=1; i<=5; i++) {
						if (i<=newrating) {
							//alert(i+ '  ' + '#'+image_id+'-'+i);
							$('#'+image_id+'-'+i).css("background","coral");
								
						} else {
							$('#'+image_id+'-'+i).css("background","white");
						}
					
					}
					
					
				});
		}
	
	
	</script>
	
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
	$q = 'select count(*) c, p.name pname,p.id pubid, p.date, per.name pername, p.publisher from image i, publication p, publication_authors pa, person per where i.publication_id is not null and i.publication_id=p.id and pa.pub_id=p.id and per.id=pa.person_id group by i.publication_id order by c desc';
	$rows = $db->queryAssoc($q);
	
	print('<div style="margin:50;">');
	
	print('<h2>MGF Scanned Images from Publications</h2>');


	$pubid = getPost('pubid');
	
	
	if ($rows) {
	
	print('<table border="1" width="100%">');
		print('<tr>');
			print('<td valign="top" width="400">');
	
				print('<table cellspacing="0" cellpadding="10">');
					
					$bgcolor[0] = '#333355';
					$bgcolor[1] = '#333365';
					$bgcolor[2] = '#885555';
					
					$i =  0;
					foreach($rows as $row) {
						$bgc = $bgcolor[($i++ % 2)];
						if ($pubid == $row['pubid']) $bgc = $bgcolor[2];
						
						print('<tr style="background:'.$bgc.';border:1px;">');
						print('	<td width="400px">');
							print('<div><b><a href="?pubid='.$row['pubid'].'">'.stripslashes($row['pname']).'</a></b></div>');
							print('<div style="margin-bottom:20;">'.$row['date'].', '.$row['pername'].'</div>');
						
						print('	</td>');
			
						print('	<td valign="top" align="right">');
						print('<a href="?pubid='.$row['pubid'].'"><b><span style="color:coral;">'.$row['c'].'</span></b> scans</a>');
						print('	</td>');
						print('</tr>');
						
						
					}
		
	
				print("</table>");
				
			print('</td>');


			print('<td valign="top">');
			
				print('<h3> Scan Gallery for Selected Publication </h3>');
				
				
				if (isset($pubid) && $pubid >0) {
				
					
					
					$q = 'select i.*, b.name bname from image i, building b where i.publication_id='.$pubid . ' and i.building_id=b.id';
					$rows = $db->queryAssoc($q);
					
					if ($rows) {
					
						foreach($rows as $row) {
							$image = new Image($row);
							//print ( $row['filename'] . '<br />');
							//print('<div style="float: left;"><img src="/archmap/media/buildings/001000/'.$_GET["building_id"].'/images/300/'.$row["filename"].'" /></div>');
							
							print('<div style="float:left;width:102;height:170;">');
							print('		<div onClick="openImageWindow(\''.$row["building_id"].'\',\''.$row["filename"].'\' )" style="margin:3;background: #333365;text-align: center ;width:100;height:100;"><img src="'.$image->url(100).'" /></div>');
								
							print('<div id=
							"'.$row['id'].'">');
							print('<table><tr>');	
								
								for ($i=0; $i<=5; $i++){
									print ('<td>');
									
									if ($i==0) {
										if ($row['rating'] > 0) {
											print('<div style="margin:0;width:5;height:5;background:gray;font-size:7"> <b>X</b> </div>' );
										}
									
									} else {
										if ($i <= $row['rating']) {
											print('<div class="ratingbox" id="'.$row['id'].'-'.$i.'" style="margin:0;width:6;height:6;background:coral"> </div>' );
										} else {
											print('<div class="ratingbox" id="'.$row['id'].'-'.$i.'" style="margin:0;width:6;height:6;background:white"> </div>' );
										}
									}
									
									
									print ('</td>');
								}
								
							
							print('</tr></table>');
							print('</div>');
								
							print('		<div style="font-size:9">'.$row['pages'].'</div>');
							print('		<div style="font-size:9">'.$row['bname'].'</div>');
							print('</div>');					
						}
					
					}
				
				
				
				}
			print('</td>');
		print('</tr>');
	
	print("</table>");
				
	print('</div>');
	
	}
	
	

?>