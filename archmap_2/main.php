<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
	
	error_reporting(E_ERROR | E_PARSE);

	//print_r($_SERVER['REDIRECT_URL']);
	//print_r($_REQUEST);
	
	// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');
		

	// global
	function codebaseDir()  { return 								"/archmap2"; }
	function codebasePath() { return $_SERVER['DOCUMENT_ROOT'] . 	"/archmap_2"; }
	

?>
		
		<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		  <html>
			<head>
				<title>Archmap</title>
				
				<link type="text/css" href="/archmap_2/css/ui-lightness/jquery-ui-1.8.12.custom.css" rel="Stylesheet" />	
				<link rel="stylesheet" type="text/css" href="/archmap_2/css/archmap2.css"/>
				

				
				
				<script>
					<?php
						print ('var redirect_uri = "'. $_SERVER['REDIRECT_URL'].'";');
						
						
						// INITIALIZE LANDING PAGE VARIABLES IN PHP FOR JAVASCRIPT HANDOOF
						print ('var landingEntity;');
						print ('var landingId;');
						
						$url_parts = explode('/', $_SERVER['REDIRECT_URL']);
				
						
						if ($url_parts[1] != "") {
						
							// IS IT AN ENTITY?
							
							switch ($url_parts[1]) {
								case "Building":
								case "Essay":
								case "Person":
								case "HistoricalEvent":
									$entity = $url_parts[1];
									if (is_numeric($url_parts[2])) {
										// ID
										print ('landingEntity = "'.$url_parts[1].'";');
										print ('landingId = "'. $url_parts[2].'";');
									
									} else if ($url_parts[2] != "") {
										// NAME
										$name = str_replace("__", ", ", $url_parts[2]);
										$name = str_replace("_", " ", $name);
										
										//print(" -- ".$name);
										//exit;
										$keys = array();
										$keys['name'] = $name;
										
										switch ($entity) {
											case "Building":
												$model = new Building('KEYS', $keys);
												print ('landingEntity = "Building";');
												print ('landingId = "'. $model->get('id').'";');
												break;
										}
										
									}
									break;
									
								default:
									$keys = array();
									$keys['urlalias'] = $url_parts[1];
									
									$essay = new Essay('KEYS', $keys);
		
									print ('landingEntity = "Essay";');
									print ('landingId = "'. $essay->get('id').'";');
								
							}
						
						
						
							
						}
				?>
				
				</script>
				
						
		
		
		
		
				<!--
				<script src="http://maps.google.com/maps?file=api&amp;v=3&amp;key=ABQIAAAAgJRO_TVqqeU4BAawd660WhQpVk8PodJLxcLOBGfxoFTxJJ4eEhRePzh9_4fl6w0jAUfZ9TPVD3TXnw&sensor=false" type="text/javascript"></script>

				<script type="text/javascript" src="/archmap/appdev/public/script/libraries/js/jquery-ui-1.7.2.custom.min.js"></script>
				<script src="/archmap_2/components/MapView/MapView.js" type="text/javascript">
				</script>
				<script src="/archmap_2/components/MapView/MapView-xml.js" type="text/javascript">
				</script>
				
				-->
			</head>
			<body>	
					<?php
						if  ($essay && $essay->get('isSite')) {
								//print("<style>.site-header {color: white;]</style>");
								//print("<style>". $essay->get('siteCSS') ."</style>");
							}
					?>
					
					
					
					
					<div id="header" class="site-header">
						<?php
						
						
							if  ($essay && $essay->get('isSite')) {
								
								print('<div class="site-header" style="font-size: 48;">');
								print('<span style="width:500;">'. $essay->get('name'). '</span>');
								print(' <span  style="margin-left: 80; font-size: 14;"><a href="/mappinggothic">All Gothic</a> | <a href="/mappinggothicfrance">France</a> | <a href="/mappinggothicengland">England</a> | <a href="/mappinggothicspain">Spain</a> | <a href="mappinggothicgermany">Germany</a> | <a href="mappinggothicitaly">Italy</a> | <a href="mappinggothiccyprus">Cyprus</a> </span>');
								
								print('<img style="margin-left:50;" src="/archmap/media/graphics/Modeler.png" width=70 height=60 />');
								print("</div>");
							}
							
						
						?>
						
					
						<div class="header-sitetitle">ArchMap</div>
						   <span id="header-loginbox" >
						   		<button  id="headerUserButton" class="userButton">Guest</button>
						   		<button  id="loginButton"  onClick="javascript:loginButtonClicked();">Login</button>
						   		
						   </span>
						</div>
						
						
						<div id="header-wrapper">
					
						</div>
						
						<div id="subheader" style="padding: 10;">
							
						</div>
						
						
	
	
					
					 	
					  	
					 
				
				<!-- <div id="map_canvas1" style="width:100%; height:100%"></div> -->
				</div>		

				<div id="fullpage"> 
					
					
				</div>
				 



