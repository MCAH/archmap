<html>
	<head>
		<title>Archmap FTP Process Script of Existing Images for Seadragon Tiling </title>
	 
	</head>
	
	
	<body>
	 <!--  <button id="upload">Upload all of these images</button> -->
	  <?php
	
		$syspath = $_SERVER["DOCUMENT_ROOT"];
		$webpath = '/archmap_2/media/bourb_cubics';
		
		$sysdirectory = $syspath.$webpath;
		$pathdone = $_SERVER["DOCUMENT_ROOT"].'/archmap_2/media/bourb_cubics_done';

		error_reporting(E_ERROR | E_PARSE);
	
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');


		$db = new Database();


		
		
		
		$cubics = array();
		$filenames = array();
		$prevBuildingkey = "";
		$prevCubickey = "";
		$i = 0;
		if ($dir = @opendir($sysdirectory)) {
			while ($filename = readdir($dir)) {
				if(strstr($filename,".jpg") || strstr($filename,".tif")) {
					//$key = 
					
					array_push($filenames,$filename);
				}
				$i++;
			}
		}
		sort($filenames);
		print($i . "files<hr>");
		$j=0;
		
		
		//$ll = system('ls -l /home/mgf/archmap/media/images/05/71/*.tif');
		//print($ll);
		?>
		
		<table border="1">
			<tr>
				<td valign="top">
				<ul>
					<? for($j=0; $j<sizeof($filenames);$j++) {
							$buildingkey = substr($filenames[$j], 0, 6);
							$cubickey   = substr($filenames[$j], 0, -6);
							
							
							if ($cubickey != $prevCubickey) {
							
								// deal with accumlated faces from previous cubic
								
								if (isset($faces) && sizeof($faces) >= 6 ) {
									print('<br><i>CHECK OUT FACES</i><br>');


									println('PROCESSING:  '. $building->get('name') .' -> ' . $cubickey);
									// already an image for this?
									$q = 'select * from image where building_id='.$building->get('id').' and orig_filename="'.$prevCubickey.'"';
									
									$irows = $db->queryAssoc($q);
									
									
									if (sizeof($irows) == 0) {
										
										echo '(no image yet... create )<br>';
										
										$image = new Image();
										
										$image->set("building_id", $building->get('id'));
										$image->set("filename", $prevCubickey);
										$image->set("orig_filename", $prevCubickey);
										$image->set("image_type", 'cubic');
										$image->set("name", 'Panorama');
										$image->set("filesystem", 'B');
										$image->set("mimetype", 2);
										$image->set("width", (6*2100));
										$image->set("height", 2100);
										$image->saveChanges();
										
									} else {
										$image = new Image('ROW', $irows[0]);
										
									}
									echo 'image.id = '.$image->get("id");
									
									$building->set('poster_id', $image->get("id"));
									$building->saveChanges();
									
									// create
									$tempImg = imagecreatetruecolor((6*2100), 2100) or die("Cant create temp image");
									
									
									for ($f=0; $f<6; $f++){								
										$src = imagecreatefromjpeg($sysdirectory.'/'.$faces[$f]);
										imagecopymerge($tempImg, $src, (2100*$f),0, 0,0, 2100,2100, 100);
										
										rename($sysdirectory.'/'.$faces[$f], $pathdone.'/'.$faces[$f]);
										
									}

									$panoImageFilename = $sysdirectory.'/z__'. $cubickey;
									
									
									//unlink($sysdirectory.'/test.jpg');
									imagejpeg($tempImg, $panoImageFilename, 85);
									
									
									$image->makeOneoffIcons($panoImageFilename);
									
									unlink($panoImageFilename);
									exit;
									
								}
							}
							
							
							
							
							if ($prevBuildingkey != $buildingkey) {
								
								
								// start new building
								$q = "select * from building where building_key = '".$buildingkey."'";
								$rows = $db->queryAssoc($q);
								
								
								$building = new Building('ROW', $rows[0]);
								if (! isset($building) || $building == "") 
									continue;
								print('<br><br><br><br><b>'.$building->get('name') . ': id='.$building->get('id') . '</b><hr>');
								$prevBuildingkey = $buildingkey;
								
								
								
								
								
								
								
							}
							
							if ($cubickey != $prevCubickey) {
								
								
								
								
								// start new cubic
								
								$faces = array();
								
								print('<br><i>cubic: ' .$cubickey.'</i><br>');
								
								
								
								$prevCubickey = $cubickey;
							}

							array_push($faces,$filenames[$j]);		
							
							echo "<li>".$key . " -- " .$filenames[$j] ." </li>";
							
					   } ?>
				</ul>
				</td>
				<td valign="top">
						<h2>Building Images Needing SeaDragon  Tiles</h2>
						<ul id="to_tile_buildinglist">
							
						</ul>
				</td>
				<td valign="top">
						<h2>Building Images Completed</h2>
						<ul id="completed_buildinglist">
							
						</ul>
				</td>
			<tr>
		</table>
		
		
		
		
		
		
	 </body>
</html>