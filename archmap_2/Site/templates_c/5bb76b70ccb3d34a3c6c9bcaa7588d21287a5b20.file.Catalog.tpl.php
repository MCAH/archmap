<?php /* Smarty version Smarty-3.1.14, created on 2014-05-29 17:08:39
         compiled from "./templates/Catalog.tpl" */ ?>
<?php /*%%SmartyHeaderCode:131065437452e1727d5a6941-48046618%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5bb76b70ccb3d34a3c6c9bcaa7588d21287a5b20' => 
    array (
      0 => './templates/Catalog.tpl',
      1 => 1401397715,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131065437452e1727d5a6941-48046618',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52e1727d7fcb40_05963991',
  'variables' => 
  array (
    'buildings_json' => 0,
    'node' => 1,
    'selected' => 0,
    'itemCount' => 0,
    'site' => 0,
    'alpha_buildings' => 0,
    'city' => 0,
    'pageTitle' => 0,
    'buildings' => 0,
    'subtype' => 0,
    'k' => 0,
    'features' => 0,
    'imageViews' => 0,
    'size' => 0,
    'figCount' => 0,
    'bldg' => 0,
    'featureCount' => 0,
    'attibutes' => 0,
    'tagItems' => 0,
    'publications' => 0,
    'pub' => 0,
    'image' => 0,
    'w' => 0,
    'h' => 0,
    'plots' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52e1727d7fcb40_05963991')) {function content_52e1727d7fcb40_05963991($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	


	<script>
		var bldgs;
		
		logit("buildings data inline");
		<?php if ($_smarty_tpl->tpl_vars['buildings_json']->value){?>  
			bldgs = <?php echo $_smarty_tpl->tpl_vars['buildings_json']->value;?>
;
		<?php }else{ ?> Description 
			bldgs = "";
		<?php }?>
		
		//alert (bldgs);
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
			latHeight 	= Math.abs(<?php echo $_smarty_tpl->tpl_vars['node']->value['lat'];?>
 - <?php echo $_smarty_tpl->tpl_vars['node']->value['lat2'];?>
);
			
			var lat1 = <?php echo $_smarty_tpl->tpl_vars['node']->value['lat'];?>
 -  1.8*latHeight;
			
			var lat2 = <?php echo $_smarty_tpl->tpl_vars['node']->value['lat2']+5.5*'latHeight';?>
;
	
			lngWidth 	= Math.abs(<?php echo $_smarty_tpl->tpl_vars['node']->value['lng2'];?>
 - <?php echo $_smarty_tpl->tpl_vars['node']->value['lng'];?>
);
	
			var lng1 = <?php echo $_smarty_tpl->tpl_vars['node']->value['lng'];?>
 - 4.6*lngWidth;
			
			
			var lng2 = <?php echo $_smarty_tpl->tpl_vars['node']->value['lng2'];?>
 - lngWidth;
			
			var bounds = new google.maps.LatLngBounds(new google.maps.LatLng(lat1, lng1), new google.maps.LatLng(lat2, lng2));
			map.fitBounds(bounds);
			
			
			var len = bldgs.length;
			for (var i = 0; i<len; i++) {
				
			  createMarkerForBuilding(i, bldgs[i]);
			 
			}	
				
			
		}
		
		var createMarkerAt = function(lat, lng, iconUrl, zInd) {
			var latLng, marker;
			 // logit("marker at  " + lat+ " " + lng);
			latLng = new google.maps.LatLng(lat, lng);
			marker = new google.maps.Marker({
				position: latLng,
				map: map,
				zIndex: zInd,
				icon: iconUrl
			});
			return marker;
	  	}
		var createMarkerForBuilding = function (num, bldg) {
		  var marker, info;
		 // logit(bldg.name + " " + bldg.lat+ " " + bldg.lng);
		  //logit("num="+num + " : <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
");
		  var zInd = 1;
		  if (num == <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
) {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png";
		  	zInd = 100;
		  } else {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
		  }
		  marker = createMarkerAt(bldg.lat, bldg.lng, icon_url, zInd);
		  
		  
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
				window.location = "/archmap_2/Site/Collection?resource=<?php echo $_smarty_tpl->tpl_vars['node']->value['id'];?>
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
	
	</script>
	
	
	
	
	
	
	
	
	<!-- MAP UNDERLAY -->
	<div id="map-canvas">
	
	</div>
	
	<div id="map-cover"> </div>
	<div id="map-cover-sidebar"> </div>
	
	
	
		
		
	<div id="sidebar">
		<div class="resource-list  item-list">
			Register of <?php echo $_smarty_tpl->tpl_vars['itemCount']->value;?>
 Monuments in 
			<div><b><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
</b></div>
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<div>
					<button class="addItemToCollectionButton" data-from_entity="Essay" data-from_id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-to_entity="Building">Add a Building</button>
				</div>
			</div>

			
			<dl class="items scrollable">
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alpha_buildings']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				
					<?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable(explode(", ",$_smarty_tpl->tpl_vars['alpha_buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['name']), null, 0);?>
					<dt class="item_name"><a href="?resource=<?php echo $_smarty_tpl->tpl_vars['node']->value['id'];?>
&building_id=<?php echo $_smarty_tpl->tpl_vars['alpha_buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['city']->value[0];?>
, <?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</a></dt>
					
				<?php endfor; endif; ?>	
			</dl>
			<hr>
		</div>
	</div>	
		
		
		
		
	<div id="main-content">
	
		
		
		
		<div class style="width:100%; text-align:right;">
			<span class="download-button">Download as Document</span>
		</div>
		<h1 style="margin-bottom: 10;padding-bottom:0;"><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</h1>
		<div id="closeContent">
			<img src ="/archmap_2/media/ui/close.png" width="25" height="25" />
		</div>

		<div id="wysiwyg-text-edit-menu">
			<button  id="addFootnoteButton" class="footnoteButton edit-show" hidden>Add Footnote</button>
			<button  id="addFigureButton" class="citationButton edit-show addFigureButton" hidden>Add Figure</button>
			<button  id="addCitationButton" class="citationButton edit-show" hidden>Add Citation</button>
		</div>
		
				
		








































						
	<div class="page-gallery">
		
		<?php $_smarty_tpl->tpl_vars['figCount'] = new Smarty_variable(1, null, 0);?>
		<?php $_smarty_tpl->tpl_vars['featureCount'] = new Smarty_variable(1, null, 0);?>

		
		
		<!-- EACH BUILDING -->	
			
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
				
						
		<!-- BUILDING FEATURES -->
		
		<?php $_smarty_tpl->tpl_vars['subtype'] = new Smarty_variable("lintel", null, 0);?>
						
		<?php $_smarty_tpl->tpl_vars['features'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['features'], null, 0);?>
		
		<div id="feature-list-items" >
			
				
				<div class="feature-block list-block" data-entity="Feature" data-subtype="<?php echo $_smarty_tpl->tpl_vars['subtype']->value;?>
" data-relationship="incorporates">
				
					<div class="list-block-label"><b><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</b></div>
						
						
						<!-- EACH FEATURE -->
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['name'] = 'ff';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['features']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
							<div>
								
										<!-- GALLERY -->
										<?php $_smarty_tpl->tpl_vars['imageViews'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['imageViews'], null, 0);?>
										
										<?php if ($_smarty_tpl->tpl_vars['imageViews']->value){?>
											<!-- EACH THUMBNAIL -->
											<?php $_smarty_tpl->tpl_vars['size'] = new Smarty_variable(175, null, 0);?>
											<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['name'] = 'iv';
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['imageViews']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total']);
?>
											<?php if ($_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]){?>
												<div class="image-view-thumbnail300 deletable" style="margin-right: 5;margin-bottom: 5;width:<?php echo $_smarty_tpl->tpl_vars['size']->value;?>
; min-height:270;" data-entity="ImageView" data-id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
" data-image_id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_type'];?>
"  data-filesystem="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filesystem'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['fov'];?>
">
													<img class="thumbnail enlargeFigureButton" title="Rory O'Neill, April, 2012   (AM.IMG  <?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
)" src="/archmap/media/imageviews/000/<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
_300.jpg" width="175" height="175" />
													<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
													<div>
														<B>Fig. <?php echo $_smarty_tpl->tpl_vars['figCount']->value++;?>
</B>
														<div style="font-size: 10">
															<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>

														</div>
														<div style="font-size: 10">
															<a href="/archmap_2/Site/Collection?resource=<?php echo $_smarty_tpl->tpl_vars['node']->value['id'];?>
&building_id=<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['name'];?>
</a>
														</div>
														<div style="font-size: 10">
															Rory O'Neill, April, 2012
														</div>
													</div>
												</div> 
											<?php }?>
											<?php endfor; endif; ?>
										
										<?php }?>
							</div>
			
						<?php endfor; endif; ?>
		<?php endfor; endif; ?>
			
	</div>
				




























































































		
		
		
		<?php $_smarty_tpl->tpl_vars['figCount'] = new Smarty_variable(1, null, 0);?>
		<?php $_smarty_tpl->tpl_vars['featureCount'] = new Smarty_variable(1, null, 0);?>

		
		
		<!-- EACH BUILDING -->	
			
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

			<?php $_smarty_tpl->tpl_vars['size'] = new Smarty_variable(125, null, 0);?>
			<?php $_smarty_tpl->tpl_vars['thumbsize'] = new Smarty_variable(100, null, 0);?>

			<div class="mono-profile entity-profile catalog-item" data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">
				
				
				<!-- HEADER -->
				
				<table width="100%">
					<tr>
						<td valign="bottom">
						
							<div>
							AM.<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>

							</div>
							
							<div class="catalog-item-title">
							<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
, ca. <?php echo $_smarty_tpl->tpl_vars['bldg']->value['beg_year'];?>

							</div>
						</td>
						
						
						
					</tr>
				</table>
							
				<hr>
				
				<div style="text-align:right;">
					<span id="seeAlImages" class="openImageGallery">All Images</span>
					</div>
	
	
	
	
	
	
		
					<!-- BUILDING CONTENT -->
									
					<table width="100%">
					<tr>	
			
						
						
						<td valign="top">
						
						
							
					
										
										
											
							<!-- BUILDING FEATURES -->
							<?php if (true){?>
							<?php $_smarty_tpl->tpl_vars['subtype'] = new Smarty_variable("lintel", null, 0);?>
											
							<?php $_smarty_tpl->tpl_vars['features'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['features'], null, 0);?>
							<?php echo $_smarty_tpl->tpl_vars['features']->value;?>

							<div id="feature-list-items" >
								
									
									<div class="feature-block list-block" data-entity="Feature" data-subtype="<?php echo $_smarty_tpl->tpl_vars['subtype']->value;?>
" data-relationship="incorporates">
									
										<div class="list-block-label"><b><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</b></div>
										
										
										
										
										<!-- EACH FEATURE -->
										<div class="list-block-items">
										<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['name'] = 'ff';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['features']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
											
												<div class="entity-profile feature deletable card-stock" data-entity="Feature"  data-subtype="<?php echo $_smarty_tpl->tpl_vars['subtype']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
">
													
													<table width="100%">
														<tr>
															
															
															<td valign="top">
																<img class="drag-icon icon32" 			src="/archmap_2/media/ui/FeatureIcon.png" 		width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
																
																<!-- FEATURE SERIAL NUMBER -->
																<b>LIN.<?php echo $_smarty_tpl->tpl_vars['featureCount']->value++;?>
</b> (AM.<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
)
																
																<div data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-field="name"     class="editable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name']){?><?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
<?php }else{ ?>name<?php }?></div>
																
																
																<div>
																	<img class="attributes-icon icon32 tooltip-default"  title="Show Attributes"	src="/archmap_2/media/ui/AttributesIcon.png" 	width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
															
																	<div class="attributes-sheet">
																		Attributes
																		<hr>
																		<?php $_smarty_tpl->tpl_vars['attibutes'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['attributes'], null, 0);?>
																		
																		<?php if ($_smarty_tpl->tpl_vars['attibutes']->value){?>
																		
																			<ul>
																			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['aa'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['name'] = 'aa';
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['attibutes']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total']);
?>
																			
																				<li><input data-attr_id="<?php echo $_smarty_tpl->tpl_vars['attibutes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['aa']['index']]['attr_id'];?>
" type=checkbox <?php if ($_smarty_tpl->tpl_vars['attibutes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['aa']['index']]['val']==1){?>checked<?php }?>><label><?php echo $_smarty_tpl->tpl_vars['attibutes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['aa']['index']]['name'];?>
</label></li>
																			<?php endfor; endif; ?>
																			</ul>
																			<?php }else{ ?>
																		No attributes currently.
																		<?php }?>
																	</div>
																</div>
																
																<div data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-field="descript" class="editable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['descript']){?><?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['descript'];?>
<?php }else{ ?> <?php }?></div>
																
																<div class="item-footer">
																	
																	
																	<!-- TAGS -->
																	<!--
																	<?php $_smarty_tpl->tpl_vars['tagItems'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['tagItems'], null, 0);?>
																	<div class="tag-items">Tags: 
																		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['itag'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['name'] = 'itag';
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['tagItems']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total']);
?>
																			<span class="tag-item"><?php echo $_smarty_tpl->tpl_vars['tagItems']->value[$_smarty_tpl->getVariable('smarty')->value['section']['itag']['index']];?>
</span>
																		<?php endfor; endif; ?>
																		<span><img class="addTag new button edit-mode-only tooltip-default"  src="/media/ui/buttons/ButtonPlusNormal.png" title="Add a Tag" width=16 height=16 /></span>
																	</div>
																	-->
																	
																	<div> - <a href=""><?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['author_name'];?>
</a>, <?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['editdateString'];?>
</div>
																</div>
													
															</td>
															
														</tr>
														
														
														<tr>
															<td valign="top"  class="item-gallery" data-entity="ImageView">
																<img class="images-icon icon32" 			src="/archmap_2/media/ui/PhotosIcon.png" title="Show Images (shift-click for all images)"		width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
					
																<div class="gallery-row" style="display:none;">
																	<hr>
																
																	<!-- GALLERY -->
																	<?php $_smarty_tpl->tpl_vars['imageViews'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['imageViews'], null, 0);?>
																	
																	<?php if ($_smarty_tpl->tpl_vars['imageViews']->value){?>
																		<!-- image thumbnails -->
																		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['name'] = 'iv';
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['imageViews']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total']);
?>
																			<div class="image-view-thumbnail300 deletable" data-entity="ImageView" data-id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
" data-image_id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_type'];?>
"  data-filesystem="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filesystem'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['fov'];?>
">
																				<img class="thumbnail enlargeFigureButton" title="Rory O'Neill, April, 2012   (AM.IMG  <?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
)" src="/archmap/media/imageviews/000/<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
_300.jpg" width="175" height="175" />
																				<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
																				<div>
																				<B>Fig. <?php echo $_smarty_tpl->tpl_vars['figCount']->value++;?>
</B>
																				</div>
																			</div> 
																			
																		<?php endfor; endif; ?>
																		<div class="gallery menu edit-mode-only"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>
						
																	<?php }else{ ?>
																		<!-- no image icon -->
																		<div class="image-view-thumbnail no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="175" height="175" /></div>
																		
																	<?php }?>
																	
																	</div>
																		
															</td>
														</tr>
														
														
														
													</table>
													
													<div class="footer">
														<div class="menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
													</div>
												</div>
											
										
										<?php endfor; endif; ?>
										</div>
										
										<div class="footer">
											<img class="addButton new button edit-mode-only" title="Add an item to this list" src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 />
										</div>
					
									</div>
									
							
					
								</div>				
											
								<?php }?>			
											
											
											
											
											
											
								
							<!-- BIBLIOGRAPHY -->
							<div style="margin-bottom: 40;">
					
								<!--
								<div class="rubric list-addable"  data-entity="Publication">Bibliography<hr></div>
								-->
							
							
						
								<div class="edit-mode-only" style="margin-bottom:10;">
									<div>
										<button class="addItemToCollectionButton" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication">Add a Publication</button>
										<button class="addItemFromZoteroButton" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication">Import from Zotero</button>
									</div>
								</div>
					
								
								<div class="biblio-import-widget edit-mode-only"></div>
							
								
								<div>
									<?php $_smarty_tpl->tpl_vars['publications'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['publications'], null, 0);?>
									
									<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['p'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['p']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['name'] = 'p';
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['publications']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total']);
?>
									
										<?php $_smarty_tpl->tpl_vars['pub'] = new Smarty_variable($_smarty_tpl->tpl_vars['publications']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']], null, 0);?>
									
										<li class="entity-profile deletable biblio-record"    data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
">
											
											<span class="biblio-link"><?php echo $_smarty_tpl->getSubTemplate ("PubStyle_ArtHistory.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</span><?php if ($_smarty_tpl->tpl_vars['pub']->value['pages']){?>,<?php }?> <span data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication" data-to_id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-fieldname="pages" class="editable" contenteditable="false" ><?php echo $_smarty_tpl->tpl_vars['pub']->value['pages'];?>
</span>
											
										</li>
									
									<?php endfor; endif; ?>
								</div>	
									
							</div>

												
											
											
										
										
										
										
				
							</td>
										
					
					
					
					
					
					
							<!-- BULDING POSTERS -->
								
						
						<!-- BUILDING DEPICTIONS -->
						
						<td width="100">
									
								<!-- POSTER -->
								<div class="monograph-thumb"> 
									<div class="picture link " data-building_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['image_type'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['filename'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['id'];?>
">
											<div class="poster-view fieldname-poster_id ">
												<div class="imageAreaGrid">				
														<img src="<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['poster_url300'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['size']->value;?>
" height="<?php echo $_smarty_tpl->tpl_vars['size']->value;?>
"  />
														
														<!--	
														<img src="<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['latsec_url'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['width']/10;?>
" height="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['height']/10;?>
" />
														-->
												</div>
											</div>	
									</div>	
								</div>
								
						</td>
						
						<td width="100">
					
					
								
								<!-- PLAN -->
								<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['planImage'], null, 0);?>
								<?php if ($_smarty_tpl->tpl_vars['image']->value){?>
							
								<div style="border: solid 2 gray;width: <?php echo $_smarty_tpl->tpl_vars['size']->value;?>
; height: <?php echo $_smarty_tpl->tpl_vars['size']->value;?>
; position: relative">
									
								
									<?php if ($_smarty_tpl->tpl_vars['image']->value['width']>$_smarty_tpl->tpl_vars['image']->value['height']){?>
										<?php $_smarty_tpl->tpl_vars['w'] = new Smarty_variable($_smarty_tpl->tpl_vars['size']->value, null, 0);?>
										<?php $_smarty_tpl->tpl_vars['h'] = new Smarty_variable($_smarty_tpl->tpl_vars['w']->value*($_smarty_tpl->tpl_vars['image']->value['height']/$_smarty_tpl->tpl_vars['image']->value['width']), null, 0);?>
									<?php }else{ ?>
										<?php $_smarty_tpl->tpl_vars['h'] = new Smarty_variable($_smarty_tpl->tpl_vars['size']->value, null, 0);?>
										<?php $_smarty_tpl->tpl_vars['w'] = new Smarty_variable($_smarty_tpl->tpl_vars['h']->value*($_smarty_tpl->tpl_vars['image']->value['width']/$_smarty_tpl->tpl_vars['image']->value['height']), null, 0);?>
									<?php }?>
									
									<div  class=" enlargeFigureButton" data-entity="Image" data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-filesystem="<?php echo $_smarty_tpl->tpl_vars['image']->value['filesystem'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['image']->value['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['image']->value['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['image']->value['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['image']->value['fov'];?>
">	
										<div style="position:absolute;left: <?php echo ($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['w']->value)/2;?>
;top: <?php echo ($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['h']->value)/2;?>
;z-index:10;"><img src="<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['plan_url300'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['w']->value;?>
" height="<?php echo $_smarty_tpl->tpl_vars['h']->value;?>
" />
									</div>
									
									<?php $_smarty_tpl->tpl_vars['plots'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['planPlots'], null, 0);?>
									<?php if ($_smarty_tpl->tpl_vars['plots']->value){?>
									<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['name'] = 'pp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['plots']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total']);
?>
										<div style="position:absolute;left: <?php echo $_smarty_tpl->tpl_vars['plots']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['pos_x']*$_smarty_tpl->tpl_vars['size']->value+($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['w']->value)/2-15;?>
;top: <?php echo $_smarty_tpl->tpl_vars['plots']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['pos_y']*$_smarty_tpl->tpl_vars['size']->value+($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['h']->value)/2-15;?>
;z-index:15;">
											<img class="drag-icon icon32" 			src="/archmap_2/media/ui/FeatureIcon.png" 		width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
										</div>
									<?php endfor; endif; ?>
									<?php }?>
										
								</div>	
								
								<?php }?>				
							
								
						
						
						
						
						</td>
				
					
	
						
						
					</tr>
					</table>
					
					</div>
					<?php endfor; endif; ?>
						
						
						
					



	<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
		
	

	<?php }} ?>