<!-- TEMPLATES -->


<script id="Model_View"  type="text/x-jquery-tmpl"  class="tmpl">
		<table width="100%">
			<tr>
				<td width="30" valign="top">
					<div class="model-view-background" ></div>
				</td>
				
				<td valign="top" class="model-view">
					<div class="catnum">${catnum}</div> 

					<div><b>
						<div class="inputfield fieldname-name">${name}</div>
					</div></b>					
				</td>
			</tr>
		</table>
</script>


<!-- BUILDING_VIEW -->
<script id="Building_View"  type="text/x-jquery-tmpl"  class="tmpl">
		<table width="100%">
			<tr>
				<td width="30" valign="top">
					<img class="mapIcon" src="/archmap_2/media/ui/maps/mm_20_bluegray2.png" /> 
				</td>
				<td width="100" valign="top">
					<img src="${poster_url}" width=50 height=50 /> 
					<div style="font-size: 9">${id}</div>
				</td>
				<td width="10" valign="top">
					<div class="poster-view fieldname-plan_image_id"></div>
				</td>
				
				<td valign="top" class="model-view">
					
					<!-- cat num -->
					<div class="inputfield relation-field fieldname-catnum catnum">${catnum}</div> 
					
					<!-- name -->
					<div><b>
						<div class="inputfield fieldname-name suggest-replace">${name}</div>
					</div></b>
					
					
					
					<div class="quick-edits">
					
					
						<!-- relate items count -->
						<div class="related-items-summary">
							Related items: <span class="dynnum">${related_count}</span>
						</div>

					
						<div class="slider-set">
							Level of Preservation: 
							<div class="slider preservation"></div>
						</div>
						<div class="slider-set" style="display: none">
							Level of Location Precision: 
							<div class="slider geo_precision"></div>
						</div>
						
						<div class="slider-set">
							Style or Period
							<select name="style">
								<option>None Selected</option>
								<option value="13">Crusader</option>
								<option value="12">Islamic</option>
								<option value="11">Gothic</option>
								<option value="16">Byzantine</option>
								<option value="10">Romanesque</option>
								<option value="14">Indian</option>
								<option value="15">Mesopotamian</option>
							</select>
						</div>
					</div>
					
				</td>
			</tr>
		</table>
</script>



<!-- BUILDING_SHORT_VIEW -->
<script id="Building_Short_View"  type="text/x-jquery-tmpl"  class="tmpl">
		<table width="100%">
			<tr>
				<td width="30" valign="top">
					<img class="mapIcon" src="/archmap_2/media/ui/maps/mm_20_bluegray2.png" /> 
				</td>
				<td width="100" valign="top">
					<img src="${poster_url}" width=50 height=50 /> 
					<div style="font-size: 9">${id}</div>
				</td>
				
				<td valign="top" class="model-view">
					<div class="inputfield relation-field fieldname-catnum catnum">${catnum}</div> 
					<div><b>
						<div class="fieldname-name">${name}</div>
					</div></b>
					
					
					
				</td>
			</tr>
		</table>
</script>



<!-- PUBLICATION_VIEW -->
<script id="Publication_View"  type="text/x-jquery-tmpl"  class="tmpl">
		<div class="model-view-body">
			
			<div class="subtype Chapter BookSection">
				
				<div>
					Chapter <span class="inputfield relation-field fieldname-catnum catnum" placeholder="Chapter Name">${catnum}</span> 
				</div>
				
				<b>
				<div class="inputfield fieldname-name">
					${name}
				</div>
				</b> 
				
				
				<div class="inputfield fieldname-contributors"  placeholder="Chapter Author">
					${contributors}
				
				</div>
			</div>

			<div class="subtype Book EditedBook">
				<div>
				${pubtypeName}  
				</div>
				<div>
					<b>${name}</b>
				</div>
				<div>
					${contributors}, ${date}
				</div>
				<div class="publication-details">
					${publisher}, ${location} 
				</div>
			</div>
			
		</div>
