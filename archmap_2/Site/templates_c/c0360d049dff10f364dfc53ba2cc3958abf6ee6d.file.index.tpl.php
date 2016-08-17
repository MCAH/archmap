<?php /* Smarty version Smarty-3.1.14, created on 2013-09-27 19:53:52
         compiled from "./templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:497930503523cfedac65780-53378176%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0360d049dff10f364dfc53ba2cc3958abf6ee6d' => 
    array (
      0 => './templates/index.tpl',
      1 => 1380326029,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '497930503523cfedac65780-53378176',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523cfedae44ee3_24488512',
  'variables' => 
  array (
    'buildings_json' => 0,
    'lat' => 1,
    'lat2' => 1,
    'lng2' => 1,
    'lng' => 1,
    'name' => 1,
    'itemCount' => 0,
    'buildings' => 0,
    'city' => 0,
    'sites' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523cfedae44ee3_24488512')) {function content_523cfedae44ee3_24488512($_smarty_tpl) {?><meta http-equiv="Content-type" content="text/html; charset=utf-8" />


<body>


<?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('title'=>'foo'), 0);?>


<style>
	body {
		margin: 0;
		padding: 0;
		
		position: relative;
	}
	h2 {
		
		
	}
	#header {
		position: absolute;
		top:0px;
		left:0px;
		
		z-index: 10;

		width: 100%;
		height: 70px;
		background-color:rgba(136,114,68,0.8);
		background-image: -webkit-gradient(
			  linear, left top, right top, from(rgba(136,114,68,1.0)),
			  to(rgba(136,114,68,0.0)), color-stop(0.25,rgb(136,114,68))
			);
			
		color: white;
		
	
	}
	.building_card {
		margin: 10;
		padding: 10;
		min-height: 30px;
		
		font-family: Arial, serif;
	}
	#map-cover {
		background-color: #ffe;
		width: 70%;
		height: 600;
		position: absolute;
		top:100px;
		z-index: 10;

		
		/* /archmap_2/WhiteHorizGradient.png */
		background-color:rgba(255,255,255,0.0);
		background-image: -webkit-gradient(
			  linear, left top, right top, from(rgba(255,255,255,.5)),
			  to(rgba(255,255,255,0.0)), color-stop(0.35,#fff)
			);
	}
	#map-cover-sidebar {
		background-color: #ffe;
		width: 100%;
		height: 300;
		position: absolute;
		top:370px;
		z-index: 10;

		
		/* /archmap_2/WhiteHorizGradient.png */
		background-color:rgba(255,255,255,0.0);
		background-image: -webkit-gradient(
			  linear, left bottom, left top, from(rgba(255,255,255,1.0)),
			  to(rgba(255,255,255,0.0)), color-stop(0.1,#fff)
			);
	}
	#monograph {
		background-color:rgba(255,255,255,0.4);
		width: 70%;
		height: 600;
		position: absolute;
		top:100px;
		z-index: 15;

		
		border-top-style:solid;
		border-right-style:solid;
		border-color:#98805a;
		border-bottom-width: 3;
		
		color: #735632;

	}
	#map-canvas {
		position: absolute;
		top:0px;
		z-index: 0;
	
		width:100%;
		height:670;
		background-color: #eee;
		margin: 0;
		padding: 0;
		

	}
	#unity-content {
		position: absolute;
		top:1px;
		z-index: 1;

		width: 100%;
		
		overflow: hidden;
	}
	#sidebar {
		position: absolute;
		top: 370;
		right: 35;
		z-index: 12;
		
		background-color:rgba(255,255,255,0.6);
		padding: 20;
		
		width: 20%;
	
	}
	#sidebar dl {
		height: 200;
		
		overflow-x: hidden;
		overflow-y: scroll;
	
	}
	.resource-list {
		margin-bottom: 20;
	}
	
	
	div.pictures {
		margin:20;
		float: left;
	}
	
	div.picture-frame {
		border: 1px solid #ddd;
		padding: 20;
		width: 300px;
		height: 320px;
		


	}
	div.picture-frame-shadow  {
		height: 15px;
		background-repeat: no-repeat;
		background-image: url('/archmap_2/media/ui/tile_shadow.png');
		margin-bottom: 20;
	}
	
	.monograph_text {
		padding: 20;
	}
	
	div.project-link {
		padding; 30;
		
		
	
	}

</style>

