<head>
	
	<title>MGF Building Dimensions</title>
	
	
	<script src="http://code.jquery.com/jquery-latest.js">
	
	</script>
	
	<script>
		$(function(){
		
			$("input").focus(function () {
				$(this).addClass('to-be-saved');
			});
			
		});
	
		function openMonograph(url) {
			window.open(url);
		
		}
	
	</script>
	<style type="text/css">
		body {
			background: #eeeeee;
			font-family:Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; 
		}
		
		a {
			color: #676767;
			text-decoration: none;
		
		}
		a:hover { 
			color:dodgerblue; 
		}
		a:focus { outline:none; }
		
		
		
		div.plan {
			text-align:center; 
			padding: 10; 
			margin: 0; 
			background-color:white; 
			
			
			width: 100%;
			text-align: center;
			color: #a6a3a1;
			border:1px solid; 
			border-radius: 12px;
			-moz-box-shadow:  3px 3px 8px #aeaba9 inset; 
			-webkit-box-shadow: 5px 5px 18px #aeaba9 inset
		}
		ul {
			
			margin-right: 15;
			height: 750px;
			overflow: auto;
			background: white;
			
			color:#ddd;
			border:1px solid; 
			border-radius: 6px;
			-moz-box-shadow:  3px 3px 8px #aeaba9 inset; 
			-webkit-box-shadow: 5px 5px 18px #aeaba9 inset
		}
		li {
			list-style-type: none;
			color: #676767;
			text-shadow: 1px 1px 0px #white;

			
			
			min-height: 20;
			
			font-size:12; 
			text-align:left; 
			padding:6; 
			padding-left:10; 
			margin: 0; 
			margin-right: 0; 
			background-color: #b2aeae; 
			
			
			
			border:0px solid; 
			border-radius: 2px; 
			-webkit-box-shadow: 1px 1px 8px #555;
			
			background: -webkit-gradient(linear, left top, left bottom, from(white), to(#dedede)); /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ccc,  #c); /* for firefox 3.6+ */  	
		}
		
		.to-be-saved {
			color:#9c282e;
			font-weight: bold;
			background: #fdf5cc;
		
		}
		.link:hover{
			color:dodgerblue; 
		}
		
		td{margin: 0; padding:3}
	
	</style>
</head>


<body class="structural" >
	
	<a href="http://www.mappinggothicfrance.org">Mapping Gothic France</a> - Parametric Building Dimensions
	
	
	
<?php

require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');
	

	$zones = array();
	
	$zones[1] = "Nave";
	$zones[2] = "Transcept";
	$zones[3] = "Crossing";
	$zones[4] = "Chevet";

	$am_db = new Database();

	$bid = getPost('bid');

	$site = $_REQUEST['site'];
	
	
	if ($site == "")
	{
		$bq = 'SELECT b.* FROM collection_item ci, building b   where  ci.collection_id=1 and ci.item_id=b.id  order by name';
		$brows = $am_db->queryAssoc($bq);
	}
	else 
	{
		$model = new Essay($site); 
		
		// for dom rendering inphp and smarty
		$brows = $model->getRelatedItems("Building", false);
	}
		
	//$q = 'select * from publication p, publication_authors pa, person pp where p.id=pa.pub_id and pa.person_id=pp.id group by p.id order by name';
	
	
	print('<table border="0" cellpadding="10";><tr><td>');
	
	
			//$q = 'SELECT c.* FROM collection_item ci, collection c   where  ci.collection_id=1 and c.id=ci.item_id  order by name desc';
			//$rows = $am_db->queryAssoc($q);
			
			
			print('<table border="0">');
			//foreach ($rows as $row) {
		
				
				print('<tr><td>');
					//print ($row['name']);
				
				
						
					//print('<table style="padding-left:20;font-size:10">');
					
					
					print('<ul>');
					if ($brows) {
						foreach ($brows as $brow) {
							print('<li> <a href="?site='.$site.'&bid='.$brow['id'].'">'.$brow['name'].'</a></li>');
						}
					}
					print('</ul>');
				
				print('</td></tr>');

				
			//}
			print('</table>');
			
	
	print('</td><td valign="top">');
	
	
			if (isset($bid) && $bid != "") {
				$building = new Building($bid);
				
				$model = $building->getModel();
				
				
					
				$image = $building->floorplan();
			

				// get dims from db
				$dims_q = 'select * from building_dims where building_id='.$bid;
				$dims_rows = $am_db->queryAssoc($dims_q);
				
				
				$dims = array();
				
				if ($dims_rows) {
					foreach ($dims_rows as $dims_row) {
						$dims[$dims_row['zone'] . '_' . $dims_row['position'] . '_' . $dims_row['dim']] = $dims_row['value'];
					}
				
				}
				
				
				
				// BUILDING NAME
				print('<div style="padding-bottom: 20;margin-top:10;margin-bottom: 20;"><a onClick="openMonograph(\'http://www.mappinggothicfrance.org/building/'.$building->get('id').'\');"><span class="link"><span style="font-size:26;">' .$building->get('name') . '</span> <span style="font-size:10;">[ Open monograph ] </span></span></a>');
				
				
				
				print('<form style="margin-top:7;" method="post">');
				
				
				
				
				// PLAN ////////////
				print('<div class="plan">');
					//$iconRect = $image->getIconWidthHeight(700);
				
						print('<div style="position:relative;">');
					
						print('<img src="'.$image->url(300).'" />');
				
						//print('<div style="position:absolute;left:'.$image->get("cen_x").'px;top:'.$image->get("cen_y").'px; width:20px;background-color:red;">');
						
				
						print('</div>');
				
				
				
				
				
				print('<table cellpadding="3">');				
				
				print('<tr>');
				print('<td></td> <td  align="center">apex</td> <td align="center">spring</td> <td align="center">boss</td> <td></td> <td align="center">opening</td> <td align="center">walls</td> <td align="center">centerline</td>');
				print('</tr>');
				
				for ($k=1; $k<=4; $k++) {
					// ZONE
					print('<tr><td cellspan="7">'.$zones[$k].':</td>');
					
					if ($k == 3) {
						$arch_ct = 1;
					} else {
						$arch_ct = 5;
					}
					for ($j=1; $j<=$arch_ct; $j++) {
						// POSITION
						print('<tr>');
						print('<td align="right"></td>');
						
						//$am_q = 'select * from arch_module where building_id='.
						
						$q_vals = "(";
						
						for ($i=1; $i<=6; $i++) {
							if ( ($i==3 && ($j==2 || $j==4))  || ($i==5 && ($j==2 || $j==4))   || ($k==3 && $i==5)  || ($i==5 && $j==3 && ($k==1 || $k==4)) ) {
								print('<td>	</td>');
							} else {
								print('	<td align="right" width="80" ">');
							
							
							
								if(isset($_POST[$k.'_'.$j.'_'.$i]) && "".$_POST[$k.'_'.$j.'_'.$i] != "") {
								 	$val = $_POST[$k.'_'.$j.'_'.$i];
								 	$model->setDim($k, $j, $i, $val);
								} else {
									//$val = $dims[$k.'_'.$j.'_'.$i];
									$val = $model->getDim($k, $j, $i);
								}
								
								print('		<input class="show-unsaved" name="'.$k.'_'.$j.'_'.$i.'" value="'.$val.'" style="width:80; padding:0; margin:0; text-align: right" />');
								
								print('	</td>');
								
								if (isset($_POST[$k.'_'.$j.'_'.$i]) && $_POST[$k.'_'.$j.'_'.$i] != "") {
									if ("".$q_vals == "") {
										//$q_vals .= ""
									}
								}
								
								
							}
							
							if ($i==3) {
								print('<td width="10">	</td>');
							}

						}
						
						
						print('</tr>');
					}
				
				}
				print('</table>');				
				
				print('<div style="margin-top:20;text-align:center;">  <input type="submit" /> </div>');
				print('</form>');
				
		
			}
	print("</td></tr></table>");
?>