</script>



<!-- SHORT_CITATION_VIEW -->
<script id="ShortCitation_View"  type="text/x-jquery-tmpl"  class="tmpl">
	<div>
		<span class="model-identity profileLink entity-Publication model_id-${id}">${contributors}, ${date}</span>, p. <span class="inputfield relation-field fieldname-pages pages">${pages}</span>
	</div>
</script>





<!-- NOTE_CARD_VIEW -->
<script id="NoteCard_View"  type="text/x-jquery-tmpl"  class="tmpl">
		<div class="model-view-body">
			<div class="inputfield fieldname-name">${name}</div>
			
			<table width="100%" border="0">
				<tr>
					<td>
						<div class="slider-set">
							<select name="cardtype">
								<option>Note Type</option>
								<option value="1">Quote</option>
								<option value="2">Paraphrase</option>
								<option value="3">Summary</option>
								<option value="4">Original Thought</option>
							</select>
							 keywords here...
						</div>
					</td>
					
					<td align="center">
						<div class="pub-pageref">
							p. <span class="inputfield relation-field fieldname-pages pages">${pages}</span> 
						</div>
					</td>
					
					<td width="90px" align="right">
						<div style="font-size: 12;color: #555">
							Public<input type="checkbox" name="public_status"  /> 
						</div>
					</td>

					
				</tr>
			</table>
				
			<div class="textarea fieldname-descript">
${descript} 
			</div>

			
			<!-- PUB CITATIONS -->
			<div class="related-items entity-Publication relationship view-LabelledList_View subview-ShortCitation_View">
				<span class="list-label ">Citations <span class="paran">(<span class="count"></span>)</span></span>
				<ul class="related-items-listview"></ul>
			</div>
			
			
			
			
			<!-- BUILDINGS -->
			<div class="related-items entity-Building  view-LabelledList_View">
				<span class="list-label">Buildings <span class="paran">(<span class="count"></span>)</span></span>
				<ul class="related-items-listview"></ul>
			</div>
	
			<!-- ESSAYS -->
			<div class="related-items entity-Essay  view-LabelledList_View">
				<span class="list-label">Essays Using thie NoteCard <span class="paran">(<span class="count"></span>)</span></span>
				<ul class="related-items-listview"></ul>
			</div>
	
			
		</div>
</script>



<!-- IMAGE_SLIDE_VIEW -->
<script id="ImageSlide_View" type="text/x-jquery-tmpl" class="tmpl">
		<div class="slide-holder">
			<div class="slide">
				<table width="120">
					<tr>
						<td  valign="center" align="center" height="110">
							<img class="slide-image" src="${slideUrl}" />
						</td>
					</tr>
				</table>
			</div>
		</div>
</script>