<script type="text/javascript" src="/archmap_2/js/jquery-1.5.1.min.js"></script> 
<script type="text/javascript" src="/archmap_2/js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript" src="/archmap_2/js/AM_Utilities.js"></script>

		<script type='text/javascript' src='https://ssl-webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/jquery.min.js'></script>
		
		<script type="text/javascript">
		<!--
		var unityObjectUrl = "http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject2.js";
		if (document.location.protocol == 'https:')
			unityObjectUrl = unityObjectUrl.replace("http://", "https://ssl-");
		document.write('<script type="text\/javascript" src="' + unityObjectUrl + '"><\/script>');
		-->
		</script>
		<script type="text/javascript">
		<!--
			var config = {
				width: 1800, 
				height: 670,
				params: { 
					enableDebugging:"0",
					backgroundcolor: "A0A0A0",
					bordercolor: "000000",
					textcolor: "FFFFFF"
				}
				
				
			};
			var u = new UnityObject2(config);
			


			function nuttin() {
			
				return false;
			}

			
			$( document ).ready(function() {

				
				
				$('.scrollable').mouseenter(function(){
                   $("body").css("overflow","hidden");
                });
                $('.scrollable').mouseleave(function(){
                	$("body").css("overflow","auto");
                });
                $('.scrollable').bind('scroll', function() {
                	
                	// scrollTop is  the number of pixels that are hidden from view above the scrollable area.
                	if( $(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight   ||  $(this).scrollTop() == 0) {
                        setTimeout(function(){
                        	$("body").css("overflow","auto");    
                        }, 1000);
                    } else {
                    	//$("body").css("overflow","hidden");
                    }                         
				});
			
			});
			
			
			
			
			
			$(function() {

				var $missingScreen = jQuery("#unityPlayer").find(".missing");
				var $brokenScreen = jQuery("#unityPlayer").find(".broken");
				$missingScreen.hide();
				$brokenScreen.hide();
				
				u.observeProgress(function (progress) {
					switch(progress.pluginStatus) {
						case "broken":
							$brokenScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$brokenScreen.show();
						break;
						case "missing":
							$missingScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$missingScreen.show();
						break;
						case "installed":
							$missingScreen.remove();
						break;
						case "first":
						break;
					}
				});
				//u.initPlugin(jQuery("#unityPlayer")[0], "/archmap_2/unity/Famagusta.unity3d");
			});
		-->
		</script>















<script>
	var bldgs = <?php echo $_smarty_tpl->tpl_vars['buildings_json']->value;?>
;

	var map;
	
	var selectedBuilding;
	
	function initialize() {

		var styles = [
		  {
		    stylers: [
		      { hue: "#e3c7b0" },
		      { saturation: -20 }
		    ]
		  },{
		    featureType: "road",
		    elementType: "geometry",
		    stylers: [
		      { lightness: 100 },
		      { visibility: "simplified" }
		    ]
		  },{
		    featureType: "road",
		    elementType: "labels",
		    stylers: [
		      { visibility: "off" }
		    ]
		  }
		];



		var mapOptions = {
			zoom: 8,
			center: new google.maps.LatLng(-34.397, 150.644),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: styles
		};
		map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
		
		
		// increase bounds to set off center
		// get width
		latHeight 	= Math.abs(<?php echo $_smarty_tpl->tpl_vars['lat']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['lat2']->value;?>
);
		
		var lat1 = <?php echo $_smarty_tpl->tpl_vars['lat']->value;?>
 -  1.8*latHeight;
		
		var lat2 = <?php echo $_smarty_tpl->tpl_vars['lat2']->value+4*'latHeight';?>
;

		lngWidth 	= Math.abs(<?php echo $_smarty_tpl->tpl_vars['lng2']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['lng']->value;?>
);

		var lng1 = <?php echo $_smarty_tpl->tpl_vars['lng']->value;?>
 - 3.3*lngWidth;
		
		
		var lng2 = <?php echo $_smarty_tpl->tpl_vars['lng2']->value;?>
 - lngWidth;
		
		var bounds = new google.maps.LatLngBounds(new google.maps.LatLng(lat1, lng1), new google.maps.LatLng(lat2, lng2));
		map.fitBounds(bounds);
		
		
		var len = bldgs.length;
		for (var i = 0; i<len; i++) {
			
		  createMarkerForBuilding(i, bldgs[i]);
		 
		}	
			
		
	}
	
	var createMarkerAt = function(lat, lng) {
		var latLng, marker;
		  logit("marker at  " + lat+ " " + lng);
		latLng = new google.maps.LatLng(lat, lng);
		marker = new google.maps.Marker({
		position: latLng,
		map: map,
		});
		return marker;
  	}
	var createMarkerForBuilding = function (num, bldg) {
	  var marker, info;
	  logit(bldg.name + " " + bldg.lat+ " " + bldg.lng);
	  marker = createMarkerAt(bldg.lat, bldg.lng);
	  
	  
	  info = new google.maps.InfoWindow({
	    content: '<img src="'+bldg.poster_url+'" />'
	  });
	  google.maps.event.addListener(marker, 'mouseover', function() {
	    info.open(map, marker);
	  });
	  google.maps.event.addListener(marker, 'mouseout', function() {
	    info.close(map, marker);
	  });	
	  google.maps.event.addListener(marker, 'click', function() {
	    info.close(map, marker);
	    selectItem(bldg.id);
	    
	    // scroll to the num item on the monuments list
	    //...
	    $("#items").scrollTop(num*10-10);
	    
	  });

	  
	  return marker;
	}
	
	
	function selectItem(id)	{
		// if only one item selected, then
		
		for (var i = 0; i<bldgs.length; i++) {
			if (bldgs[i].id == id) {
				selectedBuilding = bldgs[i];
				logit("select id=" + id);
				displayProfiles();
				break;
			}
		}

	}
	
	function displayProfiles() {
		// display selected buildings...
		logit("Displaying: " + selectedBuilding.name + " -- " + $("#monograph"));
		//$("#monograph").empty();
		$("#mono_name").html(selectedBuilding.name);
		
	
	}
	
	
	google.maps.event.addDomListener(window, 'load', initialize);

</script>

<div id="header">
<h2><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['name']->value, 'UTF-8');?>
</h2>
</div>

