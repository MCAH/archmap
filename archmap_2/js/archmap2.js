// ARCHMAP2.js
	var maps = {};

	var currentPage;
	
	var cur_z = 1000;
	var lastPopUp;
	
	
	
	var controller;
	
	var latestPosition;
	
	
	
	
	// ! ************** Initialization	

  
  	$(document).ready(function(){
		/*
		$( "#Essay" ).sortable({ handle: ".handle" })
				.selectable()
			.find( "li" )
				.prepend( '<div class="handle"><span class="ui-icon ui-icon-carat-2-n-s"></span></div>' );
		
		
		*/
		dataStore = new DataStore();
		var attrs = $.jsper.get('thisUser').attrs;
		thisUser = new Model(attrs);
		dataStore.addModel(thisUser);
		
		tickle();
		
		
				
		controller = new Controller();
		
		
		
		windowResize();
		$(window).resize(function() {
				windowResize();
		});
		
		$( "#Essay, #other-biblio" ).sortable();
		
		$(".ul-button").live("click", menuButtonClicked);
		
		$(".ul-button2").live("click", menuButtonClicked);
		
		$('li.profileLink').live('click', select_item);
		
		
		// get MyEssays from the server
		
		thisUser.callIfIsLoggedIn(initEssays);
		
		//var v = new PlaceEntryView();
		
		
		
	});
	function essays_jsonCallback(server_data) {
	}
	function initEssays() {
			$.getJSON('/archmap2/api', {'request':'getAuthorsRootItems', 'session_id':thisUser.attrs.session_id}, function(server_data) {
				$.each(server_data, function () {
					var model = new Model(this);
					
					
					dataStore.addModel(model);
					$("ul.entity-Essay").append(constructLi(entityName[this.entity_id], model));
				});
			});
	
	}
	
	function GetUnity() {
		if (typeof unityObject != "undefined") {
			return unityObject.getObjectById("unityPlayer");
		}
		return null;
	}

	function unityCall(data) {
		
		var items = data.split('/');
		var filename = items[items.length-1];
		//alert(filename);
		var parts = filename.split('_');
		//alert(parseInt(parts[0]));
		getPageById("Image", parseInt(parts[0]));
	}
	
	
	
	// ! CONTROLLER
	function Controller() {
		
		//this.models 	= new Array();
		///this.views 		= new Array();
		this.markers 	= new Array();
		
	}

	Controller.prototype = {
		addMarker: function(marker) {
			this.markers[marker.model.attrs.id] = marker
		},
		
		highlight: function(model) {
			$('.model-identity.entity-'+model.entity+'.model_id-'+model.attrs.id).addClass('highlight');
			
			if (this.markers[model.attrs.id]) {
				this.markers[model.attrs.id].setIcon(mapIconLarge);
			}
		},
	
		unhighlight: function(model) {
			$('.model-identity.entity-'+model.entity+'.model_id-'+model.attrs.id).removeClass('highlight');
			
			if (this.markers[model.attrs.id]) {
				this.markers[model.attrs.id].setIcon(mapIconSmall);
			}
		}
	
	}





	
	
	
	
	
	
	
	
	
	// ! **************** OPENING PROFILES


	function getPage(model) {
		var entity = model.entity;
		var id = model.attrs.id;
	
		// CUSTOM SKINS PER ESSAY
		// later: replace this with a system to let the essay creator specify header graphics, etc. 
		if (model.entity == 'Essay' && model.attrs.id == 141) {
			$('#header').css('background-image', 'url("/archmap_2/media/ui/BourbonnaisHeader150.jpg")');
			$('#header').css('background-color', '#c4c698a');
			$('#header').css('height', '150');
						
			$('.header-sitetitle').html('Archmap: Romanesque Churches of the Bourbonnais - A Database');
		
		} else if (model.entity == 'Essay' && model.attrs.id == 152) {
			$('#header').css('background-image', 'url("/archmap_2/media/ui/MGFHeaderSm.jpg")');
			$('#header').css('color', 'gray');
			$('#header').css('height', '80');
			$('.header-sitetitle').html('Archmap: Mapping Gothic France');
		
		} else if (model.entity == 'Essay' && model.attrs.id == 151) {
			$('#header').css('background-image', 'url("/archmap_2/media/ui/IstanbulPanoSm.jpg")');
			$('#header').css('height', '150');
			$('.header-sitetitle').html('Archmap: The Istanbul Project');
		
		} else if (model.entity == 'Essay')  {
			$('#header').css('background-image', 'none');
			$('.header-sitetitle').html('Archmap');
		
		}
		
		
		
		
		// get template which is partially filled out by php
		logit('[getPage] entity='+entity+', id='+id);
		
		var profile = $('.profile.entity-'+entity+'.model_id-'+id);

		if (profile.length > 0) {
			// this profile is already open.
			profile.dialog("moveToTop");
		} else {
			logit('/archmap2/'+entity+'/'+entity+'Profile');
			$.post('/archmap2/'+entity+'/'+entity+'Profile', {componentOnly:"true", id:id}, getPageCallback);
		}
		
	
	}
	function getPageById(entity, id) {
	
		dataStore.getModel(entity, id, getPage);
	
	}












	
	function getPageCallback(data) {

		/* CONTRACT
		
			The model for this is already cached by the time this callback is called.
			
			The "data" is the html returned from the server and it must exist.		
		
			Now - lests establish a Model and a View
		*/
		
		if (!data || data == "") return;
		
		var profile = $(data);  // Turn the html template into a jQuery element
		
		if (profile && profile.hasClass('error')) {
			logit('getPageCallback::error: ' + profile.html());
			return;
		}

		var ident= getIdent($(data));
		
		// GET MODEL
		var model = dataStore.getModel(ident.entity, ident.id);
		
		if (! model) return;

		/*
			we now have a Model and a view (profile)
		
		*/
		
		
		
		profile.find('.related-item-section').droppable({
			hoverClass: 'highlightOnWhite', 	
			greedy: true,
			accept: '.model-dragger',
			over: function(event, ui) {
				var from_ident = getIdent($(event.target));
				var to_ident = getIdent($(ui.draggable));
				logit("-> " + to_ident.entity + '::'+ to_ident.id);
				logit("--> is over me! "+ $(event.target).attr('class'));
				
			},
			out: function(event, ui) {
				logit("someone is left me! "+ $(event.target).attr('class'));
				
			},
			drop: function(event, ui) {
				var from_ident = getIdent($(event.target));
				var to_ident = getIdent($(ui.draggable));
				
				logit('/archmap2/api?request=addItemToList&session_id='+thisUser.attrs.session_id+'&from_entity='+from_ident.entity+'&from_id='+from_ident.id+'&to_entity='+to_ident.entity+'&to_id='+to_ident.id+'&relationship='+from_ident.relationship);
				
				$.getJSON('/archmap2/api/', 
					{request:'addItemToList',  'session_id':thisUser.attrs.session_id, from_entity:from_ident.entity, from_id:from_ident.id, to_entity:to_ident.entity, to_id:to_ident.id, relationship:from_ident.relationship}, 
					function() {
						logit('drop worked!');
						// add to uls
						var model = dataStore.getModel(to_ident.entity, to_ident.id);
						var li = constructLi(to_ident.entity, model, from_ident.entity,from_ident.id, from_ident.relationship);
						li.css('display','none');
						
						var ul = $(event.target).find('ul.entity-'+to_ident.entity);
						logit(ul.attr('class'));
						ul.append(li);
						li.show('fade');
						ul.scrollTop(1000);

						updateLabelCount(ul);
						
						// update map
						// on profile for collection
					});
			}
		});
		
		
		
		
		// LAUNCH PAGE IN DIALOG
		var title = ident.entity + ": " + model.attrs.name;
		if (model.attrs.volume) title = title + ' , Vol. ' + model.attrs.volume;
		var map_center;

			
		var max_size = 600;
		var dialogWidth = 800;
		var dialogHeight = 600;
		var dialogPosition = "center";
		var scale = model.attrs['height'] /  model.attrs['width'];
		if (ident.entity == "Image") {
			// check image size and open window to same proportion
			if (model.attrs['width'] > model.attrs['height']) {
				dialogWidth = max_size;

				dialogHeight = max_size * scale;
			} else {
				dialogWidth = max_size / scale;
			}
			dialogPosition = "right";
		}
		// ! ------------------ POPUP PROFILE
		dialogHeight += 120;
		profile.dialog({
			title: title,
			width: dialogWidth,
			height: dialogHeight,
			position: dialogPosition,
			resizable: true,
			resizeStart: function () {
				var map = maps[ident.entity+"_map_"+ident.id];
				if (map) {
					map_center = map.getCenter(map);
				}
							
			},
			resize: function(event, ui) {
				
				var map = maps[ident.entity+"_map_"+ident.id];
				if (map) {
					google.maps.event.trigger(map, "resize");
					map.setCenter(map_center);
				}
				map = maps[ident.entity+"_mapdetail_"+ident.id];
				if (map) {
					google.maps.event.trigger(map, "resize");
					map.setCenter(map_center);
				}
			 },
			close: function() { profile.remove();}
		});




		// ! ===============  UNITY
		if  (ident.entity == "Building") {
			if (typeof unityObject != "undefined") {
				logit("OK - load unity");
				unityObject.embedUnity("unityPlayer_"+model.attrs.id, "/archmap/media/unity/PlanSecViewer/PlanSecViewer.unity3d", 300, 200, null,null, function() {
					
						var unity = unityObject.getObjectById("unityPlayer_"+model.attrs.id);
						logit("unity loaded : SENDING MESSAGE: " + parseInt(model.attrs.id));
						unity.SendMessage("MainScriptObject", "selectChurchById", parseInt(model.attrs.id));
					});
				$("#noyon").click(function() {
						logit("go to noyon");
						
						$("#unityPlayer_"+model.attrs.id).dialog();
						
						
						
				});
				
			}
		}


		// ! -------------- ** PROFILE MAPS
		
		var currentCenter;
		var largeZoom;
		var map;
		
		
		
		if (ident.entity == "Essay" || ident.entity == "Publication") {
		
			// JUST THE COLLECTION MAP
			currentCenter = new google.maps.LatLng(38.0, 25.0);
			largeZoom = 4;
			map = initializeDetailMapWithElementID(ident.entity+'_map_'+model.attrs.id, currentCenter, largeZoom);
			maps[ident.entity+"_map_"+ident.id] = map;
		
		
			
			
			
		} else if (ident.entity == "Building" || ident.entity == "HistoricalEvent") {
			
			// TWO MAPS - REGION AND DETAIL -
			currentCenter = new google.maps.LatLng(38.0, 25.0);
			largeZoom = 3;
	
			if (model.lat) {
				currentCenter = new google.maps.LatLng(model.attrs.lat, model.attrs.lng);
				largeZoom = 4;
			} else {
				if(model) {
					if (model.attrs.lat) {
						currentCenter = new google.maps.LatLng(model.attrs.lat, model.attrs.lng);
						largeZoom = 4;
					} else if (latestPosition) {
						currentCenter = new google.maps.LatLng(latestPosition.lat()+.1, latestPosition.lng()+.1);
					}			
				}
			}
			
			
			
			var moveMarkerButton = profile.find('.map-movemarker');
			
			//var view = new View(model);
			largeMap = initializeDetailMapWithElementID(model.entity+"_map_region_"+model.attrs.id, currentCenter, largeZoom);
			maps[ident.entity+"_map_"+ident.id] = largeMap;

			detailMap = initializeDetailMapWithElementID(model.entity+"_map_detail_"+model.attrs.id, currentCenter, 17);
			maps[ident.entity+"_mapdetail_"+ident.id] = detailMap;


			dropMarker(largeMap, detailMap, model);

			var mapSearchField = profile.find('.map-search-field');
				mapSearchField.keypress(function(event) {
					if (event.which == '13') {
						$(this).blur();
					} 			
				})
				.blur(function(event) { 
					 geocoder = new google.maps.Geocoder();
					 geocoder.geocode( { 'address': $(this).val() }, function(results, status) {
				      if (status == google.maps.GeocoderStatus.OK) {
				       
				        var marker = new google.maps.Marker({
				            map: largeMap, 
				            position: results[0].geometry.location
				        });
				        
						google.maps.event.addListener(marker, 'click', function() {  
							detailMap.setCenter(marker.getPosition());  
							moveMarkerButton.show('fade')	 
								.click( function() {
									model.largeMapMarker.setPosition(marker.getPosition());
									model.detailMapMarker.setPosition(marker.getPosition());
									model.setPosition(marker.getPosition());
									detailMap.setCenter(marker.getPosition());
									
								});
							
							
							});
				        
				        
				      } else {
				        alert("Geocode was not successful for the following reason: " + status);
				      }
				    });			 
					 
				});
				
			//model.largeMapMarker

			
		}
		if (ident.entity == "Image") {
		
			var imageViewEl = $('#image-view-'+model.attrs.id);

			if (model.attrs.has_sd_tiles) {
				showSeadragonImage(model);
			} else {
				
				var imgHtml = $('<img  />');
				var src;
				
				if (model.attrs.filesystem && model.attrs.filesystem == "B") {
					src = '/archmap/media/images/'+model.attrs.filename+'_300.jpg';
				} else {
				
					src = model.src(300);
				}
				imgHtml.attr({ 
				  src: src,
				  title: "jQuery",
				  align: "center",
				  alt: "model.attrs.title"
				});
				imageViewEl.append(imgHtml);
				
				// if image filesystem is "B"
				if (model.attrs.filesystem == "B") {
					imageViewEl.append('<div><img src="/archmap_2/media/ui/loading.gif" /></div>');
					imageViewEl.append('<div style="text-align:center; width: 100%">Generating zoomable images...</div>');
					$.getJSON('/archmap2/api', {'request':'makeSeaDragonImageTiles',  id:model.attrs.id}, 		createSeadragonTilesCallback);
				}
			}
 			
		}
		
		
		
		
		
		// ! ***********************  REQUEST LIST DATA
		/*
		 * * REQUEST DATA TO POPULATE RELATED ITEMS LISTS * *
		For each .related-item-section element found,
		make a request to the server to get the related item objects
		to populate the list.
		
		Perhaps it would be better to only call for summary counts at this point in the page open
		and let the user expand related list headers later?
		
		*/
		var relatedItemLists = profile.find('.related-item-section');
		$.each(relatedItemLists, function() {
			var to_entity = getClassItemWithPrefix($(this), 'entity-');
			var to_relationship = getClassItemWithPrefix($(this), 'relationship-');
			
			model.getRelatedItems(to_entity, to_relationship);
			
			
			$.getJSON('/archmap2/api', {
						'request':		'getRelatedItems',  
						from_entity:	ident.entity, 
						from_id:		ident.id, 
						to_entity: 		to_entity, 
						relationship:	to_relationship}, 		
						getRelatedItems_Callback);
						
		});
		
	
		
		
		if (ident.entity == "Image") {
			profile.find('.setBackgroundButton').click(function() {
				$('#main-content').css('background-image', 'url("' + model.src() + '")');

			});
		}


		

		profile.find('.fieldname-name').dblclick(set_to_inlineEditing)
		var descript = profile.find('.fieldname-descript');
			descript.dblclick(set_to_inlineEditing);

		
		
		$('.profile-link').click(select_item);
		
		
		
		
		//profile.find('.entitylabel').parent().parent().next().hide();
		profile.find('.entitylabel').click(function(event) {
			$(this).parent().parent().next().toggle('slow');
			return false;
		});
		
		
		//profile.find('.related-items-listview').resizable();
	}
	
	function createSeadragonTilesCallback(data) {
		//alert('callback');
		var model = dataStore.getModel("Image", data['id']);
		if (model) {
			showSeadragonImage(model);
		}
	}
	function showSeadragonImage(image) {
		
		
		var imageViewEl = $('#image-view-'+image.attrs.id);
	 	
	 	// this is the basis for a View class - it has a model and an element
	 	imageViewEl.empty();
		imageViewEl.append('<div id="seadragon-viewer-'+image.attrs.id+'"></div>');

    	Seadragon.Config.maxZoomPixelRatio = 1;
    	Seadragon.Config.imagePath = '/archmap_2/jQuery/seadragon-ui-img/'; // = 'http://seadragon.com/ajax/0.8/img/';
    	Seadragon.Config.immediateRender = true;
    	Seadragon.Config.zoomPerScroll = 1.08;
    	Seadragon.Config.visibilityRatio = 1.0;
    	
    	var url;
    	
    	if (image.attrs.filesystem == "B") {
    		url = '/archmap/media/images/'+image.attrs.filename +'_tiles/'+ image.attrs.id + '.xml';
    	} else {
    		url = '/archmap/media/buildings_sd_tiles/1000/'+ (image.attrs.filename).substring(0,10) + '.xml'
    	}
    	
    	var viewer = new Seadragon.Viewer("seadragon-viewer-"+image.attrs.id);	
        	viewer.openDzi(url);          
          	viewer.addEventListener("resize", function() {
        		//var newSize = Seadragon.Utils.getElementSize("seadragon-viewer-"+model.attrs.id); // is (350, 250)
				//viewer.viewport.resize(newSize, false);
				viewer.viewport.goHome();
    		});
	
	}
	
	
	
	
	
	
	// ! FORMS
	
	function getForm(entity, id) {
		
		// get template which is partially filled out by php
		
		var form = $('.model_form.entity-'+entity+'.model_id-'+id);

		if (form.length > 0) {
			// this profile is already open.
			form.css('z-index', cur_z++);
		} else {
			$.post('/archmap2/'+entity+'/'+entity+'Form', {componentOnly:"true", id:id}, getFormCallback);
		}
		
	
	}
	function getFormCallback(data) {
	
		//alert("got the form");
		
		var form = $(data);
		$('#main-content').append(form);
		
		// z-index
		form.css('z-index', cur_z++);
		
		// interactivity
		form.draggable();
		form.mouseover(function() {$(this).css('z-index', cur_z++);});

		//initPublicationForm(form);
		//setPubtype(form, "Book");
	}
	
	
	
		function getParent_Callback(data) {
			//alert('have parent: '+data['result']+ ', ' + data['entity']+ ', ' + data['id']);
			var form = $('.model-form.model-identity.entity-Publication.model_id-'+data['id']);
			var ul = form.find('ul.relationship-parent');
			var ulEntity = data['entity'];
			var parent;
			var li;
			if (data) {
				if (data['result'] == "failed") {
					// no parent, set up editing form
					//alert('no parent - create a new one : ' + ul.attr('class'));
					ul.append('<li>test</li>');
					parent = new Model();
					parent.attrs.id 		= generateTempId();
					parent.attrs.name 	= "New " + ulEntity;
					parent.setEntity(ulEntity);
					dataStore.addModel(parent);
					
					//if (relparent_ident) {
					//	li = constructLi(ulEntity, model, relparent_ident.entity, relparent_ident.id, ulRelationship);
					//} else {
						li = constructLi(ulEntity, parent);
					//}
					ul.append(li);
					li.find('span.fieldname-name').eq(0).dblclick();
				//} else {
					// parent is in
				//	parent = new Model(data);
				
				}
			
			}
		}
	
	
	
	
	
	// ! ************** PRIMARY NAVIGATION
	function getRelatedItems_Callback(server_data) {
		// this calback needs to know the Essay that it is listing!
		
		
		var from_entity 	= server_data.from_entity;
		var from_id			= server_data.from_id;
		var to_entity		= server_data.to_entity;
		var relationship	= server_data.relationship;
		
		var items 			= server_data.items;
		
		if (! items) return;
		
		//alert(server_data.from_entity + ', ' + server_data.from_id + ', ' + server_data.to_entity);
		
		var profile = $('.profile.entity-'+server_data.from_entity+'.model_id-'+server_data.from_id);		
		
		

		logit('======> [getRelatedItems_Callback] from_entity=' + from_entity + ', from_id='+ from_id +  ', to_entity='+ to_entity +  ', relationship='+ relationship);
		
		
		var panel_ul;

		// UL
		if (relationship) {
			panel_ul = profile.find('ul.entity-' + to_entity + '.relationship-'+relationship);
		} else {
			panel_ul = profile.find('ul.entity-' + to_entity + ':not(".relationship")');
		}
		panel_ul.empty();
		
		
		// LABEL
		var label = panel_ul.parent().prev().find('.entitylabel');
		if (label) {
			if ( items.length > 0) {
				label.html(server_data.to_entity+'s (<span style="color:#ff8675">'+items.length+'</span>)');
			} else {
				label.html(server_data.to_entity+'s');
			}
		}
		
		
		
		
		
		
		
		// POPULATING MAPS WITH RELATED ITEMS
		
		var map = maps[server_data.from_entity+"_map_"+server_data.from_id];	
			
		var min_lat =  1000.0;
		var max_lat = -1000.0;		
		var min_lng =  1000.0;
		var max_lng = -1000.0;
		
		var entity;
		// add an items to the UL
		$.each(items, function () {
			
			entity = entityName[this.entity_id];
			var model = new Model(this);
			dataStore.addModel(model);
			
			// ADD LI TO LIST VIEW
			var li = constructLi(entity, model, from_entity, from_id, relationship);
			panel_ul.append(li);
			
			
			
			if (relationship == "map") {
				// ADD OVERLAY FOR THIS ITEM
				
				var lat 	= (model.attrs.lat ? model.attrs.lat : 31.7705087237513);
				var lng 	= (model.attrs.lng ? model.attrs.lng : 35.2296659946442);
				var lat2 	= (model.attrs.lat2 ? model.attrs.lat2 : 31.7875869361425);
				var lng2 	= (model.attrs.lng2 ? model.attrs.lng2 : 35.2402411529541);
				
				
				var sw = new google.maps.LatLng(lat,  lng);
				var ne = new google.maps.LatLng(lat2, lng2);
				
				var imageBounds = new google.maps.LatLngBounds(sw, ne);	
					
			 	var overlay = new ProjectedOverlay(map,'http://learn.columbia.edu/archmap/media/images/04/90/49034_full.gif', imageBounds, {'percentOpacity': 55}) ;
				//overlay.setBounds(imageBounds2);
				
				var sw_Marker = new google.maps.Marker({
		      		map:map,
		      		draggable:true,
		      		title:model.attrs.name,
		      		icon: mapIconSmall, 
		      		position: sw
				});
				sw_Marker.model = model;
				
				var ne_Marker = new google.maps.Marker({
		      		map:map,
		      		draggable:true,
		      		title:model.attrs.name,
		      		icon: mapIconSmall, 
		      		position: ne
				});
				ne_Marker.model = model;
				
				//controller.addMarker( mapMarker );
				
				google.maps.event.addListener(sw_Marker, 'drag', function() { 
					overlay.setBounds(new google.maps.LatLngBounds( sw_Marker.getPosition(), ne_Marker.getPosition() ));
					overlay.draw(true);
				});
				google.maps.event.addListener(ne_Marker, 'drag', function() { 
					overlay.setBounds(new google.maps.LatLngBounds( sw_Marker.getPosition(), ne_Marker.getPosition() ));
					overlay.draw(true);
				});
				
				
				google.maps.event.addListener(sw_Marker, 'dragend', function() {  
					model.setBounds(new google.maps.LatLngBounds( sw_Marker.getPosition(), ne_Marker.getPosition() )); 
				});
				
				google.maps.event.addListener(ne_Marker, 'dragend', function() {  
					model.setBounds(new google.maps.LatLngBounds( sw_Marker.getPosition(), ne_Marker.getPosition() )); 
				});
				
		

			} else {
			
				// ADD MARKER TO MAP		
				if (map && entity == "Building" && model.attrs.lat && model.attrs.lng) {
				 	
				 	if (model.attrs.lat < min_lat) min_lat = model.attrs.lat;
				 	if (model.attrs.lat > max_lat) max_lat = model.attrs.lat;
				 	
				 	if (Number(model.attrs.lng) < min_lng) min_lng = model.attrs.lng;
				 	if (Number(model.attrs.lng) > max_lng) max_lng = model.attrs.lng;
				 	
				 	// ** DROP MARKER **
				 	dropItemMarker(map, model);
				}
			}
			
		});	
		
		if (map && entity == "Building") {
			logit(" ---- " + min_lat + ', '+min_lng + ' -- ' + max_lat + ', '+new Number(max_lng) + ' ==== ' + (new Number(max_lng)>new Number(min_lng)));
			var sw = new google.maps.LatLng(min_lat, min_lng);
			var ne = new google.maps.LatLng(max_lat, max_lng);
			map.fitBounds(new google.maps.LatLngBounds(sw, ne));
			
			var zoom_val = map.getZoom();
			
			if (zoom_val > 13) {	// set to satellite
				map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
			}
			
			logit(new google.maps.LatLngBounds(sw, ne));
			
	
			
		}
		
		
		
		
		
		
	}











	
	function select_item() {
		/* 
			This has been generalized to any list launching a profile. 
			That profile would have a related-items-panel
			
			The selected item is an element such as the 'name' field
			assume an item is under a parent that has the ident info
		*/
		
		
		//alert(identityElem.attr('class'));
		
		logit('[select-item CALLED]');
		
		if (! $(this).hasClass("selected")) {
			var selectedItems = $('body').find(".selected");
			
			// 1. CLEAR other selections
			//    -- this means only one selection at a time for now.
			selectedItems.each( function () {
				if ($(this).find("input")) {
					$(this).find("input").blur();
				}
			});
			selectedItems.removeClass('selected');
			
	
			// 2. now SELECT this element
			$(this).addClass("selected");
		}
		
		
		// Now pop up a profile for the model this item represents.
		// the div surrounding the field is the item that was clicked.
		// for example, $(this) might represent <div fielldname=name>{model.name}</div>
		
		var identityElem = $(this).parents('.model-identity:eq(0)');;
		
		//var ident = getIdent( identityElem );
		
		logit('[select-item 1]');
		var ident = getIdent( $(this) );
		logit('[select-item 2 ('+ident.entity+', '+ident.id+')]');

		
		
		
		// ITEM IN SECONDARY NAV OR OTHER - select content
		var model = dataStore.getModel([ident.entity], [ident.id]);
		
				if (model) {
			//alert (ident.id + " --- " + model.attrs.id);
			logit('model does exist - call getPage');
			getPage(model);

		} else {
			logit('model does not exist - call getPageById('+ident.entity+', '+ident.id+')');
			getPageById(ident.entity, ident.id);
		}
			
			
		
	}
	
	
	
	
	
	
	
	
	// ! ************** EVENT RESPONSES

	// BUTTON CLICKED
	function menuButtonClicked() {
	
		/*  BUTTON CLICKED
			This is the callback for a button added to the controls for a ul.
			The ul is the dom element preceding the button panel.
		*/

		// the button function is specified in the class of the button. 
		// For example class="ul-button func-addItem" where we extract what is after 'func-'
		
		logit('menuButtonClicked');
		
		var func = getClassItemWithPrefix($(this), 'func-');
		
		var label = $(this).prev();
		
		// The button should be in a parent element that wraps several buttons such as addItem, deleteItem, etc.
		var ul = $(this).parent().prev();		
		
		// the type of items contained in the ul is specified in the class for the ul.
		// For example, class="entity-Building"
		
		var ulEntity 		= getClassItemWithPrefix(ul, 'entity-');
		var ulRelationship 	= getClassItemWithPrefix(ul, 'relationship-');
				
		var liToOperateOn;

		var selected_item = ul.find('.selected');
		if (selected_item.length) {
			liToOperateOn = selected_item.parents('.model-identity:eq(0)');
		} else {
			if (! $(this).parent().hasClass('function-menu')) {
				liToOperateOn = $(this).parent();
			}
		}
		var ident;
		if (liToOperateOn) {
			ident = getIdent(liToOperateOn);
		}
		
		// support various buttons based on their function:
		switch ( func ) {
			
			// ! ** ADD ITEM
			case "addItem":
			
				/*  ADD_ITEM 
					Adds an html element to the ul previous to the add button.
					The entity type of the new element is set to the same entity type of the ul.
				*/

				// CONSTRUCT THE LI to represent the new instance of the entity
				// 	- add the entity specified by the ul
				// 	- constructLi will know to add a temporary model_id

				var model = new Model();
			
				model.attrs.id 		= generateTempId();
				model.attrs.name 	= "New " + ulEntity;
				model.setEntity(ulEntity);
				
				logit('addItem: ' + model.entity);
				
				var relparent = ul.parents('.relparent:eq(0)');
				var relparent_ident;
					
				if (relparent && relparent.attr('class') ) {
						relparent_ident = getIdent(relparent);
						
						if (ulEntity == "NoteCard") {
							// the default for a new NoteCard is that the list parent is the objects parent as well.
							model.attrs.parent_entity = relparent_ident.entity;
							model.attrs.parent_entity_id = entityId[relparent_ident.entity];
							model.attrs.parent_item_id = relparent_ident.id;
						}
						// if this model is saved as a new item, this parent will be its parent in the db. 
						// If this item is replaced with a suggested object, then this parent info will be negated.
				}

				logit('[menuButtonClicked::addItem] 1. ulEntity='+ulEntity);
											
				dataStore.addModel(model);
					logit('[menuButtonClicked::addItem] 2.  ulEntity='+ulEntity);
			
				
				var li;
				if (relparent_ident) {
					li = constructLi(ulEntity, model, relparent_ident.entity, relparent_ident.id, ulRelationship);
				} else {
					li = constructLi(ulEntity, model);
				}
				
				
				if (label) li.prepend(label.clone());
				
				// ADD LI TO THE DOM
				// 	- if an item in the ul is selected, add the new li after the li that contains the selected item.
				
				if (selected_item && selected_item.length) {
					li.insertAfter(selected_item.parent());
					selected_item.removeClass('selected');
				} else {
					ul.append(li);
				}
				
				
				// activate the new lit item for editing				
				li.find('span.fieldname-name').eq(0).dblclick();
				
				ul.scrollTop(1000);

				updateLabelCount(ul);
				
				break;
				
				
			
			// ! ** DELETE ITEM
			case 'deleteItem':
				// pop up a dialog to see if user would like to remove from list or remove record from db
				
				logit('menuButtonClicked: adding class "waiting-for-delete" 1');
				// the button may be at the bottom or in an li with a list item.
				liToOperateOn.addClass('waiting-for-delete');
				logit('menuButtonClicked: adding class "waiting-for-delete" 2 --- ' + liToOperateOn.attr('class'));
				
				
				var buttons;
				if (ident.id.substr(0,3) == 'tmp') {
					buttons = {
						"Remove From List": removeSelectedItem,
					}
				
				} else if (ulEntity == 'Essay') {
					buttons = {
						"Delete From Database": reallyDeleteSelectedItem,
					}
				
				} else if (ulEntity == 'NoteCard') {
					buttons = {
						"Remove From List": removeSelectedItem,
						"Delete From Database": reallyDeleteSelectedItem,
					}
				} else {
					buttons = {
						"Remove From List": removeSelectedItem,
					}
				}
				buttons.cancel = cancel;
				
				var dialogOpts = {
					modal: true,
					width: 500,
					buttons: buttons
				};
				$('<div>Really Delete?</div>').dialog(dialogOpts);
		
				break;
		}	
		
	}
	
	function cancel() {
		$(this).dialog("close");
	}
	


















	
	
	// ! *************************** CONSTRUCT LI
	function constructLi(entity, model, from_entity, from_id, relationship) {
		
		// CONSTRUCT THE LI to represent the new instance of the entity
		// 	- add the entity specified by the ul
		// 	- add a temporary model_id
		var li;
		var div;
		
		var nameField;
		var pages;
		var catnum;
		var beg_year;
		
		var parent;
		
		
		if (from_entity && from_id) {
			parent = dataStore.getModel(from_entity, from_id);
		} 
		
		if (model) {

		
			if (model.entity == "Image") {
				
				// IMAGE HAS A UNIQUE LI
				
				li = $('<div class="model-identity entity-'+entity+' model_id-'+model.attrs.id+' model-dragger" style="float:left;"></div>');
				
				div = model.getSlideView(100);
				li.append(div);
				div.mouseup(select_item);
			
			
			
			
			
			} else {
					
				// LI IS SAME FOR ALL OTHERS
				li = $('<li class="model-identity entity-'+entity+' model_id-'+model.attrs.id+' model-dragger"></li>');
				
				
				if (model.entity == "Publication") {
					
					if (model.attrs.pubtype == 6) {
						li.addClass('book');
					} else if (model.attrs.pubtype == 17) {
						li.addClass('article');
					} else if (model.attrs.pubtype == 5) {
						li.addClass('booksection');
					}
					
					
					
					if (from_entity) {
					
						switch (from_entity) {
							case "NoteCard":
								if (relationship == 'primary') {
									
									li.append('<span>' +model.attrs.contributors + '</span>');
									li.append('<span>(' + model.attrs.date +').</span>');			
									var tmp_pages = (model.attrs.pages) ? model.attrs.pages : '-';
									pages = $('<span class="ghost">, pp. <span class="dynnum">'+ tmp_pages+'</span><span>');
									li.append(pages);
								} else {
									nameField = $('<span>' +model.attrs.contributors + '</span> <span>(' + model.attrs.date +')</span> <span class="inputElement fieldname-name">'+model.attrs.name+'</span>, <span>'+model.attrs.publisher+ ', ' + model.attrs.location +'</span>');
									li.append(nameField);
								}							
								break;
							
							case "Essay":
							case "Building":
							case "Publication":
								nameField = $( '<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
								if (model.attrs.name != "New Publication") {
									li.append('<div>' +model.attrs.contributors + '</div>');
									li.append('<span>(' + model.attrs.date +')</span> ');
									li.append(nameField);	
									if (model.attrs.volume) {
										li.append(', <span>Vol. ' + model.attrs.volume +'</span> ');
									}
									li.append(', <span>'+model.attrs.publisher+ ', ' + model.attrs.location +'</span>');	
								} else {
									li.append(nameField);
								}	
								break;
								
							case "Person":
								nameField = $( '<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
								if (model.attrs.name != "New Publication") {
									li.append('<span>(' + model.attrs.date +')</span>');
									li.append(nameField);	
									li.append(', <span>'+model.attrs.publisher+ ', ' + model.attrs.location +'</span>');	
								} else {
									li.append(nameField);
								}	
								break;
								
							default:
								li.append('<span>' +model.attrs.contributors + '</span>');
								li.append('<span>(' + model.attrs.date +').</span>');
								
								// PAGES
								var tmp_pages = (model.attrs.pages) ? model.attrs.pages : '-';
								 
								pages = $('<span class="ghost">, pp. <span class="dynnum">'+ tmp_pages+'</span><span>');
								li.append(pages);	
								pages.click(function() {
									$('input:focus').blur();
									var fieldspan = $(this).find('.dynnum');
									var input = $('<input value="'+tmp_pages+'" />');
									fieldspan.html(input);
									input.focus()
										.keypress(function(event) {
											if (event.which == '13') {
												input.blur();
											} 			
										})
										.blur(function(event) { 
											$.getJSON('/archmap2/api', 
												{request:'updateRelatedItem',  'session_id':thisUser.attrs.session_id, from_entity:from_entity, from_id:from_id, to_entity:model.entity, to_id:model.attrs.id, relationship:relationship, fieldname:'pages', fieldvalue:$(this).val()}, 
												function() {
													fieldspan.html(input.val());
												});
										});
								});
						}
					
					} else {
								nameField = $( '<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
								if (model.attrs.name != "New Publication") {
									li.append('<span>' +model.attrs.contributors + '</span>');
									li.append('<span>(' + model.attrs.date +')</span>');
									li.append(nameField);	
									li.append(', <span>'+model.attrs.publisher+ ', ' + model.attrs.location +'</span>');	
								} else {
									li.append(nameField);
								}	
					
					}
				} else if (model.entity == "HistoricalEvent") {

							// BEG_YEAR
							var tmp_year = (model.attrs.beg_year) ? model.attrs.beg_year : 'year ';
							var fieldname = 'beg_year';
							beg_year = $('<span class="fieldname fieldname-beg_year dynnum">'+ tmp_year+'</span>');
							li.append(beg_year);
							
							beg_year.click(set_to_inlineEditing);
							
	
							nameField = $('<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
							li.append(nameField);
							
						
							if (parent && parent.attrs.isCatalog && model.entity != "NoteCard") {
					
								// CAT_NUM
								var tmp_catnum = (model.attrs.catnum) ? model.attrs.catnum : '-';
								catnum = $('<span class="ghost">, cat# <span class="catnum">'+tmp_catnum+'</span></span');
								li.append(catnum);
								catnum.click(function() {
									$('input:focus').blur();
									fieldspan = $(this).find('.catnum');
									input = $('<input value="'+tmp_catnum+'" />');
									fieldspan.html(input);
									input.focus()
										.keypress(function(event) {
											if (event.which == '13') {
												input.blur();
											} 			
										})
										.blur(function(event) { 
											$.getJSON('/archmap2/api', 
												{request:'updateRelatedItem',  'session_id':thisUser.attrs.session_id, from_entity:from_entity, from_id:from_id, to_entity:model.entity, to_id:model.attrs.id, relationship:relationship, fieldname:'catnum', fieldvalue:$(this).val()}, 
												function() {
													fieldspan.html(input.val());
												});
										});
								});
							}
													
							// PAGES
							var tmp_pages = (model.attrs.pages) ? model.attrs.pages : '-';
							pages = $('<span class="ghost">, pp. <span class="dynnum">'+ tmp_pages+'</span><span>');
							li.append(pages);	
							pages.click(function() {
								$('input:focus').blur();
								var fieldspan = $(this).find('.dynnum');
								var input = $('<input value="'+tmp_pages+'" />');
								fieldspan.html(input);
								input.focus()
									.keypress(function(event) {
										if (event.which == '13') {
											input.blur();
										} 			
									})
									.blur(function(event) { 
										$.getJSON('/archmap2/api', 
											{request:'updateRelatedItem',  'session_id':thisUser.attrs.session_id, from_entity:from_entity, from_id:from_id, to_entity:model.entity, to_id:model.attrs.id, relationship:relationship, fieldname:'pages', fieldvalue:$(this).val()}, 
											function() {
												fieldspan.html(input.val());
											});
									});
							});


				} else if (from_entity && from_entity == "NoteCard" ) {
					
					if (model.entity == "Publication" && relationship == 'primary') {
						nameField =  $('<span>' +model.attrs.contributors + '</span>');
						li.append(nameField);
						li.append('<span>(' + model.attrs.date +').</span>');
						
					} else if (model.entity == "Publication") {
						nameField = $('<span>' +model.attrs.contributors + '</span> <span>(' + model.attrs.date +')</span> <span class="inputElement fieldname-name">'+model.attrs.name+'</span>, <span>'+model.attrs.publisher+ ', ' + model.attrs.location +'</span>');
						li.append(nameField);
					} else {
						nameField = $('<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
						li.append(nameField);
					
					}
				
					// PAGES
					pages = ' <span>'+model.attrs.pages+'</span>';
					li.append(pages);
				
				
				
				// WAYS OF LISTING THINGS FROM PUBLICATION
				} else if (from_entity && from_entity == "Publication" ) {
			
					nameField = $('<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
					li.append(nameField);
					
					var input;
					var fieldspan;
					
					var tmp_pages = (model.attrs.pages) ? model.attrs.pages : '-';
					pages = $('<span class="ghost">, pp. <span class="dynnum">'+ tmp_pages+'</span><span>');
					pages.click(function() {
						$('input:focus').blur();
						var fieldspan = $(this).find('.dynnum');
						var val = "";
						if (model.attrs.pages) val = model.attrs.pages;
						var input = $('<input value="'+val+'" />');
						fieldspan.html(input);
						input.focus()
							.keypress(function(event) {
								if (event.which == '13') {
									input.blur();
								} 			
							})
							.blur(function(event) { 
								$.getJSON('/archmap2/api', 
									{request:'updateRelatedItem',  'session_id':thisUser.attrs.session_id, from_entity:from_entity, from_id:from_id, to_entity:model.entity, to_id:model.attrs.id, relationship:relationship, fieldname:'pages', fieldvalue:$(this).val()}, 
									function() {
										fieldspan.html(input.val());
									});
							});
					});
							
					if (parent && parent.attrs.isCatalog && model.entity != "NoteCard") {
					
						// CAT_NUM
						var tmp_catnum = (model.attrs.catnum) ? model.attrs.catnum : '-';
						 
						catnum = $('<span class="ghost">, cat# <span class="catnum">'+tmp_catnum+'</span></span');
						li.append(catnum);
						
						
						catnum.click(function() {
							$('input:focus').blur();
							fieldspan = $(this).find('.catnum');
							var val = "";
							if (model.attrs.catnum) val = model.attrs.catnum;
							input = $('<input value="'+val+'" />');
							fieldspan.html(input);
							input.focus()
								.keypress(function(event) {
									if (event.which == '13') {
										input.blur();
									} else if (keyCode == 9) { 
   										 e.preventDefault(); 
   										 // call custom function here
   										 this.blur();
   										 pages.click();
  									} 			
								})
								.blur(function(event) { 
									$.getJSON('/archmap2/api', 
										{request:'updateRelatedItem',  'session_id':thisUser.attrs.session_id, from_entity:from_entity, from_id:from_id, to_entity:model.entity, to_id:model.attrs.id, relationship:relationship, fieldname:'catnum', fieldvalue:$(this).val()}, 
										function() {
											fieldspan.html(input.val());
										});
								});
						});
					}
											
						
						
					// PAGES
					li.append(pages);	
					
						
						
				
				} else {
				
				
					if (model.entity == "Publication") {
						
						li.append('<span>' +model.attrs.contributors + '</span>');
						li.append('<span>(' + model.attrs.date +')</span>');
						nameField = $('<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
						li.append(nameField);
						li.append('<span>, '+model.attrs.publisher+ ', ' + model.attrs.location +'</span>');

					} else {
						nameField = $('<span class="inputElement fieldname-name">'+model.attrs.name+'</span>');
					
						li.append(nameField);
					}
					
				}
				
				
				
				
				
				if (nameField) {
					nameField.mouseup(select_item).dblclick(set_to_inlineEditing);
				}
				
				li.mouseover(function() {controller.highlight(model);} );
				li.mouseout(function() {controller.unhighlight(model);} );

			}
			
			
			
			
			// CLICK --> set to editing mode
			
			
			
			
			li.draggable({ 
				appendTo:'body',
				revert: true, 
				helper: 'clone', 
				zIndex:10000,
				activeClass: 'highlight',
				start: function(e,ui){
					//alert(e.pageY);
				   	 ui.helper.offset({'top':100 ,'left':222 }) // message in clone
				  }	
	
			});
			/*
			li.droppable({
				hoverClass: 'highlight', 	
				greedy: true,
				tolerance: 'pointer',
				over: function(event, ui) {
					logit("someone is over me! "+ $(event.target).attr('class'));
					
				},
				out: function(event, ui) {
					logit("someone is left me! "+ $(event.target).attr('class'));
					
				},
				drop: function(event, ui) {
					logit("someone dropped on me! "+ $(event.target).attr('class'));
					var from_ident = getIdent($(event.target));
					var to_ident = getIdent($(ui.draggable));
					
					var from_model = dataStore.getModel(from_ident.entity, from_ident.id);
					
					var to_model = dataStore.getModel(to_ident.entity, to_ident.id);
					
					logit('suggestion chosen-------> list_entity='+from_ident.entity+', list_id='+from_ident.id + ' add a: '+to_ident.entity + ' to_id='+to_ident.id + ', relationship='+from_ident.relationship);
					$.getJSON('/archmap2/api', 
						{request:'addItemToList',  'session_id':thisUser.attrs.session_id, from_entity:from_ident.entity, from_id:from_ident.id, to_entity:to_ident.entity, to_id:to_ident.id, relationship:from_ident.relationship}, 
						function() {
							logit('drop worked!');
						});
					
					}
				
			});
			*/
			return li;
		}
	}






















	
	function set_to_inlineEditing() {
		// 'this' is the SPAN child of the li, for example, a wrapper input field.
			
		if ($(this).data('inEdit')) return;
		
		$('input:focus').blur();
		
		$(this).data('inEdit', true);
		var str = $(this).text().trim();
		this.originalHTML=str;
				
		// Add an input field
		$(this).empty();
		$(this).css('padding', 0);
		
		var ident = getIdent($(this));
		

		var input_fieldname = getClassItemWithPrefix($(this), 'fieldname-');
		
		var input;
		if (input_fieldname == 'descript') {
			input = $("<textarea></textarea>");
		} else {
			input = $("<input />");
		}
		
		input.attr('value', str);
		
		$(this).append(input);

		set_behavior_of_input_element(input);
		
		input.focus();
		
		$(this).unbind('mouseup', select_item);
	}
	
	
	
	
	function set_behavior_of_input_element(input) {
		
		var ident = getIdent(input);
		var defaultName = "New " + ident.entity;
		
		logit("set_behavior_of_input_element :: fieldname: "+ident.fieldname);
		
		
		input.blur(inlineEditing_save)
			.keyup(inlineEditing_keypress)
			.css('background', 'transparent')
			.css('border-width', 1)
			.focus(function() {if (this.value == defaultName) $(this).select()});
			
		
		// right now, this is assuming name field only!
		switch (ident.entity) {
		 	case "Publication":
		 	case "Building":
		 	case "Person":
		 	case "Place":
		 	case "HistoricalEvent":
				switch(ident.fieldname) {
					case "publisher":
					case "location":
						input.addClass('suggestible-fillfield');
						break;
					
					case "name":
						input.addClass('suggestible-switchToItem');
						break;
					
					default:
						
				}
				break;
				
			case "Essay":
			case "NoteCard":
				// Do not auto suggest...
				// perhaps later suggest for NoteCard?
				break;
		}
		
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	// ** KEYPRESS **
	function inlineEditing_keypress(event) {
	
		event.preventDefault();
		
		// determine the model type of this line
		var activeElem = $(event.target);
		
		//identElem = activeElem.parents('.model-identity:eq(0)');
		identElem = activeElem.parent();
		
		var input_fieldname = getClassItemWithPrefix(activeElem.parent(), 'fieldname-');
		
		//var identityElem = activeElem.parents('.model-identity');
		var ident = getIdent(identElem);
		
		// distribute to other representations of this object-field
		var reps = $('.entity-'+ident.entity+'.model_id-'+ident.id+' > .fieldname-'+input_fieldname );
		
		// get all the identity bearing parents that are directly above the fieldname
		//var repParents = $('.fieldname-name').parents('.model-identity:eq(0)');
		
		$.each(reps, function() {	
				if ($(this).find('input').length < 1 && $(this).find('textarea').length < 1) {
					$(this).html(activeElem.attr('value'));
				}
			});
			

	
		if ( $(this).hasClass('suggestible-switchToItem') || $(this).hasClass('suggestible-fillfield') ) {
			// put auto-suggest code here....	
			delayedSuggestion();
		}
		if (event.which == '13') {
			$(this).blur();		
		}
	}
	


	// ** DELAY REQUEST SUGGESTIONS **
	function delayedSuggestion() {
		if (window.suggestTimeout)
			clearTimeout(window.suggestTimeout);
		window.suggestTimeout = setTimeout(getSuggestionsFor, 500);
	}
	
	
	
	
	
	
	
	
	
	
	
	// ** REQUEST SUGGESTIONS **
	function getSuggestionsFor() {
	
		
		var input = $("input:focus");
		
		input 		= $(document.activeElement);
		var div 	= input.parent();		
		var ident 	= getIdent(div);
		
		var entity = ident.entity;
		switch (ident.entity) {
			case "Person":
			case "Editor":
			case "Author":
				entity = "Person";
				break;
			case "Publication":
			case "Book":
			case "JournalArticle":
				entity = "Publication";
				break;
		}
		
		if (! entity) return;

		if (input.hasClass("suggestible-fillfield")) {
			logit('getSuggestionsFor::suggestible-fillfield ...  get suggestions from server -- entity='+entity+', fieldname='+ident.fieldname);
			$.getJSON('/archmap2/api', 
			{'request':'distinctFieldItems', 'entity':entity, 'fieldname':ident.fieldname, 'searchString':input.attr('value')}, suggestionCallback);
		
		}else {
			$.getJSON('/archmap2/api', 
			{'request':'search', 'entity':entity, 'fieldname':ident.fieldname, 'searchString':input.attr('value')}, suggestionCallback);
			
			// also try worldcat
			
			//var suggestionView = new SwitchToItem_SuggestionsPanel_View(entity, input.attr('value'));
		
		}
	} 





	





	// ** SUGGESTION_CALLBACK **

	// Why is get suggestion callback so lengthy?
	function suggestionCallback(json_data) {

		var suggestionsPanel = $(".suggestionsPanel");
		var $input = $(document.activeElement);
		var $inputParent = $input.parent();
		
		var modelIdentityEl = $inputParent.parents('.model-identity:eq(0)')
		
		var $ident = getIdent($inputParent);
		var ul = $input.parents('ul:eq(0)');
		var ulIdent = getIdent(ul);
	
		var relationshipEl 	= $input.parents('.relationship:eq(0)');
		var relationship 	= getClassItemWithPrefix(ul, 'relationship-');

		var $relparent = $input.parents('.relparent:eq(0)');
		var relparent_ident = getIdent($relparent);
		
		var root = $input.parents('.profile:eq(0)');
		
		var pos_g = $input.offset();
		var pos_r = root.offset();
		
		
		if ( (! json_data || json_data.length == 0) && $input.hasClass("suggestible-fillfield")) {
			// remove if a long search string has been entered and no results came back
			if (suggestionsPanel) suggestionsPanel.remove();
			return;
		}
		
		// // create suggestions panel if it does not already exist
		var suggestionsChoices;

		if (! suggestionsPanel.length) {
			var left;
			var top;
			if (false && pos_r) {
				left = pos_g.left - pos_r.left;
				top = pos_g.top - pos_r.top;
			} else {
			
				left = pos_g.left;
				top = pos_g.top;
			}
			suggestionsPanel =  $('<div class="suggestionsPanel"></div>').addClass("suggestionChoices").css("left",  left).css("top", top+20);
			suggestionsChoices =  $("<ul></ul>").addClass("suggestionChoices")
			
			// ADD A CREAT NEW AND A CANCEL BUTTON IF suggestible-switchToItem
	
					// CREATE "NEW ITEM" MENU ITEM
					if ($input.hasClass("suggestible-switchToItem")) {
						var creatediv = $('<li style="border-bottom: solid 1px gray">Create New </li>').click(function() {
								// ON_CLICK
								$('.suggestionsPanel').remove();
								$input.blur(); // this saves it
							});
						suggestionsPanel.append(creatediv);
					}							
					suggestionsPanel.append(suggestionsChoices);
					
					// CANCEL
					if ($input.hasClass("suggestible-switchToItem")) {
						var cancel_div = $('<li style="border-top: solid 1px gray">Cancel</li>').click(function() {
								var li = $inputParent.parent();
								var ul = li.parent();
								li.remove();
								$('.suggestionsPanel').remove();
								updateLabelCount(ul);										
							});
						suggestionsPanel.append(cancel_div);
					}
			//$input.parents('.profile:eq(0)').append(suggestionsPanel);
			$('body').append(suggestionsPanel);
		} else {
			suggestionsChoices =  suggestionsPanel.find('.suggestionChoices')
			suggestionsChoices.empty();
		}
		
		
		// creat new suggestion item
		// if selected, the item is saved and the form is opened up if this is a publication or building, etc.
		$.each(json_data, function () {
			//add the records to the appropriate UL 
			var tmp_li;
			
			var inputParent = $inputParent;
			
			var modelinfo = this;
						
			
			
			// ! SUGGESTIBLE-FILLFIELD
			if ($input.hasClass("suggestible-fillfield")) {
				
				logit('SUGGESTIBLE-FILLFIELD:  ++++++++++++++++++++++++++++++++++++++++++++++ creating menu item');
				
				tmp_li = $('<li class="list-item">'+modelinfo[$ident.fieldname]+ '</li>')				
					.click(function() {
						$input.attr("value", $(this).html());
						$input.removeClass("selected");
						$(this).parent().parent().remove();
						$input.blur();
					});
				suggestionsChoices.append(tmp_li);	
					
					
			// ! SUGGESTIBLE-SWITCHTOITEM
			} else if ($input.hasClass("suggestible-switchToItem")) {
				
				var model = new Model(modelinfo);		
					dataStore.addModel(model);
				
				tmp_li = $('<li class="entity-'+$ident.entity+' model_id-'+modelinfo.id +'" >'+modelinfo.name + '</li>')
					.data('modelinfo', this)
					.click( function() {
						var modelinfo = $(this).data('modelinfo');
						
						// remove the input field and change the li to this model_id
						$inputParent.html(modelinfo.name);
						modelIdentityEl.remove();
						var newLi = constructLi(model.entity, model, relparent_ident.entity, relparent_ident.id, relationship);
						
						ul.append(newLi);
						$(this).parent().parent().remove();
						
						logit('suggestion chosen-------> list_entity='+relparent_ident.entity+', list_id='+relparent_ident.id + ' add a: '+$ident.entity + ' id='+modelinfo.id + ', relationship='+ulIdent.relationship);
						$.getJSON('/archmap2/api', 
							{request:'addItemToList',  'session_id':thisUser.attrs.session_id, from_entity:relparent_ident.entity, from_id:relparent_ident.id, to_entity:$ident.entity, to_id:modelinfo.id, relationship:ulIdent.relationship}, 
							function() {
								$inputParent.removeClass('loading');
								$inputParent.data('inEdit', false);
							});
					});
				suggestionsChoices.append(tmp_li);	
					
			} else {
				tmp_li = $('<li id="'+this.id +'" class="list-item">'+this.name + '</li>')
					.click( function() {
						logit(' OTHER SUGGESTIBLE clicked');
						$input.attr("id", "Person_"+$(this).attr("id"));
						$input.attr("value", $(this).html());
						$input.removeClass("selected");
						$(this).parent().remove();
					});
				suggestionsChoices.append(tmp_li);
			
			}			
		});
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// ** SAVE REQUEST **
	function inlineEditing_save () {
		logit(' ');
		logit(' ');
		logit("blurred");
		
		// don't auto save if suggestions popup is there.
		var input = $(this);
		var inputParent = input.parent();
		
		if (input.hasClass("suggestible-switchToItem")) {
			if ($(".suggestionChoices").length > 0) return;
		}		

		// this element is an input field
		var ident = getIdent(inputParent);		
		
		// MODEL: model is accessed by the html identifiers. Does this make sense?
		var model = dataStore.getModel(ident.entity, ident.id);
		
		model.attrs[ident.fieldname] = this.value;
		
		inputParent.addClass("loading");
				
		var defaultName = "New " + ident.entity;
		
		
		logit('SAVING ' + ident.fieldname + ' = '+ this.value + ' WHILE name = '+ model.attrs.name);
		
		
		if (model.attrs.name != defaultName || (ident.fieldname == 'name' && this.value != defaultName)  ) {
			if (ident.fieldname) {
				// perhaps later split the saving of the item with the relationsjhip building?
				logit('/archmap2/api?request=saveChanges&session_id='+thisUser.attrs.session_id+'&entity='+ident.entity+'&id='+ident.id+'&fieldname='+ident.fieldname+'&fieldvalue='+this.value+'&relationship='+ident.relationship+'&from_entity='+ident.from_entity+'&from_id='+ident.from_id);
				$.getJSON('/archmap2/api', 
					{request:'saveChanges', session_id:thisUser.attrs.session_id, entity:ident.entity, id:ident.id, fieldname:ident.fieldname, fieldvalue:this.value,      relationship:ident.relationship, from_entity:ident.from_entity, from_id:ident.from_id}, saveChanges_Callback);
			} 
		}
		
		if (! inputParent.hasClass('formfield')) {
			inputParent.mouseup(select_item);
			inputParent.html(this.value);
		}
		
		inputParent.data('inEdit', false);
	}
	
	
	
	
	
	
	
	// ** SAVECHANGES_CALLBACK **
	function saveChanges_Callback(server_data) {
	
		logit('saveChanges_Callback');
		var entity = entityName[server_data.entity_id];
		
		var temp_id = server_data.temp_id; 	// passed from the server to help us find the right element...
		var id		= server_data.id; 		// The new id of the object in the database.
		
		var model;
		var li; 							// the element or elements that represent this object in the client
		
		// Find the element/s that represents this object
		if (temp_id && temp_id != null) {

			model = dataStore.getModel(entity, temp_id);
			temp_id = 'model_id-'+temp_id;
			dataStore.removeModel(entity, model);
			
			model.attrs.entity = entity;
			model.attrs.id = server_data.id;
			dataStore.addModel(model);
			
			li = $("." + temp_id);
			li.removeClass(temp_id);
	 		// -- Updating the element's model_id- with the id passed from the server	
	 		// -- IMPORTANT if the object is returning from its first save with a shiny , newly minted id!
			li.addClass('model_id-'+ server_data.id);
			
		} else {
			li = $(".model_id-" + server_data.id );
		}
		
		$('.loading').removeClass("loading");
	}
	
	
	
	//  ** DELETE ITEM **
	function removeSelectedItem() {
	
		
		$(this).dialog("close");
		
		
		
		// for now assume it is the selected item...
		
		var li = $(".waiting-for-delete");
			li.removeClass('waiting-for-delete');
		
		var ul = li.parents('ul:eq(0)');
		var ulIdent = getIdent(ul);
		
		var $ident = getIdent(li);
		var $relparent = li.parents('.relparent:eq(0)');
		var relparent_ident = getIdent($relparent);
		
		if ($ident.id.substr(0,3) == 'tmp') {
			// remove without calling the dbase
			
			li.remove();
			updateLabelCount(ul);
			
		} else {
			// make round trip to the dbase
			li.addClass("removing");
			$.getJSON('/archmap2/api', 
				{'request':'removeItemFromList',  'session_id':thisUser.attrs.session_id, from_entity:relparent_ident.entity, from_id:relparent_ident.id, to_entity:$ident.entity, to_id:$ident.id,     relationship:ulIdent.relationship,},   
				function() {
					
					$(".removing").remove();
					updateLabelCount(ul);
				
					
				});
		}
		
	}
	
	
	
	
	
	
	function reallyDeleteSelectedItem() {
	
		
		
		var li = $(".waiting-for-delete");
			li.removeClass('waiting-for-delete');
		
		li.addClass("deleting");
		
		var ident = getIdent(li);
		
		alert('really delete: ' + ident.entity);
		updateLabelCount(li.parent());

		
		$.getJSON('/archmap2/api', 
			{'request':'deleteItem',  'session_id':thisUser.attrs.session_id, 'entity':ident.entity, 'id':ident.id},   
			function() {
				$(".deleting").remove();
			});
		
		$(this).dialog("close");
		
		$("#main-content").empty();
	}
	
	
	
	function updateLabelCount(ul) {
	
		var count = ul.children().length;
		
		var entity = getClassItemWithPrefix(ul, 'entity-' );
		var label = ul.parent().prev().find('.entitylabel');
		if (count > 0) {
			label.html(entity+'s (<span style="color:#ff8675">'+count+'</span>)');
		} else {
			label.html(entity+'s');
		}
				
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// ! ****************** SEARCH
	
	function searchDelayed(className, searchString) {
	
	
	
		if (window.searchTimeout)
			clearTimeout(window.searchTimeout);
		
		window.searchTimeout = setTimeout(search, 500);
	
	}
	
	function search() {
	
		
		setupCurrentPage("publicationSearchPage");
		
		var listitem = $(".loading");
		var className = listitem.parent().attr('id');							
		var searchString = listitem.find('input').attr('value');
		
		
		$.getJSON('/archmap2/api', 
			{'request':'search', 'className':className, 'fieldName':'name', 'searchString':searchString}, searchCallback);
			
		//$.get('/archmap2/api', 
		//	{'request':'searchCLIO', 'searchString':searchString}, searchCLIOCallback);
			
	//	$.get('http://www.jstor.org/search/SRU/jstor', 
	//		 {'request':'searchJSTOR', 'searchString':searchString}, jstorCallback);
	} 
	
	
	// CLIO SEARCH RESULTS
	function searchCLIOCallback(html) {
		
		
		$("#main-content").empty();
		var results = $(html).find("div#resultList");
		var el;
		results.children("div").each(function(){
			var id = $(this).find("label").attr("for");
			var name = $(this).find("a").text();
			el = $('<li id="'+id +'" class="list-item">'+name + '</li>');
			$("#main-content").append(el);
			
		})
	
	
	
	
	}
	
	// ARCHMAP SEARCH
	function searchCallback(data) {
		// data has come in!
		
		
		var listitem = $(".loading");
		var className = listitem.parent().attr('id');							
		var searchString = listitem.find('input').attr('value');

		$("#archmapSearchResults").empty();
		$("#archmapSearchResults").append('<h3>Search table: '+className+' for "'+ searchString + '"</h3>');
		
		var el;
		
		$.each(data, function () {
			//add the records to the appropriate UL 
			el = $('<li id="'+this.id +'" class="list-item">'+this.name + '</li>').mousedown(select_item).dblclick(set_to_inlineEditing);
			$("#archmapSearchResults").append(el);
		});
	}
	
	function jstorCallback(data) {
		alert("delivery from jstor!");
	
	}
	
	function updateProfile(model) {
		
		/* HOW TO */
		
		$('Building_'+model.id+'.nameField').text(model.name);
		$('Building_'+model.id+'.descriptField').text(model.descript);
	
	}
	
	
	
	
	
	
	// ! ************** SAVING

	
	
	
	function inlineEditing_restore (el) {
		$(el).html(el.originalHTML);
		el.inEdit = false;
	}
	
	
	
	
	
	
	function jsonCallbackPoster(data) {
		//alert(' - /media/buildings/001000/'+this.building_id+'/images/700/' +this.filename);
		
			//alert('/archmap/media/buildings/001000/'+data.building_id+'/images/700/' +data.filename);
			el = $('<img />').attr("src", '/archmap/media/buildings/001000/'+data.building_id+'/images/700/' +data.filename);
			$("#main-content").append(el);
		
	}
	
	
	
	// PROFILES
	
	function setupCurrentPage($page) {
		
		if ($page == currentPage) return;
		
		currentPage = $page;
		
		//$("#main-content").empty();
		
		var el = $('<h3>Publication Search</h3>');
		$("#main-content").append(el);
		$("#main-content").append('<div id="archmapSearchResults" class="searchResults"></div>');
		$("#main-content").append('<div id="clioResults" class="searchResults"></div>');
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// ! MAPS
	
	function initializeDetailMapWithElementID(elementID, latlng, zoom) {
	   // elementID = "theMap";
	  
		// Map Appearence 
		var maptype = google.maps.MapTypeId.SATELLITE;
		var streetViewControl = true;
		var mapTypeControl = true;
		if (zoom < 14) {
				maptype = google.maps.MapTypeId.TERRAIN;
				streetViewControl = false;
				mapTypeControl = false;
		}
		var myOptions = {
		  zoom: zoom,
		  center: latlng,
		  mapTypeId: maptype,
		  mapTypeControl: mapTypeControl,
		  streetViewControl: streetViewControl
		};
	    
	    
		// Create Map
		var googlemap = new google.maps.Map(document.getElementById(elementID), myOptions);
		
		return googlemap;
		
		// google.maps.event.addListener(detailmap, 'drag', function() { if (currentMarker != null) currentMarker.setPostition(detailmap.getCenter());});
		// detailmap.resize();
		//google.maps.event.trigger(detailmap, 'resize');
	}
	
	function dropMarker(largeMap, detailMap, model) {
		<!-- DROP MARKER IN MIDDLE OF THE MAP -->
		var position = largeMap.getCenter();
		var largeMapMarker = new google.maps.Marker({
      		map:largeMap,
      		draggable:true,
      		animation: google.maps.Animation.DROP,
      		position: position
		});
		var detailMapMarker = new google.maps.Marker({
      		map:detailMap,
      		draggable:true,
      		animation: google.maps.Animation.DROP,
      		position: position
		});
		google.maps.event.addListener(largeMapMarker, 'drag', function() {  detailMap.setCenter(largeMapMarker.getPosition()); detailMapMarker.setPosition(largeMapMarker.getPosition())});
		google.maps.event.addListener(largeMapMarker, 'click', function() {  detailMap.setCenter(largeMapMarker.getPosition());});
		
		google.maps.event.addListener(detailMapMarker, 'drag', function() { largeMap.setCenter(detailMapMarker.getPosition()); largeMapMarker.setPosition(detailMapMarker.getPosition())});
		google.maps.event.addListener(detailMapMarker, 'dragend', function() {  model.setPosition(detailMapMarker.getPosition()); latestPosition = detailMapMarker.getPosition()});
		 
		model.largeMapMarker = largeMapMarker;
		model.detailMapMarker = detailMapMarker;
		
		//google.maps.event.addListener(marker, 'click', function() { setCurrentMarker(marker) });
		// currentMarker = marker;
		
		
		//initializeDetailMap(position);
		
	}


	function dropItemMarker(map, model) {
		var position = new google.maps.LatLng(model.attrs.lat, model.attrs.lng);;
		
		var mapMarker = new google.maps.Marker({
      		map:map,
      		draggable:false,
      		title:model.attrs.name,
      		icon: mapIconSmall, 
      		position: position
		});
		mapMarker.model = model;
		
		controller.addMarker( mapMarker );
		
		
		google.maps.event.addListener(mapMarker, 'click', function() {  logit(model.attrs.name); getPage(model)});
		
		google.maps.event.addListener(mapMarker, 'mouseover', function() { 
			mapMarker.setIcon(mapIconLarge);
			
			controller.highlight(model); 
			
		});
		
		google.maps.event.addListener(mapMarker, 'mouseout', function() {  
			mapMarker.setIcon(mapIconSmall);
			controller.unhighlight(model); 
			
		});
		
		 
	}















	// ! Publications
		function initPublicationForm(el) {
			// set up select for pub type
			el.find(".pubtype").change (function() {
				setPubtype(el, $(this).val());
				
			});
		}
		/*
		function setPubtype(el, pubtype) {
			
			var basicLabel = $("#basic_info").first().find("legend");
			basicLabel.text(pubtype);
			
			
			el.find(".EditedBook").hide();
			el.find(".BookSection").hide();
			el.find(".JournalArticle").hide('slow');
			switch (pubtype) {
			
				case "Book":
					
					el.find(".BookSection").hide();
					el.find(".Book").show('slow');
					el.find(".chapters").show('slow');
					break;
					
				case "EditedBook":
					
					el.find(".BookSection").hide();
					el.find(".EditedBook").show('slow');
					el.find(".chapters").show('slow');
					break;
					
				case "BookSection":
					el.find(".Book").hide('slow');
					el.find(".BookSection").show('slow');
					
					break;
					
				case "JournalArticle":
				
					el.find(".Book").hide();
					el.find(".BookSection").hide();
					el.find(".JournalArticle").show('slow');
					break;
					
			
			}
		}
		*/