<!-- LIBRARY_VIEW -->
<script id="Library_View" type="text/x-jquery-tmpl" class="tmpl">
		<div class="information">
			Welcome to the Archmap Library Service! You may search for a publication or create a new one. 
			Begin by simply typing in the fields for title or author. If you find a publication you are interested in you may select it.
			Otherwise, you may continue editing in the form and create a new entry in the system.
		</div>
		<table width="100%">
			<tr>
				<td  id="pubDetail" valign="top" width="50%">
					
					<fieldset id="search_criteria basic" >
						<legend class="search-type">General Search</legend>
						
						<div id="basic_search">
							<div class="full-line">
								<label>Search</label><input class="live-search" name="search" />
							</div>	
						</div>
					</fieldset>
					
					<fieldset id="search_criteria basic" >
						<legend class="search-type">Publication Details</legend>
						
						<div id="advanced_search">
							<div class="full-line">
								<label>Title</label><input class="live-search" name="name" />
							</div>	
				
							<div  class="full-line">
								<label>Author</label><input class="live-search"  name="contributors" />
							</div>	
				
							<div class="full-line">
								<label>Keywords</label><input class="live-search" name="keywords" />
							</div>	
							
							<div class="full-line">
								<label>Publication Type</label>
								<select class="live-search" name="pubtypeName">
									<option>None Specified</option>
									<option>Book</option>
									<option>BookSection</option>
									<option>EditedBook</option>
									<option>Article</option>
								</select>
							</div>	
						</div>	
						
						<div class="full-line">
							<label>Date/Year</label><input class="live-search" name="date" />
						</div>
						
						<div>
							<label>Is Catalog</label><input type="checkbox" name="isCatalog"  />
						</div>	
							
					</fieldset>
					
					<div id="edit_buttons_panel" class="edit-panel">
					rewrew
						<button type="button" id="save">Save, but keep searching</button> 
						<button type="button" id="done">Save and Done</button> 
					</div>
						
					<fieldset class="Book EditedBook">
			
							<div class="full-line">
								<label>Publisher</label><input class="live-search" name="publisher" />
							</div>	
							
							<div class="full-line">
								<label>City</label><input class="live-search" name="location" />
							</div>	
							
							<div class="full-line">
								<label>OCLC Number</label><input class="live-search" name="OCLC" />
							</div>	
							
							<div class="full-line">
								<label>ISBN</label><input class="live-search" name="ISBN" />
							</div>	
							
					
					</fieldset>
					<fieldset class="Article">
			
							<div class="full-line">
								<label>Volume</label><input class="live-search" name="volume" />
							</div>	
							
							<div class="full-line">
								<label>Number</label><input class="live-search" name="number" />
							</div>	
							
							<div class="full-line">
								<label>Pages</label><input class="live-search" name="pages" />
							</div>	
							
					
					</fieldset>
					
				</td>
				<td  valign="top" width="25%" class="localSearch">
					<h4>Local Suggestions</h4>
				</td>
				<td  valign="top" class="remoteSearch">
					<h4>Remote Suggestions</h4>
					
				</td>
			</tr>
		</table>
</script>



<!-- JQUERY -->
<script type="text/javascript" src="/archmap_2/js/jquery-1.5.1.min.js"></script> 
<script type="text/javascript" src="/archmap_2/js/jquery-ui-1.8.16.custom.min.js"></script>


<!-- LOCAL STORAGE -->
<script type="text/javascript" src="/archmap_2/js/jsper.js"></script>

<!-- JSON PARSING -->
<script type="text/javascript" src="/archmap_2/js/json2.js"></script>

<!-- TEMPLATES -->
<script type="text/javascript"  src="/archmap_2/js/jquery.tmpl.min.js">
</script>
<script type="text/javascript"  src="/archmap_2/js/templates-1.1.1/templates.min.js">
</script>

<!-- UNITY -->
<script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject.js"></script>

<!-- GOOGLE MAPS -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<!-- SEADRAGON -->
<script type="text/javascript"  src="/archmap_2/js/seadragon-min.js">
</script>

<!--OPENSEADRAGON-->
<script src="/archmap_2/js/openseadragon.js"></script>

<!--OPENSEADRAGON PLUGIN-->
<script src="/archmap_2/js/openseadragon-scalebar.js"></script>

<!-- PANO_2_VR_PLAYER -->
<script type="text/javascript"  src="/archmap_2/js/pano2vr_player_beautifued.js">
</script>

<!-- PROJECTED OVERLAY -->
<script type="text/javascript"  src="/archmap_2/js/ProjectedOverlay.js">
</script>

<!-- DROPZONE fileupload -->
<script type="text/javascript"  src="/archmap_2/js/dropzone.js">
</script>

<!-- ARCHMAP -->

<script type="text/javascript" src="/archmap_2/js/AM_Utilities.js"></script>
<script type="text/javascript" src="/archmap_2/js/archmap2.1.js"></script>

<script type="text/javascript" src="/archmap_2/js/AM_Models.js"></script>
<script type="text/javascript" src="/archmap_2/js/AM_Views.js?wgunqwweerity3t=0re"></script>





</body>
</html>	
		
	
			<?
	
	
	// ///////// Now Process the MAIN component from the url:		////////////////////
	
?>

