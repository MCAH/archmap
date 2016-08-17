// ! 
// ! *********** DATASTORE *************** 
	function DataStore(attrs) {

		this.models = new Object();
		
		this.models['Model'] 			= new Object();
		this.models['Building'] 			= new Object();
		this.models['Publication'] 			= new Object();
		this.models['NoteCard'] 			= new Object();
		this.models['Person'] 				= new Object();
		this.models['Place'] 				= new Object();
		this.models['Essay'] 				= new Object();
		this.models['HistoricalEvent'] 		= new Object();
		this.models['HistoricalObject'] 	= new Object();
		this.models['Image'] 				= new Object();
		
	}
	
		


	DataStore.prototype = {
		
		getModel: function(entity, id, callbackFunction) {
			
			if (! entity) return;
			
			logit("DataStore.getModel: entity="+entity+ ", id=" + id);
			
			
			var thisDataStore = this;
			
			var model = this.models[entity][id];
			
			//if (! model || model.attrs.partial) {
								
				if (! model) {
					//model = new Model({entity:entity, id:id});
					var modelName = entity;
					
					if (entity == "Image") modelName = "ImageModel";
					
					var cmd = 'new ' + modelName + '({entity:entity, id:id});';
					logit("DataStore.getModel: model doesn't exist yet :-( -> " + cmd);
					model = eval(cmd);
				
				
				}
				
				this.addModel(model);
					
				// try to retrieve it from the server
				//logit('getJSON * | * DataStore::getModel - REQUEST FROM DB: ' + entity + ' : ' + id);
				logit('getJSON * ----- | * DataStore::getModel : /api?request=getModel&entity='+entity+'&id='+id);
				
				if (id && isNumeric(id)) {
					$.getJSON('/api', {request:'getModel', entity:entity, id:id},  
							function(server_data) {
								var tmp_model = new Model(server_data);
								thisDataStore.updateModel(tmp_model);
								if (callbackFunction) {
									logit('DataStore::getModel calling callback');
									logit(model.attrs.name);
									callbackFunction(model);
								}
					});
				} else {
					logit('DataStore.getModel: model has tempid, not trying to get update from database')
				}
				
			//} else {
			//	if (callbackFunction) {
			//		callbackFunction(model);
			//	}
			
			//}
			
			return model;
			
			
		},
		
		getSelected: function (entity) {
			var ret = new Array();
			for (var key in     this.models[entity]) {
		 				var m = this.models[entity][key];
		 				if (m.selected) {
		 					ret.push(m);
		 				}
	 				}			
			return ret;
		},
		
		deselectAllEntitiesOfType: function(entity) {
			for (var key in     this.models[entity]) {
		 				var m = this.models[entity][key];
		 				if (m.selected) {
		 					m.deselect();
		 				}
	 				}			
		},
		
		
		addModel: function(model) {
			
			//logit('[dataStore::addModel] entity='+entity+', model['+model.attrs.id+']='+model.attrs.name);
			//logit('this ' + this);
			//logit('model ' + model);
			//if (isNumeric(model.attrs.id)) {
				this.models[model.attrs.entity][model.attrs.id] = model;
			//}
			return model;
		},
		
		
		updateModel: function(tmp_model) {
			if (! this.models[tmp_model.attrs.entity]) {
				logit("unknown model type: "+tmp_model.attrs.entity);
				return;
			}
		
			var model = this.models[tmp_model.attrs.entity][tmp_model.attrs.id];
			
			if (model) {
				// update values.
				model.attrs = tmp_model.attrs;
			} else {
				model = tmp_model;
				this.addModel(model);
			}
			return this.models[model.attrs.entity][model.attrs.id] = model;
		},
		
		removeModel: function(model) {
			delete this.models[model.attrs.entity][model.attrs.id];
		}

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
// ! 
// ! *********** MODEL (BASE CLASS) *************** 
	function Model(attrs) {
		
		this.attrs;
		this.eventListeners;
		this.relatedItems;
		
		this.selected;
		
		this.init(attrs);
		
	
		//alert(this.entityName);
	}
	Model.prototype.init = function(attrs) {
		
			if (attrs) {
				this.attrs = attrs;
				
				if (attrs.entity) {
					this.setEntity(attrs.entity);
				} else {
					this.setEntity(entityName[this.attrs.entity_id]);
				}
				
				
				
			} else {
				this.attrs 			= new Object();
			}
			
			// defaults
			if (! this.attrs.id) 		this.attrs.id 		= generateTempId();
			if (! this.attrs.entity) 	this.attrs.entity 	= this.getEntity();
			if (! this.attrs.name || this.attrs.name == "" || this.attrs.name == " "  || this.attrs.name == "  " ) 		this.attrs.name 	= this.getDefaultName();
			
			
			
			this.eventListeners = new Object();
			this.relatedItems 	= new Object();
			
			this.loading = false;
		
	}	
	Model.prototype.isNew = function() {
		if (this.attrs.id && isNumeric(this.attrs.id)) {
			return false;
		}
		return true;
	}
	Model.prototype.hasDefaultName = function() {
		if (this.attrs.name == this.getDefaultName()) {
			return true;
		}
		return false;
	}
	Model.prototype.getDefaultName = function() {
		
		return "New " + this.attrs.entity;
	}
	Model.prototype.getEntity = function(entity) {
		var entity = this.attrs.entity;
		if (entity) {
			return entity;
		}
		return "Model"
	}
	Model.prototype.setEntity = function(entity) {
		this.attrs.entity = entity;
		this.entity = entity;
		this.attrs.entity_id = entityId[entity]
		return this.attrs.entity_id;
	}	
	
		
	Model.prototype.select = function() {
		this.selected = true;
		this.sendNotification({type: 'select'});
	}
		
	Model.prototype.deselect = function() {
		this.selected = false;
		this.sendNotification({type: 'deselect'});
	}
		
		
	Model.prototype.getRelatedItems = function(to_entity, relationship) {
		
		var key = to_entity;
		if (relationship) {
			key += '-'+relationship;
		}
		
		if (this.relatedItems[key])
			return this.relatedItems[key];
			
		var collection = new RelatedItemsCollection(this, to_entity, relationship);
		this.relatedItems[key] = collection;
		
		return collection;
	}
	Model.prototype.getRelatedItemsWithCallback = function(to_entity, relationship, callback) {
		
		var key = to_entity;
		if (relationship) {
			key += '-'+relationship;
			logit("key="+key);
		}
		
		if (this.relatedItems[key])
			return this.relatedItems[key];
			
		var collection = new RelatedItemsCollection(this, to_entity, relationship);
		
		logit("COLLECTION: " + collection.attrs.length);
		
		
		this.relatedItems[key] = collection;
		if (callback) {
			callback();
		}
		return collection;
	}

	Model.prototype.getAllRelatedItems = function(callback) {
		
		var collection = new RelatedItemsCollection(this, to_entity, relationship);
		this.relatedItems[key] = collection;
		
	}

	Model.prototype.setPosition = function(position) {
		this.attrs.lat = position.lat();
		this.attrs.lng = position.lng();
		this.sendNotification({type: 'reposition'});
		
		var _this = this;
		
		logit('getJSON * | * Model::setPosition');
		$.getJSON('/api', 
			{request:'saveChanges', session_id:thisUser.attrs.session_id, entity:'Building', id:this.attrs.id, lat:this.attrs.lat, lng:this.attrs.lng}, function() {
				_this.sendNotification({type: "value_changed", key: 'lat'});
			});
	}
	Model.prototype.getPosition = function() {
		return new google.maps.LatLng(this.attrs.lat, this.attrs.lng);
	}
	
	Model.prototype.getBounds = function() {
		var lat 	= (this.attrs.lat ? this.attrs.lat : 32.121671767915);
		var lng 	= (this.attrs.lng ? this.attrs.lng : 33.9633417129517);
		var lat2 	= (this.attrs.lat2 ? this.attrs.lat2 : 33.96341823496325);
		var lng2 	= (this.attrs.lng2 ? this.attrs.lng2 : 36.7099237442017);
		
		var sw = new google.maps.LatLng(lat,  lng);
		var ne = new google.maps.LatLng(lat2, lng2);
		
		return new google.maps.LatLngBounds(sw, ne);	
	}
	Model.prototype.setBounds = function(bounds) {
		var sw = bounds.getSouthWest();
		var ne = bounds.getNorthEast();

		this.attrs.lat 	= sw.lat();
		this.attrs.lng 	= sw.lng();
		this.attrs.lat2 = ne.lat();
		this.attrs.lng2 = ne.lng();
		
		
		//alert(sw.lat() + ", " + sw.lng());
		logit('save geo');
		this.saveGeo();
		
	}
	Model.prototype.saveGeo = function() {
		var _this = this;
		
		//logit('getJSON * | * Model::saveGeo: '+ this.attrs.lat + ', ' + this.attrs.lng + ', ' + this.attrs.lat2 + ', ' + this.attrs.lng2);
		logit('/api?session_id='+thisUser.attrs.session_id+'&request=saveChanges&entity='+this.attrs.entity+'&id='+this.attrs.id+'&lat='+this.attrs.lat+'&lng='+this.attrs.lng+'&lat2='+this.attrs.lat2+'&lng2='+this.attrs.lng2);
		
		$.getJSON('/api', 
			{request:'saveChanges', session_id:thisUser.attrs.session_id, entity:this.attrs.entity, id:this.attrs.id, lat:this.attrs.lat, lng:this.attrs.lng, lat2:this.attrs.lat2, lng2:this.attrs.lng2}, 
			function() {
				//alert('saved');
			});
	}
	
	
	Model.prototype.mapIconUrl = function() {
		
		icon_url = '/archmap_2/media/ui/maps/map_icon_sm/map_icon_'+this.attrs.preservation+'_5.png';
		
		return icon_url;

	}
	
	
	Model.prototype.setValue = function(key, val) {
		if (this.attrs[key] == val) return;

		switch (key) {
			case 'pubtypeName':
				key = 'pubtype';
				val = pubtypes[val];
				break;
				
		}
		
		val = (val == true) ? 1 : val;
		val = (val == false) ? 0 : val;
		
		this.attrs[key] = val;

		this.sendNotification({type: "value_changed", field: key, value: val});
	}
	Model.prototype.saveValue = function(key, val) {
				
		var _this = this;
		
		if (! val) val = this.attrs[key];
		
		logit('getJSON * | * /api?request=saveChanges&session_id='+thisUser.attrs.session_id+'&entity='+this.attrs.entity+'&id='+this.attrs.id+'&fieldname=' +key + '&fieldvalue=' + val);
		$.getJSON('/api', 
			{request:'saveChanges', 'session_id':thisUser.attrs.session_id, entity:this.attrs.entity, id:this.attrs.id, fieldname:key, fieldvalue:val}, function(data) {
				_this.sendNotification({type: "value_saved", field: key, value: val});
			});
	
	}
	Model.prototype.setAndSave = function(key, val) {
		if (this.attrs[key] == val) return;
		this.setValue(key, val);
		this.saveValue(key);
	}
	
	Model.prototype.saveRelationValue = function(key, val, from_entity, from_id, relationship) {
		var _this = this;
		logit('/api?request=saveRelationChanges&session_id='+thisUser.attrs.session_id+'&to_entity='+this.attrs.entity+'&to_id='+this.attrs.id+'&fieldname='+key+'&fieldvalue='+val+'&from_entity='+from_entity+'&from_id='+from_id+'&relationship='+relationship)
		$.getJSON('/api', 
			{request:'saveRelationChanges', session_id:thisUser.attrs.session_id, to_entity:this.attrs.entity, to_id:this.attrs.id, fieldname:key, fieldvalue:val, from_entity:from_entity, from_id:from_id, relationship:relationship}, function(server_data) {
				// save relation field value such as catnum
			});
	}

	Model.prototype.saveAndLink = function(from_entity, from_id, relationship) {
		
		logit('Model: save and link');
		logit('/api?request=saveChanges&session_id='+thisUser.attrs.session_id+'&entity='+this.attrs.entity+'&id='+this.attrs.id+'&name='+this.attrs.name+'&pubtype='+this.attrs.pubtype+'&from_entity='+from_entity+'&from_id='+from_id+'&relationship='+relationship);
		var _this = this;
		
		var data = new Object();
			data.request 		= 'saveChanges';
			data.session_id 	= thisUser.attrs.session_id;
			
			// later - just take all the attrs from the model…
			data.entity 		= this.attrs.entity;
			data.id 			= this.attrs.id;
			data.name 			= this.attrs.name;
			data.pubtype 		= this.attrs.pubtype;
			
			data.from_entity 	= from_entity;
			data.from_id 		= from_id;
			data.relationship 	= relationship;
		
		// $.getJSON('/api', {request:'saveChanges', session_id:thisUser.attrs.session_id, entity:this.attrs.entity, id:this.attrs.id, fieldname:key, fieldvalue:val, from_entity:from_entity, from_id:from_id, relationship:relationship}, function(server_data) {
		$.getJSON('/api', data, function(server_data) {

					var entity = entityName[server_data.entity_id];
					var temp_id = server_data.temp_id; 	// passed from the server to help us find the right element...
					var id		= server_data.id; 		// The new id of the object in the database.
					
					var model;

					logit('Model.saveAndLink CALLBACK: temp_id='+temp_id+', entity='+entity+', server_data.id='+server_data.id); 
					
					
					if (temp_id && temp_id != null) {
			
						model = dataStore.getModel(entity, temp_id);
						logit(" --- " +model.attrs['name']);
						//model.attrs.entity = entity;
						_this.attrs.id = server_data.id;
						
						// Find the view element/s that represents this object
						logit (' RE-CLASSING elements with .model_id-'+temp_id);
						$('.model_id-'+temp_id).each( function(){
							$(this).removeClass('model_id-'+temp_id);
							$(this).addClass('model_id-'+id);
							
							$(this).removeClass('entity-undefined');
							$(this).addClass('entity-'+entity);
							
						});
						
						
						logit(" ----- DONE " );
					}
			});
	
	}
	Model.prototype.saveModelAndLink = function(from_entity, from_id, relationship) {
		//logit('/api?request=saveChanges&session_id='+thisUser.attrs.session_id+'&entity='+this.attrs.entity+'&id='+this.attrs.id+'&fieldname='+key+'&fieldvalue='+val+'&from_entity='+from_entity+'&from_id='+from_id+'&relationship='+relationship);
		var _this = this;
		
		var data = clone(this.attrs);
			data['request'] 		= 'saveChanges';
			data['session_id']		= thisUser.attrs.session_id;
			
			data['from_entity']	 	= from_entity;
			data['from_id'] 		= from_id;
			data['relationship'] 	= relationship;
			


		logit('SAVING CHANGES AND LINK');
		
	    for (var attr in data) {
	        logit( attr + '=' + data[attr]);
	    }
		logit('----------');
		
		$.getJSON('/api', data, function(server_data) {
					var entity = entityName[server_data.entity_id];
					var temp_id = server_data.temp_id; 	// passed from the server to help us find the right element...
					var id		= server_data.id; 		// The new id of the object in the database.

					// Find the element/s that represents this object
					if (temp_id && temp_id != null) {
						_this.attrs.id = server_data.id;
					}
			});
	
	}
	
	Model.prototype.saveModel = function(callback) {
		//logit('/api?request=saveChanges&session_id='+thisUser.attrs.session_id+'&entity='+this.attrs.entity+'&id='+this.attrs.id+'&fieldname='+key+'&fieldvalue='+val+'&from_entity='+from_entity+'&from_id='+from_id+'&relationship='+relationship);
		var _this = this;
		
		var data = clone(this.attrs);
			data['request'] 		= 'saveChanges';
			data['session_id']		= thisUser.attrs.session_id;
		
	    for (var attr in data) {
	        logit( ' --- ' + attr + '=' + data[attr]);
	    }
		
		$.getJSON('/api', data, function(server_data) {
					var entity = entityName[server_data.entity_id];
					var temp_id = server_data.temp_id; 	// passed from the server to help us find the right element...
					var id		= server_data.id; 		// The new id of the object in the database.

					// Find the element/s that represents this object
					
					
					if (temp_id && temp_id != null) {
						_this.attrs.id = server_data.id;
					}
					if (callback) {
						
						callback();
					}
					
			});
	
	}
	

	Model.prototype.addEventListener = function (viewController) {
		//logit('Model::addEventListener : ' + this.getKey() +' :: ' + viewController.toString());
		this.eventListeners[viewController] = viewController;
	}

	Model.prototype.getKey = function () {
		return this.attrs.entity +'_'+this.attrs.id;
	}
	
	
	Model.prototype.sendNotification = function (msg) {
		var key = this.getKey();
		//logit('Model::notify - ' + key + ' is broadcasting: ' +msg.type);
		var c = 0;
		$.each(this.eventListeners, function() {
			//logit('TO '+(c++)+':  - ' + this.toString());
			msg.key = key;
			this.notify(msg);
		});
	}
	
	
	Model.prototype.callIfIsLoggedIn = function(callback) {
		logit('getJSON * | * Model::callIfIsLoggedIn');
		$.getJSON('/api', 
			{request:'tickle', session_id:thisUser.attrs.session_id}, function(data) {
				if (data[0] && data[0].result && data[0].result == 'SUCCESS') {
					callback();
				} 
			});
	}
	
	
	Model.prototype.deleteFromDatabase = function() {		
		
		logit('really deleting model: ' + this.attrs.entity + ': ' + this.attrs.name);
		
		logit('getJSON * | * Model::deleteFromDatabase /api?request=deleteItemFromDatabase&session_id='+thisUser.attrs.session_id+'&entity='+this.attrs.entity+'&id='+this.attrs.id);
		
		$.getJSON('/api', 
			{'request':'deleteItemFromDatabase',  'session_id':thisUser.attrs.session_id, 'entity':this.attrs.entity, 'id':this.attrs.id},   
			function() {
				// notify
				
			});
		
	}








	
	
	/* *** SUBCLASSES *** */


	
		
	
// ! 
// ! *********** IMAGE *************** 
	ImageModel.prototype = new Model();
	ImageModel.prototype.constructor = ImageModel;

	function ImageModel(attrs) {
		this.attrs;
		this.eventListeners;
		this.relatedItems;
		
		this.init(attrs);
		this.attrs.slideUrl = this.getUrl();
	}
	ImageModel.prototype.getEntity = function(entity) {
		return "Image"
	}
	ImageModel.prototype.getUrl = function(size) { 		
		if (this.attrs.id < 30000) {																			// bourb image		
			// *** BOURB IMAGE
			var path;
			switch(this.attrs.element_type) {
				case "ca":
					path = 'capitals/50/';						break;
				case "pl":
					path = 'plans/genermont_rotated/small/';	break;
				case "pr":
					path = 'piers/80/';							break;
				case "cy":
					path = 'elevations/small/';					break;
				case "el":
					path = 'elevations/50/';					break;
				default:
					path = 'photos/pinky/';						break;
			}
			path = path + this.attrs.filename;	
			url = '/bourb/media/'+path;
		
		} else if (this.attrs.filesystem == 'B') { 	
			
			// *** FILESYSTEM B: web-uploaded images
			
			// make B filename for legacy filenames like old panos that need to hold their old filenames for old icons, etc.
			//var padded = this.attrs.id;
			//$folder1 = substr($padded,0,2);
			var B_filename = this.attrs.filename;
			if (this.attrs.image_type == "node") {
				// if it is an old node with a new B filesystem representation, use the orig_filename, ie, 05/32/53281
				B_filename = this.attrs.orig_filename;
			}
			if (size == 'full') {
				url = '/archmap/media/images/'+B_filename+'_full.'+mimeSuffixes[this.attrs.mimetype];					
			} else {
				url = '/archmap/media/images/'+B_filename+'_100.'+mimeSuffixes[this.attrs.mimetype]+'?ed'+this.attrs.editdate;					
			}
			
		} else { 
			// BUILDING IMAGES FROM LIGHTROOM										// *** mgf image base
			url = '/archmap/media/buildings/001000/'+this.attrs.building_id+'/images/100/'+this.attrs.filename;	
		}
		return url;
	}

	
	
// ! 
// ! *********** PUBLICATION *************** 
	Publication.prototype = new Model();
	Publication.prototype.constructor = Publication;

	function Publication(attrs) {
		this.attrs;
		this.eventListeners;
		this.relatedItems;

		this.init(attrs);
			
		// defaults
		if (! this.attrs.pubtype) this.attrs.pubtype = 6;

		logit("INSTANTIATING PUB - set pubtypeName for: "+this.attrs.pubtype);
		this.attrs.pubtypeName = this.getPubtypeName(); 
		logit("INSTANTIATING PUB - OK set pubtypeName for: "+this.attrs.pubtypeName);
	}
	Publication.prototype.getEntity = function(entity) {
		return "Publication";
	}
	Publication.prototype.setSubtypeName = function(subtypeName) {
		this.attrs.pubtypeName = subtypeName;
		switch(subtypeName) {
			case "Book":
				this.attrs.pubtype = 6;
				break;
			case "JournalArticle":
			case "Article":
				this.attrs.pubtype = 17;
				break;
			case "Chapter":
			case "BookSection":
				this.attrs.pubtype = 5;
				break;
			default:
				this.attrs.pubtype = 6;
		}
	}
	Publication.prototype.getPubtypeName = function() {
		
		logit("INSTANTIATING PUB - set pubtypeName for: "+this.attrs.pubtype);
		
		switch(parseInt(this.attrs.pubtype)) {
			case 6: 
				return "Book";
				break;
			case 17: 
				return "Article";
				break;
			case 5: 
				return "Chapter";
				break;
			default:
				return "Book";
		
		}
	}
	
	
	
	
	
	
// ! 
// ! *********** NOTE_CARD *************** 
	NoteCard.prototype = new Model();
	NoteCard.prototype.constructor = NoteCard;

	function NoteCard(attrs) {
		this.attrs;
		this.eventListeners;
		this.relatedItems;
		
		this.init(attrs);
		
		this.attrs.subtypeName = this.getSubtypeName(); 
	}
	NoteCard.prototype.getEntity = function(entity) {
		return "NoteCard"
	}
	NoteCard.prototype.getSubtypeName = function() {
		switch(this.attrs.subtype) {
			case 1: 
				return "Quote";
				break;
			case 2: 
				return "Paraphrase";
				break;
			case 3: 
				return "Summary";
				break;
			default:
				return "Note";
		
		}
	}
	
	


// ! 
// ! *********** ESSAY *************** 
	Essay.prototype = new Model();
	Essay.prototype.constructor = Essay;

	function Essay(attrs) {
		this.attrs;
		this.eventListeners;
		this.relatedItems;
		
		this.init(attrs);
		
		
		//this.attrs.subtypeName = this.getSubtypeName(); 
	}
	Essay.prototype.getEntity = function(entity) {
		return "Essay"
	}
	
	


// ! 
// ! *********** ESSAY *************** 
	Person.prototype = new Model();
	Person.prototype.constructor = Person;

	function Person(attrs) {
		this.attrs;
		this.eventListeners;
		this.relatedItems;
		
		this.init(attrs);
		
		
		//this.attrs.subtypeName = this.getSubtypeName(); 
	}
	Person.prototype.getEntity = function(entity) {
		return "Person"
	}
	
	


	
	
// ! 
// ! *********** BUILDING *************** 
	Building.prototype = new Model();
	Building.prototype.constructor = Building;

	function Building(attrs) {
		this.attrs;
		this.eventListeners;
		this.relatedItems;
		
		this.init(attrs);
		
		//if (! this.attrs.style && recent_Building_style) {
		//	this.attrs.style = recent_Building_style;
		//}
		this.attrs.entity 		= this.getEntity();
		this.attrs.subtypeName 	= this.getSubtypeName(); 
	}
	Building.prototype.getEntity = function(entity) {
		return "Building"
	}
	
	Building.prototype.mapIconUrl = function() {

		//logit('Building.mapIconUrl');

		if (! this.attrs.preservation) this.attrs.preservation = 3;

		if (! this.attrs.lat) {
			icon_url = '/archmap_2/media/ui/maps/mm_20_bluegray2.png';
		} else if (this.attrs.style == 12) {
			icon_url = '/archmap_2/media/ui/maps/map_icon_sm/map_icon_b_'+this.attrs.preservation+'_5.png';
		
		} else {
			icon_url = '/archmap_2/media/ui/maps/map_icon_sm/map_icon_'+this.attrs.preservation+'_5.png';
		
		}
		return icon_url;
	
	}

	Building.prototype.getSubtypeName = function() {
		/*
		switch(this.attrs.subtype) {
			case 1: 
				return "Quote";
				break;
			case 2: 
				return "Paraphrase";
				break;
			case 3: 
				return "Summary";
				break;
			default:
				return "Note";
		
		}
		*/
	}
	
	





















	

// ! 
// ! *********** COLLECTION *************** 
	Collection.prototype = new Model();
	Collection.prototype.constructor=Collection;


	function Collection() {
		this.init();
		
		this.items;
		
		this.selectedItems = new Array();;
		
		
	}


	Collection.prototype.size = function() {
   		var size = 0, key;
	    for (key in this.items) {
	        if (this.items.hasOwnProperty(key)) size++;
	    }
	    return size;
	};
	Collection.prototype.toString = function() {
		return 'Collection with '+ this.size() + ' items';
	}
	Collection.prototype.getKey = function() {
		// OVERRIDE - GIVE WHAT MAKES COLLECTION UNIQUE
	}
	
	Collection.prototype.loadItemsCount = function(from, step, orderby) {
		// OVERRIDE
	}
	Collection.prototype.loadItems = function(from, step, orderby) {
		// OVERRIDE
	}
	Collection.prototype.processItemsLoaded = function(_this, items) {
						
		_this.loading = false;
		
		if (! items) return;
		
		logit(this + " -- items.length = " + items.length); 

		var models = new Array();
		$.each(items, function() {
			var model;
			
			if (! this.entity) {
				this.entity = entityName[this.entity_id]
			}
			switch(this.entity) {
				case 'Image':
					model = new ImageModel(this);
					break;
				case 'Publication':
					model = new Publication(this);
					break;
				case 'NoteCard':
					model = new NoteCard(this);
					break;
				case 'Building':
					model = new Building(this);
					break;
				default:
					model = new Model(this);
			}
			model = dataStore.updateModel(model);
			_this.items[model.attrs.id] = model;
			
		});
		
		_this.sendNotification({type: 'collection_loaded', key: _this.getKey()});
	}

	Collection.prototype.addItem = function(model) {
		// OVERRIDE
	}
	Collection.prototype.removeItem = function(model) {
		// OVERRIDE
	}
	
	
	
	
// ! 
// ! *********** RELATED_ITEM_COLLECTION *************** 
	RelatedItemsCollection.prototype = new Collection();
	RelatedItemsCollection.prototype.constructor = RelatedItemsCollection;

	function RelatedItemsCollection(model, to_entity, relationship) {
		logit("new RelatedItemsCollection " + model.getEntity() + " :: " + to_entity + " - " + relationship);
		
		this.parent = model;
		
		this.init()
		
		this.attrs.from_entity 	= model.attrs.entity;
		this.attrs.from_id 		= model.attrs.id;
		this.attrs.to_entity 	= to_entity;
		this.attrs.relationship = relationship;
	
		this.attrs.count = 0;
		
		this.items;
		
		//logit('Collection:: constructor: to_entity=' +  to_entity + ', relationship=' + this.attrs.relationship)
	}
	
	RelatedItemsCollection.prototype.toString = function() {
		return this.parent.attrs.entity +': '+this.parent.attrs.name+' ['+this.attrs.to_entity+'-'+this.attrs.relationship+']';
	}
	RelatedItemsCollection.prototype.getKey = function() {
		return this.attrs.from_entity+'_'+this.attrs.from_id+'_'+this.attrs.to_entity+'_'+this.attrs.relationship;
	}


	RelatedItemsCollection.prototype.loadItemsCount = function() {
		logit('getJSON * | * Collection::loadItemsCount /api?request=getRelatedItemsCount&from_entity='+this.attrs.from_entity+'&from_id='+this.attrs.from_id+'&to_entity='+this.attrs.to_entity+'&relationship='+this.attrs.relationship);
		var _this = this;
		$.getJSON('/api', {
					'request':		'getRelatedItemsCount',  
						from_entity:	this.attrs.from_entity, 
						from_id:		this.attrs.from_id, 
						to_entity: 		this.attrs.to_entity, 
						relationship:	this.attrs.relationship,
					}, 		
					function(server_data) {
						//logit("_____HERE COUNT");
						_this.attrs.count = server_data.count;
						
						_this.sendNotification({type: 'collection_count_changed'});
						
					});
	}
		
	RelatedItemsCollection.prototype.loadItems = function(from, step, orderby) {
		logit('RelatedItemsCollection::loadItems()');
			
		if (this.items || this.loading) {
			this.sendNotification({type: 'collection_loaded'});
			return;
		}
		this.items = new Object();
	
		this.loading = true;
				
		if (! from) 	from = 0;
		if (! step) 	step = 20;
		if (! orderby)	orderby = "name";
		
		var _this = this;
		
		logit('getJSON * | * Collection::loadItems /api?request=getRelatedItems&from_entity='+this.attrs.from_entity+'&from_id='+this.attrs.from_id+'&to_entity='+this.attrs.to_entity+'&relationship='+this.attrs.relationship);
			
			$.getJSON('/api', {
					'request':		'getRelatedItems',  
						from_entity:	this.attrs.from_entity, 
						from_id:		this.attrs.from_id, 
						to_entity: 		this.attrs.to_entity, 
						relationship:	this.attrs.relationship,
						from:			from,
						step:			step,
						orderby: 		orderby						
					},  		
					function(server_data) {
						_this.processItemsLoaded(_this, server_data.items);
					});
	}
	
	RelatedItemsCollection.prototype.addItem = function(model) {
		var _this = this;
		
		logit('getJSON * | * Collection::addItem /api?request=addItemToList&session_id='+thisUser.attrs.session_id+'&from_entity='+this.attrs.from_entity+'&from_id='+this.attrs.from_id+'&to_entity='+this.attrs.to_entity+'&to_id='+model.attrs.id+'&relationship='+this.attrs.relationship);
		$.getJSON('/api/', 
			{request:'addItemToList',  'session_id':thisUser.attrs.session_id, from_entity:this.attrs.from_entity, from_id:this.attrs.from_id, to_entity:model.attrs.entity, to_id:model.attrs.id, relationship:this.attrs.relationship}, 
			function() {
				_this.attrs.count++;
				//_this.sendNotification({type: 'collection_count_changed'});
				_this.sendNotification({type: 'item_added', model: model});
				
			});
		
	}
	RelatedItemsCollection.prototype.removeItem = function(model) {
		var _this = this;

		$.getJSON('/api/', 
			{request:'removeItemFromList',  'session_id':thisUser.attrs.session_id, from_entity:this.attrs.from_entity, from_id:this.attrs.from_id, to_entity:model.attrs.entity, to_id:model.attrs.id, relationship:this.attrs.relationship}, 
			function() {
				_this.attrs.count--;
				_this.sendNotification({type: 'collection_count_changed'});

			});
	}
	
	
	
// ! 
// ! *********** SEARCH COLLECTION *************** 
	SearchCollection.prototype = new Collection();
	SearchCollection.prototype.constructor = SearchCollection;

	function SearchCollection() {
		
		this.criteria;
		this.items;
		
		this.eventListeners = new Object();
		
		logit('SearchCollection:: constructor');
	}
	SearchCollection.prototype.getKey = function() {
		return 'SEARCH_COLLECTION';
	}
	SearchCollection.prototype.toString = function() {
		return '[Search_Collection] ';
	}
	SearchCollection.prototype.setCriteria = function(obj) {
		this.criteria = obj;
	}
	SearchCollection.prototype.loadItemsCount = function() {
	}
	SearchCollection.prototype.loadItems = function(criteria, from, step, orderby) {
		if (criteria) {
			this.criteria = criteria;
		}
		

		this.items = new Object();
	
		this.loading = true;
				
		if (! from) 	from = 0;
		if (! step) 	step = 20;
		if (! orderby)	orderby = "name";
		
		var _this = this;
		
		
		logit('getJSON * | * Collection::search /api?request=search'); 
		
		for(var key in this.criteria) {
   			logit('search criteria: ' + key + ' = ' + this.criteria[key]);
		}
		
		logit('SearchCollection.loadItems: sending to /api: ' +  this.criteria)
		
		this.criteria['request'] = 'search';
		$.getJSON('/api', this.criteria, function(server_data) {
					logit('GOT DATA FOR SEARCH!!!!! ===' + server_data +'====');
					_this.processItemsLoaded(_this, server_data);
				});
	}
	
	
	
	
// ! 
// ! *********** WORLDCAT_SEARCH_COLLECTION *************** 
	WorldcatSearchCollection.prototype = new Collection();
	WorldcatSearchCollection.prototype.constructor = WorldcatSearchCollection;

	function WorldcatSearchCollection() {
		
		this.criteria;
		this.items;
		
		this.eventListeners = new Object();
		
		
		logit('WorldcatSearchCollection:: constructor');
	}
	WorldcatSearchCollection.prototype.getKey = function() {
		return 'WORLDCAT_SEARCH_COLLECTION';
	}
	
	WorldcatSearchCollection.prototype.toString = function() {
		return '[WorlcatSearch_Collection] ';
	}
	
	WorldcatSearchCollection.prototype.setCriteria = function(obj) {
		this.criteria = obj;
	}
	WorldcatSearchCollection.prototype.loadItemsCount = function() {
	}
	WorldcatSearchCollection.prototype.loadItems = function(from, step, orderby) {
		this.items = new Object();
		this.loading = true;
				
		if (! from) 	from = 0;
		if (! step) 	step = 20;
		if (! orderby)	orderby = "name";
		
		var _this = this;
		
		this.criteria['request'] = 'searchWorldCat';
		
		logit('get * | * WorldcatSearchCollection::search'); 
		$.get('/api', this.criteria, function(data) {
	  			
	  			var results = new Array();
	  			
	  			$.each( $(data).find(".menuElem"), function() {
  					var expr;
  					
  					// MAP FROM THE WORLDCAT DOM
  					var pub 			= new Object();
  						
  						pub.entity		= "Publication";

	  					pub.name 		= $(this).find(".name").find("strong").text();
	  					pub.coverartUrl = $(this).find(".coverart").html();
	  					pub.contributors = $(this).find(".author").text().replace("by ", "");
						pub.OCLC		= $(this).find(".oclc_number").text();
						pub.pubtypeName	= $(this).find(".itemType").text();
						
						if (! pub.pubtypeName) pub.pubtypeName = "Book";
						pub.pubtype		= pubtypes[pub.pubtypeName];
						
						if (pub.pubtypeName == "Article") {
							//<div class="type">Publication: Bulletin (British Society for Middle Eastern Studies) 1987, vol. 14, no. 2, p. 198-202</div>
							//<div class="type database">Database: <span class="itemDatabase">JSTOR</span>						
							
							var journalinfo = $(this).find(".type:not(.language):not(.database)").text();
														
							var j_parts = journalinfo.split(', ');
							
							var part_ct = 0;
							pub.publisher 	= $.trim(j_parts[part_ct++].replace("ArticlePublication: ", ""));
							pub.date 		= $.trim(j_parts[part_ct++]);
							
							exper = /\d\d\d\d/;
							if (! exper.test(pub.date)) {
								pub.date 		= $.trim(j_parts[part_ct++]);
							}
							pub.volume 		= $.trim(j_parts[part_ct++]);
							pub.number 		= $.trim(j_parts[part_ct++]);
							pub.pages 		= $.trim(j_parts[part_ct++]);
						} else {
							publisherString = $(this).find(".itemPublisher").text();
							if(publisherString) {
							
								publisherString 	= publisherString.replace("©", "yubba");
	
								expr 		= /\d\d\d\d/;
								var dateArray 	= expr.exec(publisherString);
								
								if (dateArray)
									pub.date = dateArray[0];
								
								expr 		= /.\d\d\d\d/g;	
								publisherString 	= publisherString.replace(expr, "");
								
								expr 		= /, \./g;	
								publisherString 	= publisherString.replace(expr, "");
								
								expr 		= /,\./g;	
								publisherString 	= publisherString.replace(expr, "");
	
								expr 		= /(\[|\])/g;	
								publisherString 	= publisherString.replace(expr, "");
	
	
								publisherParts  = publisherString.split(':');
								
								pub.location	= $.trim(publisherParts[0]);
								pub.publisher	= $.trim(publisherParts[1]);
							}
						}
						results.push(pub);			
  				});
 				logit('[WorldcatSearchCollection::loadItems]: ' + results.length);
 				_this.processItemsLoaded(_this, results);
			});

	}
	
	
	
	




// ! 
// ! *********** TRASH *************** 

