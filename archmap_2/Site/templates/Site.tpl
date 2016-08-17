{include file="header.tpl"}

{if $site.id eq 151}
	{assign var=unityfile value="Istanbul"}
{/if}
{if $site.id eq 154}
	{assign var=unityfile value="Jerusalem"}
{/if}
{if $site.id eq 242}
	{assign var=unityfile value="Famagusta"}
{/if}
{if $site.id eq 241}
	{assign var=unityfile value="Villa"}
{/if}
{if $site.id eq 233}
	{assign var=unityfile value="Mesopotamia"}
{/if}
{if $site.id eq 152}
	{assign var=unityfile value="Amiens"}
{/if}
 

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
				u.initPlugin(jQuery("#unityPlayer")[0], "/archmap_2/unity/{$unityfile}.unity3d");
			});
		-->
		</script>	











<script>
	var viewer;
	
		site_id = {$site.id};


		var overlayImages;
		
		{if $overlays_json}
		  
			overlaysImages = {$overlays_json};
			
		{else} 
			overlayImages = "";
		{/if}



		var bldgs;
		
		logit("buildings data inline");
		{if $buildings_json}  
			bldgs = {$buildings_json};
		{else} 
			bldgs = "";
		{/if}
		
		{if $features_json}  
			features = {$features_json};
		{else} 
			features = "";
		{/if}
		
	
			

	$( window ).resize(function() {
	
		$('#popup-list').dialog({
			width:300,
			height: $(window).height()-200
		});
		
  	});
	
	$( document ).ready(function() {
	
		
		if (    ( "{$urlalias}" == "seals")      && ! thisUser.isLoggedIn)
		{
			window.location = "http://archmap.org?note={$urlalias}";
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
		if((site_id && site_id == 1) || {if $page eq "landing"}true{else}false{/if}) {
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
         
         
      
		 {literal}
         $('#popup-list').dialog({
			autoOpen: true,
			position: [50,150],
			title: "Monuments and Features",
			width: 300,
			height: $(window).height()-200,
			open: function( event, ui ) {$(":focus").blur();}
        });   
		 {/literal}
		 
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
		
		
		 {if $page != "landing"}
			{section name=bb loop=$mapimage.buildings}
				{assign var=mb value=$mapimage.buildings[bb]}
				
				addFeatureToSeadragon(siteImageViewer, new Seadragon.Point({$mb.pos_x}, {$mb.pos_y}), "Building", {$mb.id}, "{$mb.name}");
				
			{/section}	
			
			{section name=ff loop=$mapimage.features}
				{assign var=mf value=$mapimage.features[ff]}
			
				addFeatureToSeadragon(siteImageViewer, new Seadragon.Point({$mf.pos_x}, {$mf.pos_y}), "Feature", {$mf.id}, "{$mf.name}");
				
			{/section}	
		{/if}
			
        
			
		}, 2000);
		 	
		setTimeout(function(){
			if (siteImageViewer)
			{
				var h_speed = 0;
				var h_topspeed = .00005;
				
				interval_id = setInterval(function() {
					
					{if $page eq "landing"}
						siteImageViewer.viewport.panBy(new Seadragon.Point(-h_speed, 0));
					{/if}

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
		{if $buildings_json}  
			bldgs = {$buildings_json};
		{else} 
			bldgs = "";
		{/if}
		
		{if $features_json}  
			features = {$features_json};
		{else} 
			features = "";
		{/if}
		
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
	
			{if $site.id eq 152 || $site.id eq 154}
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
			{/if}
			
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
			
			{if $site.lat}
				var bounds = new google.maps.LatLngBounds(new google.maps.LatLng({$site.lat}, {$site.lng}), new google.maps.LatLng({$site.lat2}, {$site.lng2}));
				map.fitBounds(bounds);
			{/if}
			
			
			
			
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
		  //logit("num="+num + " : {$selected}");
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
		  
		  if (num == {$selected}) {
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
				window.location = "/archmap_2/Site/Collection?resource={$site.id}&building_id=" + id;
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

			var textField = $('<input data action="add-item" data-collection_id="{$site.id}" style="width:100%;" />');
			newMonForm.append(textField);
			
			{literal}
			textField.liveSearch({url: '/api?request=search&notInCollection='+$('.search-field').attr('data-collection')+'&entity='+entity+'&searchString='}, clickedOnSearchResultItem);
			{/literal}
			
			$("#popup-"+entity+"-list").prepend(newMonForm);
			
									
			textField.bind('keypress', function (e) {
			
			    if(e.keyCode == 13) // ACTUALLY ADD A __NEW__ ITEM (NOT FROM THE DROPDOWN SEARCH RESULTS)
			    {
			       $("#jquery-live-search").empty();
			       
			       // add the building
			       
			        data = {};
			        data['from_entity'] = "Essay";
			        data['from_id'] 	= {$site.id};
			        data["name"]		= $(this).val();
			        
			        addRecord(entity, data, function(data) {
			        	
			        	newMonForm.remove();
			        	
			        	
			        	var listItem = $('<div style="width: 200;margin-bottom:10;" data-itemkey="'+entity+'_'+data['id']+'"></div>');
										
						listItem.append('<div class="thumb-city"><a href="/archmap_2/Site/Collection?site={$site.id}&building_id='+data['id']+'"><b>'+data.name+'</b></a></div>');
						
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
			removeItemFromList("Essay", {$site.id}, entity, id, function(data) {
				
				$('[data-itemkey='+entity+'_'+id+']').hide(100, function() { $(this).remove(); });
			});
		}
		
		
			
		

	
	</script>






		<!-- MAP or MAINIMAGE -->
		{if $mainimage }
			<div id="full-page-image" class="image-droppable" 	style="margin:0; margin-top:80; padding:0;" data-fieldname="landingimage_id"	data-entity="Image" 	data-id="{$mainimage.id}" 	data-image_type="{$mainimage.image_type}" 		data-filesystem="{$mainimage.filesystem}" data-filename="{$mainimage.filename}" data-filepath="{$mainimage.filepath}"  data-image_id="{$mainimage.id}" data-has_sd_tiles="{$mainimage.has_sd_tiles}"  	data-pan="{$mainimage.pan}"  data-tilt="{$mainimage.tilt}"  data-fov="{$mainimage.fov}">
				<div class="poster-view fieldname-poster_id">
					<div id="seadragon-sizing-frame" style="width: 100%; height: 600;">
						<div id="image-viewer-{$mainimage.id}" class="imageArea imageViewer">
							
						</div>
						
					</div>
					<div class="picture-frame-shadow" style="width:100%;"></div>
				</div>	
			</div>	
		
		{else}

			{if $page eq "map"}
				<div id="map-canvas" style="width:100%;height: 600px"></div>
				
				
				<script>
				{literal}
				var map1 = L.map('map-canvas1').setView([51.505, -0.09], 13);
				// add an OpenStreetMap tile layer
				L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
				}).addTo(map1);
{/literal}
				</script>
				
				
			{/if}
			
		{/if}

		
		
		
		
		
		
		
		<!-- POPUPS -->
		
		{if $page eq "landing"}
		<!-- Raise the intor text/card -->
			<div id="intro-card" class="map-dialog" >
				
	
				
			
				<div class="monograph_text">


						<div class="mono-info">
							
							<h1>
							<span  data-entity="Essay" data-id="{$site.id}" data-field="name" class="editable" contenteditable="false" style="font-size: 32;opacity:.8">{$site.name}</span>
							</h1>
							
							<hr>
							
							{assign var=latc value=($site.lat + ($site.lat2-$site.lat)/2)}
							{assign var=lngc value=($site.lng + ($site.lng2-$site.lng)/2)}
							{if ($site.lat2-$site.lat) > 4}
								{assign var=zoomc value=4}
							{else}
								{assign var=zoomc value=6}
							{/if}
							{assign var=lngc value=($site.lng + ($site.lng2-$site.lng)/2)}
							
							<div style="float:right">
								{if  $mapimage.url300}
								<div>
									<a href="/{$site.urlalias}/map"><img class="map-icon" src={$mapimage.url300} width="300" height="300"/></a>
								</div>
								
								{else}
								
								{if $site.id != 1}
								<div style="padding:12;margin:15;background-color:rgba(255,255,255,.5);">
								<a href="/{$site.urlalias}/map">
								<img src="http://maps.googleapis.com/maps/api/staticmap?center={$latc},{$lngc}&zoom={$zoomc}&size=180x180&maptype=terrain
										&markers=color:red%7Clabel:S%7C{$latc},{$lngc}&sensor=false&key=AIzaSyDzJ5COaHF8BYgs-CNi-Jr1r49nysl385I" />
								</a>
								</div>
								{/if}
								{/if}
								
								
											
						
							

							</div>
							

							<div id="thedescript" data-entity="Essay" data-id="{$site.id}" data-field="descript" class="editable" contenteditable="false">
								{$site.descript}
								
								
							</div> 
						
							{if $site.id eq 151 || $site.id eq 154 || $site.id eq 242 || $site.id eq 233 || $site.id eq 152}
								{literal}
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
								{/literal}
							{/if}
														
							{if $sites}	
								<div class="billboards">						
									{section name=i loop=$sites}
									<div class="site-billboard" >
										<span class="project-link">
										<a href="/{$sites[i].urlalias}">{$sites[i].name}</a> 
										</span>
									</div>
									{/section}
								</div>
								
							
							{/if}
									
						</div>
				</div>
			


	
						<!-- pinterest cards -->
						
						{section name=ii loop=buildings}
							hi
							{assign var=bldg value=$buildings[ii]}
							<div class="monograph-thumb grid"> 
								{$bldg.name}
								{assign var=hgt value=(250*{$bldg.poster.height}/{$bldg.poster.width})}
								{assign var=hgt value=250}
								
								<div class="picture link " data-building_id="{$bldg.id}" data-image_type="{$bldg.poster.image_type}"  data-filename="{$bldg.poster.filename}" data-id="{$bldg.poster.id}">
										<div class="poster-view fieldname-poster_id ">
											<div class="picture-frame" >
													<div class="imageAreaGrid">				
															<img src="{$bldg.poster_url300}" width="250" height="{$hgt}"  />
															
															<!--	
															<img src="{$buildings[ii].latsec_url}" width="{$bldg.plan.width/10}" height="{$bldg.plan.height/10}" />
															-->
													</div>
												
												
													<div class="picture-title">{$bldg.name}</div>
													
											</div>
											<div class="picture-frame-shadow" style="width:240px;"></div>
										</div>	
								</div>	
								
							</div>
							
						{/section}	


			
								
				<!-- ALL IMAGES -->
				
				<div id="imageTray" style="margin-top:15;">
				
			
					<div class="imageuploderWidget edit-mode-only"  data-from_entity="Essay" data-from_id="{$site.id}"  >
						<span class="uploadImagesButton" >[+ Upload Images ]</span>
					</div>
			
					<div id="allEssayImages"  data-entity="Essay" data-id="{$site.id}">
			  
					</div>
			
				
				
				</div>	
				
				<script>
					var allImages = $("#allEssayImages");
					
					openImageGalleryOnPage(allImages);
				</script>

				<!--
				<div class="imageuploderWidget edit-mode-only"  data-from_entity="Essay" data-from_id="{$site.id}"  >
					<span class="uploadImagesButton" >[+ Upload Images ]</span>
				</div>
				-->
		
			
			
			</div>
		
		{/if}
		
		
		
		{if $page eq "map"}
		<!-- raise the building list for this site -->
				
			<div id="popup-list" style="width:560;height:560;overflow-y:scroll;">	
				<h3>Monuments</h3>
				<div class="edit-mode-only" style="margin-bottom:10;">
					<div>
						<button id="addBuildingButton" onclick="addItem('Building');">Add a Building</button>
					</div>
				</div>

				
				<div id="popup-Building-list">
							
						{section name=ii loop=$buildings}
							{assign var=city value=", "|explode:$buildings[ii].name}
							{assign var=bldg value=$buildings[ii]}
								
								<div style="width: 260;font-size:10;margin-bottom:10;clear:right;" data-itemkey="Building_{$bldg.id}">
										<div>
										
												
											<!--
											<img class="drag-icon thumb-icon"  src="{$buildings[ii].poster_url300|replace:'300':'50'}" width="32" height="32"  data-entity="Building" data-id="{$bldg.id}" data-name="{$bldg.name}"  />
											-->
											
											<table width="100%">
												<tr>
													<td valign="top">
														<a href="/archmap_2/Site/Collection?site={$site.id}&building_id={$bldg.id}">
															- <b style="font-size:10;">{$bldg.name}, {$city[1]}</b>
														</a>
													</td>
													<td valign="top" width="25">
														<img class="drag-icon" style="float: right;" 	src="/archmap_2/media/ui/CircleIcon.png" 		width="16" height="16"  data-entity="Building" data-id="{$bldg.id}" data-name="{$bldg.name}" />
													</td>
												</tr>
											</table>
										
											<!--
											<img src="{$buildings[ii].plan_url}" width="{$bldg.plan.width/10}" height="{$bldg.plan.height/10}" />
											-->
										</div>
										
										<div class="edit-mode-only">
											<button onclick="removeItem('Building', {$buildings[ii].id});"><b>-</b></button>
										</div>
									
										
								</div>
						{/section}	
						
				</div>
				
				
				
				<h3 style="margin-top:30;">Features</h3>
				
				
				<div class="edit-mode-only" style="margin-bottom:10;">
					<button onclick="addItem('Feature');">Add a Feature</button>
				</div>

				<div id="popup-Feature-list">
							
						{section name=fi loop=$features}
							
							{assign var=feature value=$features[fi]}
								
								<div style="width: 260;margin-bottom:10;" data-itemkey="Feature_{$feature.id}">
										
										<div class="thumb-city">
											<a href="/archmap_2/Site/Collection?site={$site.id}&entity=Feature&id={$feature.id}"><b>{$feature.name}</b></a></div>
							
										<div style="clear:right;">	
											<img class="drag-icon thumb-icon"  src="{$feature.poster_url300|replace:'300':'50'}" width="32" height="32"  data-entity="Feature" data-id="{$feature.id}" data-name="{$feature.name}"  />
											<span style="opacity: .6;">{$feature.refnum|replace:'serdar_seals_':'no. ' }</span>
											<img class="drag-icon " style="float:right"	src="/archmap_2/media/ui/CircleIcon.png" 		width="16" height="16"  data-entity="Feature" data-id="{$feature.id}" data-name="{$feature.name}" />
										</div>
										<div class="edit-mode-only">
											<button onclick="removeItem('Feature', {$feature.id});"><b>-</b></button>
										</div>
									
										
								</div>
						{/section}	
						
				</div>
				
			</div>		

			{/if}


			<div class="map-edit-panel edit-mode-only">
				<h3>Map Editing</h3>
				<div>
					<button onclick="setCollectionMapZoomAndPan({$site.id})">Set Map</button>
				</div>
			</div>


{include file="footer.tpl"}
	