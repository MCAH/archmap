		var selectedBuilding;
		
		function initializeMap() {
			logit("BUILDINGS?");
			
			if (! $("#map-canvas")[0])
				return;
			
			
			
			if(! selectedBuilding && bldgs)
			{
				$.each(bldgs, function(index, val) {
					if (bldgs[index].id == $_GET('building_id'))
					{
						logit('selected:::::::::::::::::::::::::::::::::::::::::::::' + bldgs[index].id);
						selectedBuilding = bldgs[index];
					}
					
				});
				
			}
			
			
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
	
		
	
			
			styles152 = [
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
				
	
		//	logit(" SELECTED BUILDING :: =====> " + selectedBuilding);
			
			
			
			var lat, lng;
			var bounds;
			if(selectedBuilding)
			{
				lat = selectedBuilding.lat;
				lng = selectedBuilding.lng;
			}
			else if (bldgs[1]){
				bounds = findBoundsForItems(bldgs);
			}
			else if (bldgs[0])
			{
				logit("HEEEEEEEEEERE "+bldgs[0].lat);
				lat = bldgs[0].lat;
				lng = bldgs[0].lng; 
			} else {
				lat = 43;
				lng = 12;
			}
			
			var mapOptions = {
				center: new google.maps.LatLng(lat-.0018, lng-.011),
				mapTypeId: google.maps.MapTypeId.SATELLITE,
				styles: styles
			};
			
			
			logit("create map " + $("#map-canvas").length);
			
			// * CREATE MAP *
			map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
			
			
			if (bounds)
			{
				map.fitBounds(bounds);
				//map.setZoom(map.getZoom()-2);
				
				
								
			var listener = google.maps.event.addListener(map, "idle", function () {
				var cen = map.getCenter();
				logit("MAP_CENTER " + cen);
				map.setCenter(new google.maps.LatLng(cen.lat()-0.3, cen.lng()-2.0));
				map.setZoom(map.getZoom()-1);
				google.maps.event.removeListener(listener);
				});

			} else 
				map.setZoom(16);
			
			// for getting drop coordinates
			var overlay = new google.maps.OverlayView();
			overlay.draw = function() {};
			overlay.setMap(map);			
			
			
			google.maps.event.addListener(map, 'zoom_changed', function() {
				logit ("zoom changed: " + map.getZoom());
				if (map.getZoom() > 10)
					map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
				else 
					map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
			});
			
			google.maps.event.addListener(map, 'mouseover', function() {
			 	$("body").css("overflow","hidden");
			});
			google.maps.event.addListener(map, 'mouseout', function() {
				 $("body").css("overflow","auto");
			});
			
			
			
			
			

			
			// increase bounds to set off center
			// get width
			
			/*
			latHeight 	= Math.abs({$site.lat} - {$site.lat2});
			
			var lat1 = {$site.lat} -  1.8*latHeight;
			
			var lat2 = {$site.lat2 + 5.5*latHeight};
	
			lngWidth 	= Math.abs({$site.lng2} - {$site.lng});
	
			var lng1 = {$site.lng} - 4.6*lngWidth;
			
			
			var lng2 = {$site.lng2} - lngWidth;
			
			var bounds = new google.maps.LatLngBounds(new google.maps.LatLng(lat1, lng1), new google.maps.LatLng(lat2, lng2));
			map.fitBounds(bounds);
			
			*/
			
			
			
						
			var len = bldgs.length;
			for (var i = 0; i<len; i++) {
				
			  createMarkerForBuilding(i, bldgs[i], "Building");
			 
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
				animation: google.maps.Animation.DROP
			});
			return marker;
	  	}
		var createMarkerForBuilding = function (num, bldg, ent) {
		  
		  var entity = bldg.entity;
		  if (entity == null || entity == "")
		  	entity = ent;
		  
		 // logit("++++"+entity);
		  
		  
		  var marker, info;
		 // logit(bldg.name + " " + bldg.lat+ " " + bldg.lng);
		  //logit("num="+num + " : {$selected}");
		  var zInd = 1;
		  
		  
		  if (num == 1) {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png";
		  	zInd = 100;
		  } else {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
		  }
		  marker = createMarkerAt(bldg.lat, bldg.lng, icon_url, zInd);
		  
		  //logit("creating marker for: "+ entity+"_"+bldg.id);
		  markers[entity+"_"+bldg.id] = marker;
		  
		  info = new google.maps.InfoWindow({
		    content: '<img style="z-index:30000;" src="'+bldg.poster_url+'" width="100" height="100"/>'
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
				window.location = "/archmap_2/Site/Collection?resource="+site.id+"&building_id=" + id;
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
		
		function findBoundsForItems(items)
		{
			var bounds = new google.maps.LatLngBounds();
			
			$.each(items, function(k,v){
				if(v.lat)
					bounds.extend(new google.maps.LatLng(v.lat, v.lng))					
			});
			return bounds;
			
		}
		
		
		//google.maps.event.addDomListener(window, 'load', initializeMap);