<!-- MAP UNDERLAY -->
<div id="map-canvas">

</div>

<div id="map-cover"> </div>
<div id="map-cover-sidebar"> </div>



	
	
<div id="sidebar">
	<div class="resource-list">
		Register of <?php echo $_smarty_tpl->tpl_vars['itemCount']->value;?>
 Mounments in 
		<div><b><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</b></div>
		<hr>
		<dl id="items" class="scrollable">
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['buildings']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total']);
?>
			
				<?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable(explode(", ",$_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['name']), null, 0);?>
				<dt class="item_name"><?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</dt>
				
			<?php endfor; endif; ?>	
		</dl>
		<hr>
	</div>
</div>	
	
	
	
	
	
<div id="monograph">

	<div class="pictures">
		<div class="poster-view fieldname-poster_id ">
			<div class="picture-frame"></div>
			<div class="picture-frame-shadow" style="width:340px;"></div>
		</div>	
		<div class="poster-view fieldname-poster_id ">
			<div class="picture-frame"></div>
			<div class="picture-frame-shadow" style="width:340px;"></div>
		</div>	
		<div class="poster-view fieldname-poster_id ">
			<div class="picture-frame"></div>
			<div class="picture-frame-shadow" style="width:340px;"></div>
		</div>	
	</div>	
	
	

	<div class="monograph_text">

			<div class="mono-info">
				<h3 id="mono_name"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h3>
				
				<hr>
				
				<div>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>
			</div>
		
		
		
		
			
			<div style="margin-top:50">
			<center>
			
			
			
			Mapping projects served by Archmap: 
			<hr>
				<div>						
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['i'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['sites']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
						<span class="project-link">
						<a href="/archmap_2/Site/Collection?resource=<?php echo $_smarty_tpl->tpl_vars['sites']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['sites']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['name'];?>
</a> | 
						
						</span>
					<?php endfor; endif; ?>	
				</div>
			
			</center>
			</div>
	</div>
</div>
wrewrew

dsadsa


		<div id="unity-content">
			<div id="unityPlayer">
				<div class="missing">
					<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
						<img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
					</a>
				</div>
				<div class="broken">
					<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now! Restart your browser after install.">
						<img alt="Unity Web Player. Install now! Restart your browser after install." src="http://webplayer.unity3d.com/installation/getunityrestart.png" width="193" height="63" />
					</a>
				</div>
			</div>
		</div>



<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



</body>
<?php }} ?>