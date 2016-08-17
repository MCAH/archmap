<?php /* Smarty version Smarty-3.1.14, created on 2015-09-06 16:27:11
         compiled from "./templates/Site.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9873665345317aa9b9c13c0-49004819%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85bcd9a5437238b7e3f1853523b9781a7bb305eb' => 
    array (
      0 => './templates/Site.tpl',
      1 => 1441571206,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9873665345317aa9b9c13c0-49004819',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5317aa9ba14ed1_97728765',
  'variables' => 
  array (
    'site' => 1,
    'unityfile' => 1,
    'overlays_json' => 0,
    'buildings_json' => 0,
    'features_json' => 0,
    'urlalias' => 0,
    'page' => 0,
    'mapimage' => 0,
    'mb' => 0,
    'mf' => 0,
    'selected' => 0,
    'mainimage' => 0,
    'latc' => 1,
    'lngc' => 1,
    'zoomc' => 1,
    'sites' => 0,
    'buildings' => 0,
    'bldg' => 0,
    'hgt' => 0,
    'city' => 0,
    'features' => 0,
    'feature' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5317aa9ba14ed1_97728765')) {function content_5317aa9ba14ed1_97728765($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/mgf/archmap_2/Smarty/libs/plugins/modifier.replace.php';
?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==151){?>
	<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Istanbul", true, 0);?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==154){?>
	<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Jerusalem", true, 0);?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==242){?>
	<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Famagusta", true, 0);?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==241){?>
	<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Villa", true, 0);?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==233){?>
	<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Mesopotamia", true, 0);?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==152){?>
	<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Amiens", true, 0);?>
<?php }?>
 

		<script type="text/javascript">
		<!--
			var params = {
				disableContextMenu: false,
				disableExternalCall: false,
				disableFullscreen: false,
				enableDebugging:"0"
			};
			var config = {
				width: 700, 
				height: 500,
				params: params
				
			};
			var u = new UnityObject2(config);

			jQuery(function() {

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
				u.initPlugin(jQuery("#unityPlayer")[0], "/archmap_2/unity/<?php echo $_smarty_tpl->tpl_vars['unityfile']->value;?>
.unity3d");
			});
		-->
		</script>	











<script>
	var viewer;
	
		site_id = <?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
;


		var overlayImages;
		
		<?php if ($_smarty_tpl->tpl_vars['overlays_json']->value){?>
		  
			overlaysImages = <?php echo $_smarty_tpl->tpl_vars['overlays_json']->value;?>
;
			
		<?php }else{ ?> 
			overlayImages = "";
		<?php }?>



		var bldgs;
		
		logit("buildings data inline");
		<?php if ($_smarty_tpl->tpl_vars['buildings_json']->value){?>  
			bldgs = <?php echo $_smarty_tpl->tpl_vars['buildings_json']->value;?>
;
		<?php }else{ ?> 
			bldgs = "";
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['features_json']->value){?>  
			features = <?php echo $_smarty_tpl->tpl_vars['features_json']->value;?>
;
		<?php }else{ ?> 
			features = "";
		<?php }?>
		
	
			

	$( window ).resize(function() {
	
		$('#popup-list').dialog({
			width:300,
			height: $(window).height()-200
		});
		
  	});
	
	$( document ).ready(function() {
	
		
		if (    ( "<?php echo $_smarty_tpl->tpl_vars['urlalias']->value;?>
" == "seals")      && ! thisUser.isLoggedIn)
		{
			window.location = "http://archmap.org?note=<?php echo $_smarty_tpl->tpl_vars['urlalias']->value;?>
";
		}
		if ($_GET("note") != null) {
			switch($_GET("note"))
			{
				case "mesopotamia":
					alert("Please login to access Mapping Mesopotamian Monuments");
					raiseLogin();
					break;
				
				case "seals":
					alert("Please login to access Late Bronze Age Seals");
					raiseLogin();
					break;
			
			}
			
			
		}
	
		logit(" ---- DOCUMENT READY ------ in Site.tpl ------------------------------------------------------------------------ ");

		var imageUrl = '/archmap_2/media/ui/bg-paper.jpg';
		if((site_id && site_id == 1) || <?php if ($_smarty_tpl->tpl_vars['page']->value=="landing"){?>true<?php }else{ ?>false<?php }?>) {
			$('body').css('background-image', 'url(' + imageUrl + ')');
			
			if(site_id && site_id == 1) {
				var overlay = $('<div style="position:absolute;z-index:-1;"><img src="/archmap_2/media/ui/bg-paperWorld.png"/></div>');
				$('body').append(overlay);	
			}
		}
	
		fullPagerEl = $("#full-page-image");
		logit("#sit.tpl: full-page-image");
		
		
		            
                    
        $('.drag-icon').draggable({ 
			opacity: 1.0, 
			cursorAt: { top: 16, left: 16 },
			helper: "clone",
			appendTo: 'body',
			zIndex: 1000001,
			revert: "invalid",
			start: function(event, ui) {
				$(ui.helper).removeClass("enlargeFigureButton");
				$(ui.helper).addClass("image-dragging");
			}
         }); 
         
         
      
		 
         $('#popup-list').dialog({
			autoOpen: true,
			position: [50,150],
			title: "Monuments and Features",
			width: 300,
			height: $(window).height()-200,
			open: function( event, ui ) {$(":focus").blur();}
        });   
		 
		 
		Seadragon.Config.animationTime = .5;
		Seadragon.Config.wrapHorizontal = true;

		 logit("CREATED SEA DRAGON VIEWER 0: ");
		 logit("ADD SEADRAGON VIEWER (#full-page-image)");
		siteImageViewer = addSeadragonViewer(fullPagerEl);
		 logit("CREATED SEA DRAGON VIEWER 3: " + siteImageViewer);

		
		$("#seadragon-sizing-frame").css("height", $(window).height()-25);
		
		//$("#intro-card").css("width", $(window).width()-500);
		$("#intro-card").css("height", $(window).height()*.55);
		//$(".billboards").css("height", ($(window).height()-100)*.25);
		
		
		//$("#intro-card").css("top", $(window).height()*.3);
		
		logit("!!!!! siteImageViewer = " + siteImageViewer);
		
		// Add feature overlays
		setTimeout(function(){
			//addFeatureToSeadragon(siteImageViewer, new Seadragon.Point(0.8438179347826088, 0.64263), "Building", 1484, "Hagia Sophia");
			//addFeatureToSeadragon(siteImageViewer, new Seadragon.Point(0.7511, 0.73234), "Building", 1253, "Sergius and Bacchus");
			//addFeatureToSeadragon(siteImageViewer, new Seadragon.Point(0.3544, 0.2895), "Building", 2413, "Kariye Camii (Chora Church)");
			
			//logit("siteImageViewer="+siteImageViewer);
			//logit("siteImageViewer.viewport="+siteImageViewer.viewport);
			//Seadragon.Config.animationTime = 55;
		
		
		 <?php if ($_smarty_tpl->tpl_vars['page']->value!="landing"){?>
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['bb'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['name'] = 'bb';
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['mapimage']->value['buildings']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['bb']['total']);
?>
				<?php $_smarty_tpl->tpl_vars['mb'] = new Smarty_variable($_smarty_tpl->tpl_vars['mapimage']->value['buildings'][$_smarty_tpl->getVariable('smarty')->value['section']['bb']['index']], null, 0);?>
				
				addFeatureToSeadragon(siteImageViewer, new Seadragon.Point(<?php echo $_smarty_tpl->tpl_vars['mb']->value['pos_x'];?>
, <?php echo $_smarty_tpl->tpl_vars['mb']->value['pos_y'];?>
), "Building", <?php echo $_smarty_tpl->tpl_vars['mb']->value['id'];?>
, "<?php echo $_smarty_tpl->tpl_vars['mb']->value['name'];?>
");
				
			<?php endfor; endif; ?>	
			
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['name'] = 'ff';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['mapimage']->value['features']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total']);
?>
				<?php $_smarty_tpl->tpl_vars['mf'] = new Smarty_variable($_smarty_tpl->tpl_vars['mapimage']->value['features'][$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']], null, 0);?>
			
				addFeatureToSeadragon(siteImageViewer, new Seadragon.Point(<?php echo $_smarty_tpl->tpl_vars['mf']->value['pos_x'];?>
, <?php echo $_smarty_tpl->tpl_vars['mf']->value['pos_y'];?>
), "Feature", <?php echo $_smarty_tpl->tpl_vars['mf']->value['id'];?>
, "<?php echo $_smarty_tpl->tpl_vars['mf']->value['name'];?>
");
				
			<?php endfor; endif; ?>	
		<?php }?>
			
        
			
		}, 2000);
		 	
		setTimeout(function(){
			if (siteImageViewer)
			{
				var h_speed = 0;
				var h_topspeed = .00005;
				
				interval_id = setInterval(function() {
					
					<?php if ($_smarty_tpl->tpl_vars['page']->value=="landing"){?>
						siteImageViewer.viewport.panBy(new Seadragon.Point(-h_speed, 0));
					<?php }?>

					if (h_speed < h_topspeed) {
						h_speed += .0000005;
					} 
					
					
					//logit(viewer.viewport.getCenter().x + ' -- ' + viewer.viewport.getCenter().y + ' -- ' + h_speed);
				}, 50);
			
		 	}
		}, 5000);
		
		
		
		
			
	});

</script>









	<script>
		var bldgs;
		var features;
		
		logit("buildings data inline");
		<?php if ($_smarty_tpl->tpl_vars['buildings_json']->value){?>  
			bldgs = <?php echo $_smarty_tpl->tpl_vars['buildings_json']->value;?>
;
		<?php }else{ ?> 
			bldgs = "";
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['features_json']->value){?>  
			features = <?php echo $_smarty_tpl->tpl_vars['features_json']->value;?>
;
		<?php }else{ ?> 
			features = "";
		<?php }?>
		
		//alert (bldgs);
		var map;
		
		var selectedBuilding;
		
		function initialize() {
	
			mapCanvas = $("#map-canvas");
			logit("have map? " + mapCanvas.length);
			if (mapCanvas.length == 0) 
				return;
			
			
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
			  },{
			        "featureType": "water",
			        "stylers": [
			            {
			                "visibility": "on"
			            },
			            {
			                "color": "#acbcc9"
			            }
			        ]
			    }

			];
	
			<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==152||$_smarty_tpl->tpl_vars['site']->value['id']==154){?>
			styles = [
			    {
			        "featureType": "water",
			        "stylers": [
			            {
			                "visibility": "on"
			            },
			            {
			                "color": "#acbcc9"
			            }
			        ]
			    },
			    {
			        "featureType": "landscape",
			        "stylers": [
			            {
			                "color": "#f2e5d4"
			            }
			        ]
			    },
			    {
			        "featureType": "road.highway",
			        "elementType": "geometry",
			        "stylers": [
			            {
			                "color": "#c5c6c6"
			            }
			        ]
			    },
			    {
			        "featureType": "road.arterial",
			        "elementType": "geometry",
			        "stylers": [
			            {
			                "color": "#e4d7c6"
			            }
			        ]
			    },
			    {
			        "featureType": "road.local",
			        "elementType": "geometry",
			        "stylers": [
			            {
			                "color": "#fbfaf7"
			            }
			        ]
			    },
			    {
			        "featureType": "poi.park",
			        "elementType": "geometry",
			        "stylers": [
			            {
			                "color": "#c5dac6"
			            }
			        ]
			    },
			    {
			        "featureType": "administrative",
			        "stylers": [
			            {
			                "visibility": "on"
			            },
			            {
			                "lightness": 33
			            }
			        ]
			    },
			    {
			        "featureType": "road"
			    },
			    {
			        "featureType": "poi.park",
			        "elementType": "labels",
			        "stylers": [
			            {
			                "visibility": "on"
			            },
			            {
			                "lightness": 20
			            }
			        ]
			    },
			    {
			        "featureType": "road",
			        "stylers": [
			            {
			                "lightness": 20
			            }
			        ]
			    }
			];
			<?php }?>
			
			var mapOptions = {
				zoom: 8,
				center: new google.maps.LatLng(-34.397, 150.644),
				mapTypeId: google.maps.MapTypeId.TERRAIN,
				styles: styles
			};
			
			logit("doc height " + $(window).height());
			$("#map-canvas").css('height', $(window).height());
			
			// CREATE MAP
			
			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			logit("map = " + map);
			
			// for getting drop coordinates
			var overlay = new google.maps.OverlayView();
			overlay.draw = function() {};
			overlay.setMap(map);			
			
			<?php if ($_smarty_tpl->tpl_vars['site']->value['lat']){?>
				var bounds = new google.maps.LatLngBounds(new google.maps.LatLng(<?php echo $_smarty_tpl->tpl_vars['site']->value['lat'];?>
, <?php echo $_smarty_tpl->tpl_vars['site']->value['lng'];?>
), new google.maps.LatLng(<?php echo $_smarty_tpl->tpl_vars['site']->value['lat2'];?>
, <?php echo $_smarty_tpl->tpl_vars['site']->value['lng2'];?>
));
				map.fitBounds(bounds);
			<?php }?>
			
			
			
			
			//alert("yuo: "+overlaysImages[0]['urlLarge']);
			//if (overlayImages)
			//{
				
				var oimg = overlaysImages[1];
				//alert("yo: " + oimg.urlLarge + " " + oimg.lat + ", " + oimg.lng +" : " + oimg.lat2 + ", " + oimg.lng2);
			  var overlaymageBounds = new google.maps.LatLngBounds(
			  new google.maps.LatLng(oimg.lat, oimg.lng),
			  new google.maps.LatLng(oimg.lat2, oimg.lng2));
			  
			 var mapOverlayOptions = {
				opacity: .75
				
				};
			mapOverlay = new google.maps.GroundOverlay(
					 oimg.urlLarge,
					 overlaymageBounds,
					 mapOverlayOptions);
			mapOverlay.setMap(map);
		  
			 
			 
			//}
			
			var len = bldgs.length;
			for (var i = 0; i<len; i++) {
				
			  createMarkerForBuilding(i, bldgs[i]);
			 
			}	
			
			
			$("#map-canvas").droppable({
					
					over: function(event, ui) {
					
						logit("OVER");
						
					},
					out: function(event, ui) {
						//logit("someone is left me! "+ $(event.target).attr('class'));
						
					},
		
					drop: function(event, ui) {
					
						var coordinates = overlay.getProjection().fromContainerPixelToLatLng( new google.maps.Point(event.pageX, event.pageY) );
						var id = ui.draggable.data("id");
						
						logit("DROP: " + coordinates.lat() + " :: " +coordinates.lng() +  "... " +id);
						
						data = {};
						
						data['lat'] = coordinates.lat();
						data['lng'] = coordinates.lng();
						
						saveMultiChanges("Building", id, data);
						
						createMarkerAt(coordinates.lat(), coordinates.lng(), "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png", 2);
					}
				});	
		
				
			
		}
		
		var createMarkerAt = function(lat, lng, iconUrl, zInd) {
			var latLng, marker;
			 // logit("marker at  " + lat+ " " + lng);
			latLng = new google.maps.LatLng(lat, lng);
			marker = new google.maps.Marker({
				position: latLng,
				map: map,
				zIndex: zInd,
				icon: iconUrl,
				scale: .001,
				animation: google.maps.Animation.DROP
			});
			// marker.setAnimation(google.maps.Animation.DROP);
			return marker;
	  	}
		var createMarkerForBuilding = function (num, bldg) {
		  var marker, info;
		 // logit(bldg.name + " " + bldg.lat+ " " + bldg.lng);
		  //logit("num="+num + " : <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
");
		  var zInd = 1;
		  
		  var num = Math.floor((Math.random() * 3) + 1);
		  num = bldg.prec_stories;
		  //if (bldg.stories != "2" || bldg.stories != "3")
		  //	num = 1;
		  if (num >3)
		  	num = 3;
		  	
		  if (num==2)
		  	num=1;
		  var image = {
		    url: '/archmap_2/media/ui/mapIcons/cross_'+num+'.png',
		    // This marker is 20 pixels wide by 32 pixels tall.
		    size: new google.maps.Size(32, 32),
		    // The origin for this image is 0,0.
		    origin: new google.maps.Point(0,0),
		    // The anchor for this image is the base of the flagpole at 0,32.
		    anchor: new google.maps.Point(16, 16)
		  };
		  
		  if (num == <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
) {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png";
		  	zInd = 100;
		  } else {
		  	icon_url = "/archmap_2/media/ui/mapIcons/circle_red_1.png";
		  	//icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
		  }
		  marker = createMarkerAt(bldg.lat, bldg.lng, image, zInd);
		  
		  
		  info = new google.maps.InfoWindow({
		    content: '<img style="z-index:30000;" src="'+bldg.poster_url+'" width="100" height="100"/><div><b>'+bldg.name+'</B> '+bldg.id+'</div>'
		  });
		  google.maps.event.addListener(marker, 'mouseover', function() {
			  logit("OVER");
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
		
		$(window).resize(function() {
			$("#map-canvas").css('height', $(window).height());
  		});
  		
  		
  		
		function selectItem(id)	{
			// if only one item selected, then
			
			for (var i = 0; i<bldgs.length; i++) {
				window.location = "/archmap_2/Site/Collection?resource=<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
&building_id=" + id;
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
		
		
		
		
		
		function setCollectionMapZoomAndPan(essay_id, lat, lng, lat2, lng2)
		{
			
			var data = {};
			
		
			var bnds = map.getBounds();
						
			data['lat'] 	= bnds.getSouthWest().lat();
			data['lng'] 	= bnds.getSouthWest().lng();
			data['lat2'] 	= bnds.getNorthEast().lat();
			data['lng2'] 	= bnds.getNorthEast().lng();
			
			logit(data['lat']);
			saveMultiChanges("Essay", essay_id, data);
		
		}

		function clickedOnSearchResultItem(item)
		{
			logit(item.entity + " " +item.id + " " + item.name + " to " + $('.search-field').attr('data-collection'));
			addItemToList("Essay", $('.search-field').attr('data-collection'), item.entity, item.id, function()
			{
				logit("added");
				createMarkerForBuilding(item.id, item);
			});
		}
		

		function addItem(entity) {
			$("#addBuildingButton").hide();
		
			var newMonForm = $('<div style="width: 100%;margin-bottom:10;"></div>');

			var textField = $('<input data action="add-item" data-collection_id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" style="width:100%;" />');
			newMonForm.append(textField);
			
			
			textField.liveSearch({url: '/api?request=search&notInCollection='+$('.search-field').attr('data-collection')+'&entity='+entity+'&searchString='}, clickedOnSearchResultItem);
			
			
			$("#popup-"+entity+"-list").prepend(newMonForm);
			
									
			textField.bind('keypress', function (e) {
			
			    if(e.keyCode == 13) // ACTUALLY ADD A __NEW__ ITEM (NOT FROM THE DROPDOWN SEARCH RESULTS)
			    {
			       $("#jquery-live-search").empty();
			       
			       // add the building
			       
			        data = {};
			        data['from_entity'] = "Essay";
			        data['from_id'] 	= <?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
;
			        data["name"]		= $(this).val();
			        
			        addRecord(entity, data, function(data) {
			        	
			        	newMonForm.remove();
			        	
			        	
			        	var listItem = $('<div style="width: 200;margin-bottom:10;" data-itemkey="'+entity+'_'+data['id']+'"></div>');
										
						listItem.append('<div class="thumb-city"><a href="/archmap_2/Site/Collection?site=<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
&building_id='+data['id']+'"><b>'+data.name+'</b></a></div>');
						
						var listItemMenu = $('<div class="icon-draggers"></div>');
						
						
						var dragIcon = $('<img class="drag-icon icon32" 	src="/archmap_2/media/ui/CircleIcon.png" 		width="16" height="16"  data-entity="Building" data-id="'+data.id+'" data-name="'+data.name+'" />');
						
						dragIcon.draggable({
							 opacity: 0.7, 
							 helper: "clone"
							 });
							 
							 listItemMenu.append
						
						listItem.append(dragIcon);
						
						listItem.append('<div class="edit-mode-only" style="clear:both";"><button onclick="remove(\''+entity+'\', '+data.id+');"><b>-</b></button></div>');

			        	$("#popup-"+entity+"-list").prepend(listItem);
			        });
			    }
			});
		}
		
		function removeItem(entity, id) 
		{
			removeItemFromList("Essay", <?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
, entity, id, function(data) {
				
				$('[data-itemkey='+entity+'_'+id+']').hide(100, function() { $(this).remove(); });
			});
		}
		
		
			
		

	
	</script>






		<!-- MAP or MAINIMAGE -->
		<?php if ($_smarty_tpl->tpl_vars['mainimage']->value){?>
			<div id="full-page-image" class="image-droppable" 	style="margin:0; margin-top:80; padding:0;" data-fieldname="landingimage_id"	data-entity="Image" 	data-id="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['id'];?>
" 	data-image_type="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['image_type'];?>
" 		data-filesystem="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['filesystem'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['filename'];?>
" data-filepath="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['filepath'];?>
"  data-image_id="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['id'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['has_sd_tiles'];?>
"  	data-pan="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['pan'];?>
"  data-tilt="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['tilt'];?>
"  data-fov="<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['fov'];?>
">
				<div class="poster-view fieldname-poster_id">
					<div id="seadragon-sizing-frame" style="width: 100%; height: 600;">
						<div id="image-viewer-<?php echo $_smarty_tpl->tpl_vars['mainimage']->value['id'];?>
" class="imageArea imageViewer">
							
						</div>
						
					</div>
					<div class="picture-frame-shadow" style="width:100%;"></div>
				</div>	
			</div>	
		
		<?php }else{ ?>

			<?php if ($_smarty_tpl->tpl_vars['page']->value=="map"){?>
				<div id="map-canvas" style="width:100%;height: 600px"></div>
				
				
				<script>
				
				var map1 = L.map('map-canvas1').setView([51.505, -0.09], 13);
				// add an OpenStreetMap tile layer
				L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
				}).addTo(map1);

				</script>
				
				
			<?php }?>
			
		<?php }?>

		
		
		
		
		
		
		
		<!-- POPUPS -->
		
		<?php if ($_smarty_tpl->tpl_vars['page']->value=="landing"){?>
		<!-- Raise the intor text/card -->
			<div id="intro-card" class="map-dialog" >
				
	
				
			
				<div class="monograph_text">


						<div class="mono-info">
							
							<h1>
							<span  data-entity="Essay" data-id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-field="name" class="editable" contenteditable="false" style="font-size: 32;opacity:.8"><?php echo $_smarty_tpl->tpl_vars['site']->value['name'];?>
</span>
							</h1>
							
							<hr>
							
							<?php $_smarty_tpl->tpl_vars['latc'] = new Smarty_variable(($_smarty_tpl->tpl_vars['site']->value['lat']+($_smarty_tpl->tpl_vars['site']->value['lat2']-$_smarty_tpl->tpl_vars['site']->value['lat'])/2), true, 0);?>
							<?php $_smarty_tpl->tpl_vars['lngc'] = new Smarty_variable(($_smarty_tpl->tpl_vars['site']->value['lng']+($_smarty_tpl->tpl_vars['site']->value['lng2']-$_smarty_tpl->tpl_vars['site']->value['lng'])/2), true, 0);?>
							<?php if (($_smarty_tpl->tpl_vars['site']->value['lat2']-$_smarty_tpl->tpl_vars['site']->value['lat'])>4){?>
								<?php $_smarty_tpl->tpl_vars['zoomc'] = new Smarty_variable(4, true, 0);?>
							<?php }else{ ?>
								<?php $_smarty_tpl->tpl_vars['zoomc'] = new Smarty_variable(6, true, 0);?>
							<?php }?>
							<?php $_smarty_tpl->tpl_vars['lngc'] = new Smarty_variable(($_smarty_tpl->tpl_vars['site']->value['lng']+($_smarty_tpl->tpl_vars['site']->value['lng2']-$_smarty_tpl->tpl_vars['site']->value['lng'])/2), true, 0);?>
							
							<div style="float:right">
								<?php if ($_smarty_tpl->tpl_vars['mapimage']->value['url300']){?>
								<div>
									<a href="/<?php echo $_smarty_tpl->tpl_vars['site']->value['urlalias'];?>
/map"><img class="map-icon" src=<?php echo $_smarty_tpl->tpl_vars['mapimage']->value['url300'];?>
 width="300" height="300"/></a>
								</div>
								
								<?php }else{ ?>
								
								<?php if ($_smarty_tpl->tpl_vars['site']->value['id']!=1){?>
								<div style="padding:12;margin:15;background-color:rgba(255,255,255,.5);">
								<a href="/<?php echo $_smarty_tpl->tpl_vars['site']->value['urlalias'];?>
/map">
								<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $_smarty_tpl->tpl_vars['latc']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['lngc']->value;?>
&zoom=<?php echo $_smarty_tpl->tpl_vars['zoomc']->value;?>
&size=180x180&maptype=terrain
										&markers=color:red%7Clabel:S%7C<?php echo $_smarty_tpl->tpl_vars['latc']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['lngc']->value;?>
&sensor=false&key=AIzaSyDzJ5COaHF8BYgs-CNi-Jr1r49nysl385I" />
								</a>
								</div>
								<?php }?>
								<?php }?>
								
								
											
						
							

							</div>
							

							<div id="thedescript" data-entity="Essay" data-id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-field="descript" class="editable" contenteditable="false">
								<?php echo $_smarty_tpl->tpl_vars['site']->value['descript'];?>

								
								
							</div> 
						
							<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==151||$_smarty_tpl->tpl_vars['site']->value['id']==154||$_smarty_tpl->tpl_vars['site']->value['id']==242||$_smarty_tpl->tpl_vars['site']->value['id']==233||$_smarty_tpl->tpl_vars['site']->value['id']==152){?>
								
								<div class="content" style="margin-top:50;text-align:center;z-index:20000;float:right">
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
								
							<?php }?>
														
							<?php if ($_smarty_tpl->tpl_vars['sites']->value){?>	
								<div class="billboards">						
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
									<div class="site-billboard" >
										<span class="project-link">
										<a href="/<?php echo $_smarty_tpl->tpl_vars['sites']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['urlalias'];?>
"><?php echo $_smarty_tpl->tpl_vars['sites']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['name'];?>
</a> 
										</span>
									</div>
									<?php endfor; endif; ?>
								</div>
								
							
							<?php }?>
									
						</div>
				</div>
			


	
						<!-- pinterest cards -->
						
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop='buildings') ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							hi
							<?php $_smarty_tpl->tpl_vars['bldg'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']], null, 0);?>
							<div class="monograph-thumb grid"> 
								<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>

								<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['height'];?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['width'];?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['hgt'] = new Smarty_variable((250*$_tmp1/$_tmp2), null, 0);?>
								<?php $_smarty_tpl->tpl_vars['hgt'] = new Smarty_variable(250, null, 0);?>
								
								<div class="picture link " data-building_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['image_type'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['filename'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['id'];?>
">
										<div class="poster-view fieldname-poster_id ">
											<div class="picture-frame" >
													<div class="imageAreaGrid">				
															<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster_url300'];?>
" width="250" height="<?php echo $_smarty_tpl->tpl_vars['hgt']->value;?>
"  />
															
															<!--	
															<img src="<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['latsec_url'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['width']/10;?>
" height="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['height']/10;?>
" />
															-->
													</div>
												
												
													<div class="picture-title"><?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
</div>
													
											</div>
											<div class="picture-frame-shadow" style="width:240px;"></div>
										</div>	
								</div>	
								
							</div>
							
						<?php endfor; endif; ?>	


			
								
				<!-- ALL IMAGES -->
				
				<div id="imageTray" style="margin-top:15;">
				
			
					<div class="imageuploderWidget edit-mode-only"  data-from_entity="Essay" data-from_id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
"  >
						<span class="uploadImagesButton" >[+ Upload Images ]</span>
					</div>
			
					<div id="allEssayImages"  data-entity="Essay" data-id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
">
			  
					</div>
			
				
				
				</div>	
				
				<script>
					var allImages = $("#allEssayImages");
					
					openImageGalleryOnPage(allImages);
				</script>

				<!--
				<div class="imageuploderWidget edit-mode-only"  data-from_entity="Essay" data-from_id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
"  >
					<span class="uploadImagesButton" >[+ Upload Images ]</span>
				</div>
				-->
		
			
			
			</div>
		
		<?php }?>
		
		
		
		<?php if ($_smarty_tpl->tpl_vars['page']->value=="map"){?>
		<!-- raise the building list for this site -->
				
			<div id="popup-list" style="width:560;height:560;overflow-y:scroll;">	
				<h3>Monuments</h3>
				<div class="edit-mode-only" style="margin-bottom:10;">
					<div>
						<button id="addBuildingButton" onclick="addItem('Building');">Add a Building</button>
					</div>
				</div>

				
				<div id="popup-Building-list">
							
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
							<?php $_smarty_tpl->tpl_vars['bldg'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']], null, 0);?>
								
								<div style="width: 260;font-size:10;margin-bottom:10;clear:right;" data-itemkey="Building_<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">
										<div>
										
												
											<!--
											<img class="drag-icon thumb-icon"  src="<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['poster_url300'],'300','50');?>
" width="32" height="32"  data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
"  />
											-->
											
											<table width="100%">
												<tr>
													<td valign="top">
														<a href="/archmap_2/Site/Collection?site=<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
&building_id=<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">
															- <b style="font-size:10;"><?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
, <?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</b>
														</a>
													</td>
													<td valign="top" width="25">
														<img class="drag-icon" style="float: right;" 	src="/archmap_2/media/ui/CircleIcon.png" 		width="16" height="16"  data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
" />
													</td>
												</tr>
											</table>
										
											<!--
											<img src="<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['plan_url'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['width']/10;?>
" height="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['height']/10;?>
" />
											-->
										</div>
										
										<div class="edit-mode-only">
											<button onclick="removeItem('Building', <?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['id'];?>
);"><b>-</b></button>
										</div>
									
										
								</div>
						<?php endfor; endif; ?>	
						
				</div>
				
				
				
				<h3 style="margin-top:30;">Features</h3>
				
				
				<div class="edit-mode-only" style="margin-bottom:10;">
					<button onclick="addItem('Feature');">Add a Feature</button>
				</div>

				<div id="popup-Feature-list">
							
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['fi'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['name'] = 'fi';
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['features']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['fi']['total']);
?>
							
							<?php $_smarty_tpl->tpl_vars['feature'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['fi']['index']], null, 0);?>
								
								<div style="width: 260;margin-bottom:10;" data-itemkey="Feature_<?php echo $_smarty_tpl->tpl_vars['feature']->value['id'];?>
">
										
										<div class="thumb-city">
											<a href="/archmap_2/Site/Collection?site=<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
&entity=Feature&id=<?php echo $_smarty_tpl->tpl_vars['feature']->value['id'];?>
"><b><?php echo $_smarty_tpl->tpl_vars['feature']->value['name'];?>
</b></a></div>
							
										<div style="clear:right;">	
											<img class="drag-icon thumb-icon"  src="<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['feature']->value['poster_url300'],'300','50');?>
" width="32" height="32"  data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['feature']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['feature']->value['name'];?>
"  />
											<span style="opacity: .6;"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['feature']->value['refnum'],'serdar_seals_','no. ');?>
</span>
											<img class="drag-icon " style="float:right"	src="/archmap_2/media/ui/CircleIcon.png" 		width="16" height="16"  data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['feature']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['feature']->value['name'];?>
" />
										</div>
										<div class="edit-mode-only">
											<button onclick="removeItem('Feature', <?php echo $_smarty_tpl->tpl_vars['feature']->value['id'];?>
);"><b>-</b></button>
										</div>
									
										
								</div>
						<?php endfor; endif; ?>	
						
				</div>
				
			</div>		

			<?php }?>


			<div class="map-edit-panel edit-mode-only">
				<h3>Map Editing</h3>
				<div>
					<button onclick="setCollectionMapZoomAndPan(<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
)">Set Map</button>
				</div>
			</div>


<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<?php }} ?>