
// ! 
// ! *********** VIEW (BASE CLASS) *************** 
	// a View has a model associated with it as a data provider.
	
	
	function View(model, parentView) {
	
	
		this.model = model;
		this.element = $("<div></div>");

		this.subview;
		this.subtype;
		
		this.parentView = parentView;
		
		this.suggestionView;
		
		this.templateName;
		

		this.pathroot = "/templates/";

		this.suggestionsOpen = false;
		
		this.process();
				
	}
	
	View.prototype.process = function() {
		var _this = this;
		// if a subclass wants to use a template, it will define a templateName in its constructor
		
		// I encountered a really strange bug…
		// caching a profile with a map, on second instantiation, jQuery or google.map could not get a width from it.
		// so the work-around is to reload from the server the template. This is cray but true. Yuck!!!!
		var is_a_ProfileTemplateWithMap = (this.templateName && this.templateName.indexOf("Profile_View") != -1);
		var or_a_smalleViewWithNoMapButNotYetLoaded = (! templates[this.templateName]);
		
		if (this.templateName && ( is_a_ProfileTemplateWithMap || ! templates[this.templateName] )) {
				// Not loaded yet grab template file from the /templates folder
				
				logit('downloading template: ' + this.pathroot+this.templateName+'.html');
				
				$.post(this.pathroot+this.templateName+'.html', {componentOnly:"true", id:this.model.attrs.id}, function(data) {
					templates[_this.templateName] = data;
					
					_this.processElement(templates[this.templateName]);
				});
		} else {
			this.processElement();
		}
	}
	View.prototype.processElement = function() {
				
		if (this.templateName && templates[this.templateName]) {
			
			var tmpl = templates[this.templateName]+" " ;
			
			var tmpEl;
			if (this.model) {
				$.template( this.templateName, templates[this.templateName] );
				tmpEl = $.tmpl( this.templateName, this.model.attrs );
				//var tmpEl = $(templates[this.templateName]);
			
			} else {
				tmpEl = $(templates[this.templateName]);
			}
			
			// ATTACH to DOM
			this.element.append(tmpEl);
		
		} else {
			// element is already in the DOM
			//tmpEl = this.constructElement();
		}
		
		// ADD INTERACTIVITY
		this.addInteractivity(tmpEl);
		
		
		var _this = this;
		
		// RELATED ITEMS (COLLECTIONS) [specified in the template]
		var relatedItems = this.element.find('div.related-items');
			$.each(relatedItems, function() {
				var to_entity 		= getClassItemWithPrefix($(this), 'entity-');
				var to_relationship = getClassItemWithPrefix($(this), 'relationship-');
				var view			= getClassItemWithPrefix($(this), 'view-');
				var subview			= getClassItemWithPrefix($(this), 'subview-');
				var subtype			= getClassItemWithPrefix($(this), 'subtype-');
				
				logit(' setting subview: ' + subview);
				
				var collection = _this.model.getRelatedItems(to_entity, to_relationship);
				var cmd = 'new '+view+'(collection, $(this));';
				var collectionView = eval(cmd);
				
				if (subview) {
					collectionView.subview = subview;
				}
				if (subtype) {
					collectionView.subtype = subtype;
				}
				if ($(this).hasClass('load-data')) {
					collection.loadItems();
				}
			});
			 
			 
		// MAPS	 [specified in the template]
		var mapElements = this.element.find('div.map-view');
			mapElements.each(function() {
			//	logit("MAP FOUND!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! " + $(this).width());
			//	logit("MAP FOUND! " + $(this).html());
				
				var mapController = new Map_View(_this.model, $(this));
				//mapController.resize();
					mapController.addCollection(_this.model.getRelatedItems('Building'));
					mapController.addCollection(_this.model.getRelatedItems('Image', 'map'));
			
			});
			

	}
	View.prototype.constructElement = function() {
		// override
		
		// this function allows the view to write html from scratch rather than use a template
	}
	View.prototype.addInteractivity = function() {
		// override
		//logit('STUB: addinteractivity');
		// this function in subclasses will have knowledge of the template and the
		// elements with in it that should be clickable, etc.
	}
	View.prototype.addInteractivityOnDom = function() {
		// override
		
		// this function in subclasses will have knowledge of the template and the
		// elements with in it that should be clickable, etc.
	}
	View.prototype.update = function() {
		// override
		
		// this function in subclasses will have knowledge of the template and the
		// elements with in it that should be clickable, etc.
	}

	View.prototype.activateInputFieldEditing = function(element) {
		

		if( element.find('input').length ) return; 			// --	ALREADY EDITING
				
		var _this = this;
		var fieldname = getClassItemWithPrefix(element, 'fieldname-');



		// SUPPORT SUGGEST_REPLACE
		// The parent view is orgaizing the model this view is representing
		var isSuggestReplace = element.hasClass('suggest-replace');
		if (isSuggestReplace) {
			var localSearchCollection 	= new SearchCollection();						// THE MODEL VIEW
			var localSuggestionsView 	= new SearchCollection_View(localSearchCollection, this.parentView);
				localSuggestionsView.itemSelectionMode = "SUGGEST_REPLACE";
			
		}
		
				
		var defaultName = "New " + this.model.getEntity();


		var inputEl = $("<input value='"+element.html().replace(/\'/g, '&#39;')+"' />");
			inputEl.data('view', this);
			inputEl.data('fieldname', fieldname);
			
		element.html(inputEl);
		inputEl.focus().select();
		
		
		inputEl.blur(function() {
			
			if (_this.suggestionsOpen > 0) {
			
			} else {
				if (_this.activeInputElement == $(this)){
					_this.activeInputElement = null;
				}	
				if (fieldname == "name" && $(this).val() == defaultName) {
					_this.element.remove();						// -- 	CANCEL
					dataStore.removeModel(_this.model);
				} else {
					// SAVE
					_this.saveEdit(fieldname, $(this).val());	// --	SAVE
					element.html( $(this).val() );
				}
			}
		})
		.focus(function() {
				_this.activeInputElement = $(this);
				if (this.value == defaultName) $(this).select();
			})

// !   *** keydown

		.keydown(function (e) {
	 			var keyCode = e.keyCode || e.which;			 

				if (e.which == '13') {
					_this.noSuggestions();
					$(this).blur();		
				}
				
				var _fieldEl = $(this);
				
				
				if (isSuggestReplace) {
					
					
					
					if (window.localSuggestTimeout) 
						clearTimeout(window.localSuggestTimeout);
					
					// this executes everytime there is a pause in typing					
					
					window.localSuggestTimeout = setTimeout(function() {
						
						if (! _fieldEl.val() || "-"+_fieldEl.val() == "-") {
							_this.noSuggestions();
							return;
						} 							
						
						localSearchCollection.loadItems({'entity': _this.model.getEntity(), 'fieldname': 'name', 'searchString': _fieldEl.val()});
						
						var inputElement = $(document.activeElement);
						
						if (inputElement.length > 0 && inputElement.is('input')) {
							var pos 	= inputElement.offset();
							_this.suggestionsOpen = true;
							var suggestionsPanel =  $('<div class="suggestionsPanel"></div>').addClass("suggestionChoices").css("left",  pos.left).css("top", pos.top+20);
							$('body').append(suggestionsPanel);
							suggestionsPanel.append(localSuggestionsView.element);
						} else {
							_this.noSuggestions();
						}
						
					}, 500);
				}

			})
		.keyup(this.inputKeyup);
				
	}	
	
	
	
	
	
	View.prototype.onSuggestionViewClick = function(collection, model) {
		logit('View.prototype.onSuggestionViewClick');
		$('.suggestionsPanel').remove();
	}
	View.prototype.noSuggestions = function(collection, model) {
		this.suggestionsOpen = false;
		$('.suggestionsPanel').remove();
	}
		

	
	
	View.prototype.activateTextAreaEditing = function(element) {
				
		if( element.find('textarea').length ) return; // already editing
					

		var fieldname = getClassItemWithPrefix(element, 'fieldname-');

		var content;
			content = element.html().replace(/<br>/gi, "\n");
		
		
		var textareaEl = $('<textarea>'+content+'</textarea>');
			textareaEl.data('view', this);
			textareaEl.data('fieldname', fieldname);
		
		element.html(textareaEl);
		textareaEl.focus().select();
		
		textareaEl.animate({'height': 300}, 500);
		
		var _this = this;
		
		textareaEl.blur(function() {
			// save
			var fieldname = getClassItemWithPrefix(element, 'fieldname-');
			var val = $(this).html();
			_this.saveEdit(fieldname, $(this).val());
			element.html( $(this).val().replace(/\n/g, "<br>") );
			
			// if no other elements in focus, create new note
			var inputs = element.find('input');
			var tareas = element.find('textarea');
			if (  (! inputs || inputs.length == 0 ) && (! tareas || tareas.length == 0 ) ) {
				// addmodel_this.parentView.addNewModel();
			}
		});
		
		textareaEl.focus(function() {
			$(this).select();
		});
	}
	
	View.prototype.activateEditing = function(event) {
		//alert('hook up behavior of editing fields');
		var _view = this;
		this.element.find('.inputfield').each( function(){
			logit(' - - - - -* ! *! *! *! *! *! *! *! *! *! *! *! -}}}}}}}}}}}}}-> found input field' + $(this).html());
			var _this = $(this);
			$(this).click(function(){
				_view.activateInputFieldEditing(_this);
			});
		});
		this.element.find('.textarea').each( function(){
			var _this = $(this);
			$(this).click(function(){
				_view.activateTextAreaEditing(_this);
			});
		});
	}
	
	View.prototype.inputKeyup = function(event) {
		// override in subclasses
		
		event.preventDefault();
		
		var view 		= $(this).data('view');
		var entity 		= view.model.attrs.entity;
		var fieldname 	= $(this).data('fieldname');
		
		if (entity == "Publication" && fieldname == "name") {
			// put auto-suggest code here....	
			
			logit('IS SUGGESTIBLE-REPLACIBLE ');
			//view.delayedSuggestion();
		}

	}
	
	View.prototype.delayedSuggestion = function(view) {
		if (window.suggestTimeout)
			clearTimeout(window.suggestTimeout);
		window.suggestTimeout = setTimeout(this.getSuggestions(view), 500);
	}
	View.prototype.getSuggestions = function(thisView) {
		var activeEl 		= $(document.activeElement);

		var view 		= activeEl.data('view');
		var entity 		= view.model.attrs.entity;
		var fieldname 	= activeEl.data('fieldname');

		var _this = this;

		
		var searchCollection 	= new SearchCollection(entity, fieldname, activeEl.val());
		
		if(! this.suggestionView) {
			this.suggestionView 		= new SearchCollection_View(searchCollection, view);
		}
		//this.suggestionView.parentView = view;
		
		suggestionView.element.dialog();
		searchCollection.loadItems();
		
		
		
			
	}
	
	

	View.prototype.saveEdit = function(fieldname, val) {
		this.model.attrs[fieldname] = val;
		
		logit('View.saveEdit:: '+ fieldname+", "+val);
		
		if(this.model.isNew()) {
			var collection = this.parentView.model;
			
			this.model.saveAndLink(collection.attrs.from_entity, collection.attrs.from_id, collection.attrs.relationship );
		} else {
			
			switch(fieldname) {
				case "catnum":
				case "pages":
				case "pos_x":
				case "pos_y":
				case "pos_z":
				case "sortval":
				case "axis":
				case "ang":
				
					// field relates to the relationship with the parent
					if (this.parentView) {
						var collection = this.parentView.model;
						this.model.saveRelationValue(fieldname, val, collection.attrs.from_entity, collection.attrs.from_id, collection.attrs.relationship  )
					}
					
					break;
				
				default:
					this.model.saveValue(fieldname, val);
			}
			
		}

	}


	/* *** SUBCLASSES *** */
	

// ! 
// ! *********** LIBRARY_VIEW ************************
//	Meant to be a way of selecting, importing and assigning publications
//	Should be a modal dialog.	
	Library_View.prototype 				= new View();
	Library_View.prototype.constructor 	= Library_View;
	
	function Library_View(pubtype) {

		//this.model = model;
		//model.addEventListener(this);
		
		//this.parentView = parentView;
		this.element = $('<div class="library"></div>');
		this.element.data('viewController', this);
		
		this.requestingView;

		this.templateName = "Library_View";
		this.process();
		
		var _this = this;
		
		var criteria;
		
		this.pubtype = pubtype;
		
		this.modelBeingEdited = new Publication();
		
		// LIVE SEARCH DISPLAYS
		this.remoteSearchCollection = new WorldcatSearchCollection();		
		this.remoteSuggestionsView 	= new SearchCollection_View(this.remoteSearchCollection, this);
		this.element.find('.remoteSearch').append(this.remoteSuggestionsView.element);
		
		this.localSearchCollection 	= new SearchCollection();
		this.localSuggestionsView 	= new SearchCollection_View(this.localSearchCollection, this);
		this.element.find('.localSearch').append(this.localSuggestionsView.element);
		
		// LIVE SEARCH EVENTS
		this.element.find('input.live-search').keyup( function(event) {
				event.preventDefault();
				logit('[Library_View]: keyup! ' + $(event.target).attr('name'));
				switch($(event.target).attr('name')) {
					case "search":
					case "name":
					case "contributors":
						// full suggestions for "switch-to"
						logit(' * * * * * * ** !');
						_this.getLocalSuggestions();
						_this.getRemoteSuggestions();
						break;
						
					case "publisher":
					case "location":
						// dropdown suggestions for "replace"
						break;
				}
			});


		// PUBLICATION FORM
		this.searchField 		= this.element.find('input:[name="search"]');
		this.nameField 			= this.element.find('input:[name="name"]');
		this.contributorsField 		= this.element.find('input:[name="contributors"]');
		this.keywordsField 		= this.element.find('input:[name="keywords"]');
		this.publisherField 	= this.element.find('input:[name="publisher"]');
		this.locationField 		= this.element.find('input:[name="location"]');
		this.dateField 			= this.element.find('input:[name="date"]');
		this.OCLCField 			= this.element.find('input:[name="OCLC"]');
		this.ISBNField 			= this.element.find('input:[name="ISBN"]');
		this.volumeField 		= this.element.find('input:[name="volume"]');
		this.numberField 		= this.element.find('input:[name="number"]');
		this.pagesField 		= this.element.find('input:[name="pages"]');
		
		this.isCatalogCheckbox 		= this.element.find('input:[name="isCatalog"]');
		
		this.pubtypeNameSelect = this.element.find('select:[name="pubtypeName"]');

		this.editButtonsPanel 	= this.element.find('#edit_buttons_panel');
		
		this.isCatalogCheckbox.change(function () {
			
			if (_this.modelBeingEdited) {
				if (_this.isCatalogCheckbox.val() == "on") {
					_this.modelBeingEdited.attrs.isCatalog = 1;
				} else {
					_this.modelBeingEdited.attrs.isCatalog = 0;
				}
			}
		});
		

		if (pubtype) {
		
			this.setPubtype(pubtype)
		}
		
				
		// ! EDIT BUTTON  FUNCTIONALITY
		this.editButtonsPanel.find('#save').click(function() {
			_this.editButtonsPanel.hide('fade');
			
			_this.revertFormToSearchCriteria();
			// and save to db and add to requesting collection….
			
			if (_this.requestingView && _this.requestingView.model) {
				
				
				//logit('ready to saveModel! ' + _this.modelBeingEdited.attrs.date);
				
				//_this.modelBeingEdited.saveModelAndLink(_this.requestingView.model.attrs.from_entity, _this.requestingView.model.attrs.from_id, _this.requestingView.model.attrs.relationship);
				//_this.requestingView.addModel(_this.modelBeingEdited);
				
				_this.modelBeingEdited.saveModel(function() {
					_this.requestingView.addModel(_this.modelBeingEdited);
				});
				
			
			} else {
				_this.modelBeingEdited.saveModelAndLink();
			}
		});
		//this.editButtonsPanel.hide();
		
		
	}
	Library_View.prototype.setRequestingView = function(view) {
		this.requestingView = view;
		logit('* * * * * * * * * * * * * * * * * * setting requesting view to: ' + this.requestingView);
	}
	
	Library_View.prototype.getLocalSuggestions = function() {
		var _this = this;
		if (window.libraryLocalSuggestTimeout) 
			clearTimeout(window.libraryLocalSuggestTimeout);
		
		// this executes everytime there is a pause in typing
		window.libraryLocalSuggestTimeout = setTimeout(function() {

			_this.setSearchCriteriaFromForm();
			_this.localSearchCollection.setCriteria(_this.criteria);
			_this.localSearchCollection.loadItems();
			
		}, 500);
	}

	Library_View.prototype.getRemoteSuggestions = function() {
		var _this = this;
		if (window.libraryRemoteSuggestTimeout) 
			clearTimeout(window.libraryRemoteSuggestTimeout);
		
		// this executes everytime there is a pause in typing
		window.libraryRemoteSuggestTimeout = setTimeout(function() {
			_this.setSearchCriteriaFromForm();
			_this.remoteSearchCollection.setCriteria(_this.criteria);
			_this.remoteSearchCollection.loadItems();
		}, 3000);
	}
	
	Library_View.prototype.setPubtype = function(pubtype) {
		
		alert('setting to: ' + pubtype);

		this.pubtypeNameSelect.val(pubtype);
		
	}
	Library_View.prototype.setSearchCriteriaFromForm = function(collection, model) {
			
		this.criteria = new Object();
		
		this.criteria['entity']  = 'Publication';
		
		if (this.searchField.val()) 	this.criteria['search'] 	= this.searchField.val();
		if (this.nameField.val()) 		this.criteria['name'] 		= this.nameField.val();
		if (this.contributorsField.val()) 	this.criteria['contributors'] 	= this.contributorsField.val();
		if (this.keywordsField.val()) 	this.criteria['keywords'] 	= this.keywordsField.val();
		
		if (this.pubtypeNameSelect.val() != "None Specified") 
										this.criteria['pubtypeName'] = this.pubtypeNameSelect.val();
		return this.criteria;
	}
	Library_View.prototype.revertFormToSearchCriteria = function(collection, model) {
		
				
		this.searchField.val(this.criteria['search']);
		this.nameField.val(this.criteria['name']);
		this.contributorsField.val(this.criteria['contributors']);
		this.keywordsField.val(this.criteria['keywords']);
		
		this.pubtypeNameSelect.val(this.criteria['pubtypeName']);
		
	}
	Library_View.prototype.onSuggestionViewClick = function(collection, model) {
		
		if (collection.getKey() == "SEARCH_COLLECTION") {
			// add to launching collection
			this.requestingView.addModel(model);
			closeLibraryService();
			
		} else if (collection.getKey() == "WORLDCAT_SEARCH_COLLECTION") {
		
			this.modelBeingEdited = model;
			
			
			
			// populate form
			this.nameField.val(model.attrs.name);
			this.contributorsField.val(model.attrs.contributors);
			this.publisherField.val(model.attrs.publisher);
			this.locationField.val(model.attrs.location);
			this.dateField.val(model.attrs.date);
			this.OCLCField.val(model.attrs.OCLC);
			
			this.volumeField.val(model.attrs.volume);
			this.numberField.val(model.attrs.number);
			this.pagesField.val(model.attrs.pages);
			
			this.pubtypeNameSelect.val(model.attrs.pubtypeName);
			
			this.editButtonsPanel.show('fade');
			
		}
	} 
	












// ! 
// ! *********** SEARCH_COLLECTION_VIEW *************
	SearchBox_View.prototype 				= new View();
	SearchBox_View.prototype.constructor 	= SearchBox_View;

	function SearchBox_View(parentView) {
		this.element = $('<div class="searchbox-view"><input class="live-search" /></div>');


		var _this = this;

		// LIVE SEARCH EVENTS
		this.element.find('input.live-search').keyup( function(event) {
				event.preventDefault();
				logit('[SearchBox_View]: keyup! ' + $(this).val());
				
				var _fieldEl = $(this);
				
				if (! _fieldEl.val() || "-"+_fieldEl.val() == "-") {
					_this.noSuggestions();
				}

				
			var localSearchCollection 	= new SearchCollection();						// THE MODEL VIEW
			var localSuggestionsView 	= new SearchCollection_View(localSearchCollection, _this);
				localSuggestionsView.itemSelectionMode = "SUGGEST_REPLACE";



				if (window.headerSearchSuggestTimeout) 
					clearTimeout(window.headerSearchSuggestTimeout);
				
				// this executes everytime there is a pause in typing					
				
				window.headerSearchSuggestTimeout = setTimeout(function() {
					
					logit(_fieldEl.val());
					
					if (! _fieldEl.val() || "-"+_fieldEl.val() == "-") {
						logit("NO SUGGESTIONS!!!!!");
						_this.noSuggestions();
						return;
					} 							
					
					localSearchCollection.loadItems({'entity': 'Building', 'fieldname': 'name', 'searchString': _fieldEl.val()});
					
					var inputElement = $(document.activeElement);
					
					if (inputElement.length > 0 && inputElement.is('input')) {
						var pos 	= inputElement.offset();
						_this.suggestionsOpen = true;
						
						_this.noSuggestions();

						var suggestionsPanel =  $('<div class="suggestionsPanel"></div>').addClass("suggestionChoices").css("left",  pos.left).css("top", pos.top+20);
						$('body').append(suggestionsPanel);
						suggestionsPanel.append(localSuggestionsView.element);
					} else {
						_this.noSuggestions();
					}
					
				}, 500);
			});



	}
	
	SearchBox_View.prototype.toString = function() {
		return "SearchBox_View :: "; 
	}

	SearchBox_View.prototype.onSuggestionViewClick = function(collection, model) {
			logit('name - ' + model.attrs['name']);
		this.element.find('input.live-search').val("");
		$('.suggestionsPanel').remove();
		request_ProfileView(model.entity, model.attrs.id);
	
	}




// ! 
// ! *********** SEARCH_COLLECTION_VIEW *************
	SearchCollection_View.prototype 				= new View();
	SearchCollection_View.prototype.constructor 	= SearchCollection_View;

	function SearchCollection_View(collection, parentView) {
		this.model 		= collection;
		collection.addEventListener(this);

		this.parentView = parentView;
		
		this.ul = $('<ul class="search-ul"></ul>');
		this.element = $('<div class="entity-Publication"></div>');
		this.element.append(this.ul);
		
		this.itemSelectionMode = "SELECT"; // also: SUGGEST_REPLACE, SUGGEST_FILLFIELD
		
		this.clickCallback;
	}
	
	SearchCollection_View.prototype.toString = function() {
		return "SearchCollection_View :: " + this.model.getKey(); 
	}
	SearchCollection_View.prototype.setCollection = function(collection) {
		this.model 		= collection;
		collection.addEventListener(this);
	}	
	SearchCollection_View.prototype.notify = function(msg) {
				logit('[SearchCollection_View::notiy]: '+msg.type);

		switch(msg.type) {
		
			case 'collection_loaded':
				logit('[SearchCollection_View::notiy]: collection_loaded!');
				this.ul.find('.loading-wheel').remove();
				this.renderCollection();
				break;
		
		}
	}
	
	SearchCollection_View.prototype.renderCollection = function() {
		//this view does not use an html template file
		
		logit('[SearchCollection_View::renderCollection()] ');
		
		var _this = this;
		
		this.ul.empty();
		
		logit(this + ':  collection size = ' + this.model.size());
		
		var count = 0;
		$.each(this.model.items, function(){
			 var modelView = _this.addModelView(this, _this);
			 count++;
		});
		if (count == 0) {
			this.parentView.noSuggestions();
		}
		
		
	}
	
	SearchCollection_View.prototype.addModelView  = function(model) {
		// CREATE A CONTROLLER FOR EACH ITEM IN THE LIST
		// This could be made more efficient by having one controller 
		// to manage all the items.
		
		var modelView;

		var _this = this;


		// LATER - identify view to call in template
		switch(model.attrs.entity) {
			case "Image":
				modelView = new ImageSlide_View(model, this);
				break;
			case "Publication":
				modelView = new Publication_View(model, this);
				break;
			case "NoteCard":
				modelView = new NoteCard_View(model, this);
				break;
			case "Building":
				modelView = new Building_Short_View(model, this);
				break;
				
			default:
				modelView = new Model_View(model, this);
		}
		
		// ATTACH TO DOM
		
		var _this = this;
		
		this.ul.append(modelView.element);
		
		// SELECTION SUPPORT
		modelView.element.mousedown(function() {  
			
			var searchCollection = _this.model;
			
			if (_this.parentView) {
				//
				_this.parentView.onSuggestionViewClick(searchCollection, model);
			}
			
			/*
			switch ( this.itemSelectionMode ) {
			
				case 'SUGGEST_REPLACE':
					if (_this.parentView) {
						// assume the parent view is a model view (usually a "New Model" form
						_this.parentView.setModel(model);
					}
					
				
					break;
					
				default:
			
			
			}
			*/
			
			//_this.clickCallback(modelView.model);
			
			/*
			_this.element.remove();
		 	
			var modelViewInCollection 		= _this.parentView;
		 	modelViewInCollection.suggestionView = null;

			var collectionView 	= modelViewInCollection.parentView;
			collectionView.replaceViewWith(modelViewInCollection, model);
			*/
			
		});
		
		/*
		// HIGLIGHT SUPPORT
		modelView.element.dblclick(function() {
			request_ProfileView(model.entity, model.attrs.id);
		});
		
		modelView.element.mouseover(function() {model.sendNotification({type: 'highlight'});});
		modelView.element.mouseout(function() {model.sendNotification({type: 'unhighlight'});});



		 modelView.element.mousedown(function() {  $(this).addClass('ui-selecting');  });
		 modelView.element.mouseup(function() {  _this.ul.find('.ui-selecting').removeClass('ui-selecting');  });



		
		
		
		modelView.element.mouseenter(function() {
		});
		modelView.element.mouseleave(function() {
			
		});
		*/
		return modelView;
		
	
	}






	
	
// ! 
// ! *********** LABELLED_LIST_VIEW *************
	LabelledList_View.prototype 				= new View();
	LabelledList_View.prototype.constructor 	= LabelledList_View;

	function LabelledList_View(collection, element) {
		// can be opened or closed at beginning
		// can use various templates
		
		this.model 		= collection;
		this.element 	= element;
		
		this.targetHeight = 470;
		
		this.indexOfMovedItem;
		
		collection.addEventListener(this);
		
		this.element.data('viewController', this);
		
		
		// UL
		this.ul = this.element.find('ul');
		
		var tmptargetHeight = this.ul.css('height');
		
		logit("tmptargetHeight = " + tmptargetHeight);
		if (tmptargetHeight != "0px") {
			this.targetHeight = tmptargetHeight;
		}
		this.ul.css('height', 0);
		this.ul.css('opacity', .25);
		
		
		// LABEL
		this.label = this.element.find('.list-label');
		if (this.label) {
			this.model.loadItemsCount();
			if (this.label.hasClass('open')) {
				this.open();
			}
			
			switch(this.model.attrs.to_entity) {
				case "Publication":
				case "NoteCard":
				case "Building":
				case "Essay":
					this.label.after('<span class="add-button">+</span>');
					
			}
			
			// this.label
		}
		this.label.click(function() {
		
			_this.toggle();
			
			if (_this.model.size() > 0) {
			
			} else {
				
				_this.model.loadItems();    // ***************** CALL TO SERVER
			}
			//$(this).unbind('click');
		});
		this.labelCount = this.label.find('.count');
		
		
		
		this.process();
		
		var _this = this;

		if (this.element.hasClass('open')) {
			this.open();
		}
		
		// ! ADD_BUTTON
		this.addButton = this.element.find('.add-button');
		this.addButton.click( function() {
			//alert('add one!');
			
			if (! _this.label.hasClass('open')) {
				_this.open();
			}
			
			if (_this.model.attrs.to_entity == "Publication") {
				if (_this.model.attrs.relationship == "child") {
					
					_this.addNewModel("Chapter");
				} else {
					openLibraryService(_this);
				}
				
				
			} else {
				_this.addNewModel();
			}
			
			
		});
		
		
		var accept = '.entity-'+_this.model.attrs.to_entity;

		accept = function(draggable) {
			var ident = getIdent($(draggable));
			if ( $(this).find('.model_id-'+ident.id).length > 0) return false;
			if ($(draggable).hasClass('entity-'+_this.model.attrs.to_entity) && ! $(draggable).hasClass('model_id-'+_this.model.parent.attrs.id)) return true;
			return false;
		}
		
		
		this.element.droppable({
			hoverClass: 'activeOnWhite', 	
			activeClass: 'highlightOnWhite',
			accept: accept,
			over: function(event, ui) {
				var from_ident = getIdent($(event.target));
				var to_ident = getIdent($(ui.draggable));
				
				
				var from_model = _this.model;
				var to_model = $(ui.draggable).viewController;
				
				logit ('$(ui.draggable).viewController='+$(ui.draggable).viewController);
				//logit("-> " + to_ident.entity + '::'+ to_ident.id);
				//logit("--> is over me! "+ $(event.target).attr('class'));
				
				//logit("-> " + to_model.attrs.entity + '::'+ to_model.attrs.id);
				logit("--> is over me! "+ from_model.attrs.name  );
				
			},
			out: function(event, ui) {
				logit("someone is left me! "+ $(event.target).attr('class'));
				
			},
			drop: function(event, ui) {
				logit("DROPPED: ...");
				var from_ident = getIdent($(event.target));
				var to_ident = getIdent($(ui.draggable));
				var model = dataStore.getModel(to_ident.entity, to_ident.id) ;
				
				logit("DROPPED: " + to_ident.entity + '. ' + to_ident.id + ' model: ' + model.attrs.filename);
				_this.model.addItem(model);
				_this.addModelView(model);
				logit('/archmap2/api?request=addItemToList&session_id='+thisUser.attrs.session_id+'&from_entity='+from_ident.entity+'&from_id='+from_ident.id+'&to_entity='+to_ident.entity+'&to_id='+to_ident.id+'&relationship='+from_ident.relationship);
				
			}
		});
		
		
		//this.element.sortable();
		
		

	}
	
	LabelledList_View.prototype.toString = function() {
		return "LabelledList_View :: " + this.model.getKey(); 
	}
	LabelledList_View.prototype.addInteractivity = function() {
		var _this = this;
	}
	LabelledList_View.prototype.open = function() {
		this.label.addClass('open');
		
		
		this.ul.animate({
		    opacity: 1,
		    height: this.targetHeight,
		  }, 1000, function() {
		    // Animation complete.
		  });

		// alter this for staged loading of next 25, etc.
		
		
		if (this.model.size() > 0) {
			
		} else {
			this.ul.append('<div class="loading-wheel"><img src="/media/ui/loading.gif" /><div>');
			this.model.loadItems();    // ***************** CALL TO SERVER
		}
			
	}
	LabelledList_View.prototype.close = function() {
		this.label.removeClass('open');
		this.ul.animate({
		    opacity: .25,
		    height: 0,
		  }, 1000, function() {
		    // Animation complete.
		  });
	}	
		
	LabelledList_View.prototype.toggle = function() {
		
		if (this.label.hasClass('open')) {
			this.close();
		} else {
			this.open();
		}
		
			  
	
	}
	LabelledList_View.prototype.showCount = function() {
		if (this.model && this.model.attrs  ) {
			this.labelCount.text(this.model.attrs.count).show('fade');
		}

	}
	
	LabelledList_View.prototype.notify = function(msg) {
		switch(msg.type) {
		

			case 'item_added':

				this.showCount();
						

				break;

			case 'collection_count_changed':

				this.showCount();
						

				break;


			case 'collection_loaded':
				this.ul.find('.loading-wheel').remove();
				
				
				this.createAllItems();
				
				/*
				if (this.model.items && this.model.items.length > 0 ) {
					
				} else {
					this.close();
				}
				*/
					
				break;
		






		}
	}
	
	LabelledList_View.prototype.createAllItems = function() {
		//this view does not use an html template file
		
		//logit('CollectionList_View::createAllItems()');
		
		var _this = this;
		
		//logit('create all the model views and add them to the list: ' + this.model.items);
		$.each(this.model.items, function(){
			 var modelView = _this.addModelView(this, _this);
			 
		});
		
		
	}
	
	LabelledList_View.prototype.addNewModel  = function(subtypeName) {
		
		
		var cmd = 'new '+this.model.attrs.to_entity+'();';
		logit(cmd);


		var newModel = eval(cmd);
		
		if (subtypeName) {
			logit('LabelledList_View.addNewModel: setting subtype name to: ' + subtypeName);
			newModel.setSubtypeName(subtypeName);
		}
		
		
		// set style to same as recent
		if (recent_Building_style) newModel.attrs.style = recent_Building_style;
		
		logit ('add new model to list of type: ' + newModel.getEntity());
		
		logObject(newModel.attrs);
		
		dataStore.addModel(newModel);
		this.addModelView(newModel);
	}
	
	LabelledList_View.prototype.addModel  = function(model) {
		
		
		this.model.addItem(model);
		this.showCount();
		
		this.addModelView(model);
	}
	
	
	
	LabelledList_View.prototype.replaceViewWith  = function(view, model) {
		var modelView = this.generateModelView(model);
		
		view.element.replaceWith(modelView.element);
		
		this.model.addItem(model);
		
	}	
	LabelledList_View.prototype.generateModelView  = function(model) {
		var modelView;
		//logit(' ---- ---- ---- GENERATING MODEL_VIEW: subview=' + this.subview + ' for ' + model.attrs.name);
		
		if (this.subview) {
			var cmd = 'new '+this.subview+'(model, this);';
			modelView = eval(cmd);
		} else {
			// use default
			switch(model.attrs.entity) {
				case "Image":
					modelView = new ImageSlide_View(model, this);
					break;
				case "Publication":
					modelView = new Publication_View(model, this);
					break;
				case "NoteCard":
					modelView = new NoteCard_View(model, this);
					break;
				case "Building":
					modelView = new Building_View(model, this);
					break;
					
				default:
					modelView = new Model_View(model, this);
			}
			
		}
		
		return modelView;

	}
	LabelledList_View.prototype.addModelView  = function(model) {
		// CREATE A CONTROLLER FOR EACH ITEM IN THE LIST
		// This could be made more efficient by having one controller 
		// to manage all the items.
		var modelView;

		var _this = this;

		var modelView = this.generateModelView(model);


		//modelView.element.find('.subtype').hide();
		
		
		modelView.element.find('.inputfield').addClass('inputfieldOff').removeClass('inputfield');
		modelView.element.find('.quick-edits').hide();
		
		
		
		// ATTACH TO DOM
		if (model.isNew()) {
			this.ul.prepend(modelView.element);
		} else {
			this.ul.append(modelView.element);
		}
		
		
		
		// HIGLIGHT SUPPORT
		if (model.entity != "NoteCard") {
			modelView.element.dblclick(function() {
				// if shift is down, popup window...
				request_ProfileView(model.entity, model.attrs.id);
			});
		}
		
		modelView.element.mouseover(function() {model.sendNotification({type: 'highlight'});});
		modelView.element.mouseout(function() {model.sendNotification({type: 'unhighlight'});});



		
		
		// SELECTION SUPPORT
		 modelView.element.click(function(event) { 

			 

		 	
		 	if(! event.shiftKey) {
		 		
		 		if(! event.altKey) {
		 			//_this.ul.find('.ui-selected').not(this).removeClass('ui-selected');
		 		}
	 		
		 		//if ($(this).hasClass('ui-selected')) {
		 		if (model.selected) {
		 				model.deselect();
		 		} else {
	 				dataStore.deselectAllEntitiesOfType(model.entity);
		 			model.select();
		 		}
		 		

		 		
		 	} else if (event.shiftKey && _this.prevSelected && _this.prevSelected.hasClass('ui-selected')) {
		 		// get the index of this and select everything in between this and the nearest selected item
		 		
		 		var toHere = $(this).index();
		 		var fromHere;
		 		
		 		//fromHere = _this.ul.find('.ui-selected').not(this).index();
		 		fromHere = _this.prevSelected.index();
		 		
		 		if (fromHere > toHere) {
		 			var tmp = toHere;
		 			toHere = fromHere;
		 			fromHere = tmp;
		 		}
		 		
		 		//logit ( ' ++++++ + ' +fromHere + ' to ' + toHere);
		 		for (var i=fromHere; i<= toHere; i++) {
		 		//logit('i='+i);
		 			$(this).parent().children().eq(i).addClass('ui-selected');
		 		}
		 	} else {
			 }
		 		
		 });
		 modelView.element.mousedown(function() {  $(this).addClass('ui-selecting');  });
		 modelView.element.mouseup(function() {  _this.ul.find('.ui-selecting').removeClass('ui-selecting');  });



		// DRAGGING SUPPORT
		var helper;
		var cursorAt;
		if (model.attrs.entity == "Image") {
			helper = 'clone';
			cursorAt = { left: 80, top: 80 };
		} else {
			helper = function(){ return '<div><div style="text-align:center;padding-bottom: 5;"><img src="'+mapIconSmall+'" /></div><div class="dragger"><span class="catnum">'+model.attrs.catnum+'</span> '+model.attrs.name+'</div></div>' };			 
			cursorAt = { left: 53, top: 30 };
		}
		
		modelView.element.draggable({ 
			appendTo:	'body',
			cursor: 	'move',
			cursorAt: 	cursorAt,
			helper: 	helper, 
			revert: 	'invalid', 
			zIndex:		10000,
			activeClass: 'highlight',
			start: function(e,ui){
				//alert(e.pageY);
			   	 //ui.helper.offset({'top':100 ,'left':222 }) // message in clone
			   	 var selectedCount = _this.ul.find('.ui-selected').length;
			   	 if (selectedCount > 1) {
			   	 	//logit(" *** selectedCount = " + selectedCount);
					ui.helper.find('.dragger').html('<div><div style="text-align:center;padding-bottom: 5;"><br /><b>'+selectedCount+' Items</b></div></div>'); 			 
			   	 	//modelView.element.draggable("option", "helper", helper);
			   	 }
			  }	
		});
		
		
		// DELETE ITEM
		modelView.element.mouseenter(function() {
			// ! DELETE THIS ITEM
			var deleteButton = $('<button type="button" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all delete-button">x</div>');
						
			deleteButton.click(function (e) {
				// remove this image from the collection
				
				// deletelistener
				modelView.element.find('.delete-button').remove();
				var reallyDelete = e.shiftKey;

				if (reallyDelete) {
					// remove from DB
					logit("remove from DB");
					modelView.model.deleteFromDatabase();
				} else {
					// just remove from list
					_this.model.removeItem(model);
				}
				// remove element
				modelView.element.hide(500, function () {
					$(this).remove();
					
				});
			});
			modelView.element.append(deleteButton);
		});
		modelView.element.mouseleave(function() {
			modelView.element.find('.delete-button').remove();
		});

		return modelView;
		
	
	}

	LabelledList_View.prototype.onSuggestionViewClick = function(searchCollection, model) {
		logit("Adding model to LabelledList");
		
		$('.entity-undefined').remove();
		
		//this.replaceViewWith(view, model);
		
		this.addModel(model);
		
		$('.suggestionsPanel').remove();
	}











// ! 
// ! ************ HORIZONTAL_LIST_VIEW **************
	HorizontalList_View.prototype 				= new View();
	HorizontalList_View.prototype.constructor 	= HorizontalList_View;

	function HorizontalList_View(collection, element) {
		
		// can be opened or closed at beginning
		// can use various templates
		this.model 		= collection;
		this.element 	= element;
		this.element.data('viewController', this);
		collection.addEventListener(this);

		// UL
		this.ul = this.element.find('ul');
		this.model.loadItems();
		this.process();
	}
	
	HorizontalList_View.prototype.addInteractivity = function() {
		var _this = this;
	}

	HorizontalList_View.prototype.notify = function(msg) {
		
		switch(msg.type) {
			case 'collection_loaded':
				this.createAllItems();
				break;
		}
	}
	HorizontalList_View.prototype.createAllItems = function() {
		//this view does not use an html template file
		var _this = this;		
		$.each(this.model.items, function(){
			var model = this;

			if (_this.subview) {
				var cmd = 'new '+_this.subview+'(model, _this);';
				var modelView = eval(cmd);

				_this.ul.append(modelView.element);				
			} else {
				var html = $('<span class="model-identity profileLink entity-'+model.attrs.entity+' model_id-'+model.attrs.id+'"><span class="fieldname-name">'+model.attrs.name+'</span></span>');
				_this.ul.append(html);
			
			}
		});
	}





// ! 
// ! ************ SLIDESHOW_VIEW **************
	Slideshow_View.prototype 				= new View();
	Slideshow_View.prototype.constructor 	= Slideshow_View;

	function Slideshow_View(collection, element) {
		
		// can be opened or closed at beginning
		// can use various templates
		this.model 		= collection;
		this.element 	= element;
		this.element.data('viewController', this);
		collection.addEventListener(this);

		// UL
		this.ul = this.element.find('ul');
		this.model.loadItems();
		
		this.process();
	}
	
	Slideshow_View.prototype.addInteractivity = function() {
		var _this = this;
	}

	Slideshow_View.prototype.notify = function(msg) {
		switch(msg.type) {
			case 'collection_loaded':
				this.createAllItems();
				break;
		}
	}
	Slideshow_View.prototype.createAllItems = function() {
		//this view does not use an html template file
		var _this = this;		
		$.each(this.model.items, function(){
			 var model = this;
			 var html = $('<span class="model-identity profileLink entity-'+model.attrs.entity+' model_id-'+model.attrs.id+'"><span class="fieldname-name">'+model.attrs.name+'</span></span>');
			 _this.ul.append(html);
		});
	}












// ! 
// ! *********** MAP_VIEW ************************
	Map_View.prototype 				= new View();
	Map_View.prototype.constructor 	= Map_View;

	function Map_View(model, element) {
		// can display any number of collections
		
		this.model = model;

		this.element = element;
		this.element.data('viewController', this);

		this.collections = new Object();
		
		this.markers = new Object();


		// Map Appearence 
		var maptype = google.maps.MapTypeId.SATELLITE;
		var streetViewControl = true;
		var mapTypeControl = true;
		
		this.center = new google.maps.LatLng(38.0, 25.0);
		
		var _this = this;
		
		var zoom = 3;
		if (zoom < 14) {
				maptype = google.maps.MapTypeId.TERRAIN;
				streetViewControl = false;
				mapTypeControl = true;
		}
				
		var myOptions = {
		  zoom: zoom,
		  center: this.center,
		  mapTypeId: maptype,
		  mapTypeControl: mapTypeControl,
		  streetViewControl: streetViewControl
		};
		
		var viewportEl = this.element.find('.map-viewport');
		var width = this.element.parent().width();
		viewportEl.css('height', width*.8);
		
		// create the map!
		
		this.map = new google.maps.Map(viewportEl[0], myOptions);

		
		if (model.attrs.lat) {
		 	if (this.model.attrs.lat2) {
		 		this.bounds = new google.maps.LatLngBounds(new google.maps.LatLng(this.model.attrs.lat, this.model.attrs.lng), new google.maps.LatLng(this.model.attrs.lat2, this.model.attrs.lng2));
				this.map.fitBounds(this.bounds);
				if (this.bounds && this.bounds.toSpan().lat() < 1.0) {
					this.map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
				}
		 	
		 	} else {
		 	//alert('here');
		 		this.map.setCenter(new google.maps.LatLng(this.model.attrs.lat, this.model.attrs.lng));
		 		if (viewportEl.hasClass("closeup")) {
		 			this.map.setZoom(18);
		 			this.map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
		 		} else {
		 			this.map.setZoom(6);
		 			this.map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
		 			
		 			this.dropItemMarker(this.model);
		 		}
		 		this.bounds = this.map.getBounds();
		 	}
		} 

		// make droppable
		this.element.droppable({
			hoverClass: 'activeOnWhite',
			activeClass: 'highlightOnWhite',
			over: function(event, ui) {
				var from_ident = getIdent($(event.target));
				var to_ident = getIdent($(ui.draggable));
				//logit("-> " + to_ident.entity + '::'+ to_ident.id);
				//logit("--> is over me! "+ $(event.target).attr('class'));
				
				
			},
			out: function(event, ui) {
				//logit("someone is left me! "+ $(event.target).attr('class'));
				
			},
			drop: function(event, ui) {
			 
				var from_ident = getIdent($(event.target));
				var to_ident = getIdent($(ui.draggable));
				
				logit("map drop: entity=" + to_ident.entity + ", to_ident.id=" + to_ident.id);
				
				var model = dataStore.getModel(to_ident.entity, to_ident.id) ;
				
				google.maps.event.addListener(_this.map, 'mouseover', function(mEvent) {
          			logit('plant yer flag here! ['+to_ident.entity +' - ' + to_ident.id + '] : ' + mEvent.latLng.lat() + ', ' + mEvent.latLng.lng());
          			
          			model.setPosition(mEvent.latLng);
          			_this.dropItemMarker(model);
			
			        google.maps.event.clearListeners(_this.map, 'mouseover');
        		});
				
				//var this.map.fromPointToLatLng(new Point ((event, ui).localX ,(event, ui).localY))
				logit('/archmap2/api?request=addItemToList&session_id='+thisUser.attrs.session_id+'&from_entity='+from_ident.entity+'&from_id='+from_ident.id+'&to_entity='+to_ident.entity+'&to_id='+to_ident.id+'&relationship='+from_ident.relationship);
				
			}
		});
		
		this.process();
	}
	
	Map_View.prototype.addCollection = function(collection) {
		this.collections[collection.getKey()] = collection;
		
		collection.addEventListener(this);
		
		if (collection && collection.items) {
			this.plotCollection(collection);
		}
	
	}
	Map_View.prototype.notify = function(msg) {
		//logit('got message: '+msg.type + ', ' + msg.key);
		
		var thisMarker = this.markers[msg.key];
		
		
		
		var model;
		if (thisMarker) {
			model = thisMarker.model;
		} else {
			
			
		}
		
		switch (msg.type) {
			case 'highlight':
				thisMarker.setIcon(mapIconLarge);				
				break;
			
			case 'unhighlight':
			
				//thisMarker.setIcon(this.iconUrl(thisMarker.model));
				if (! model.selected) thisMarker.setIcon(model.mapIconUrl());
				break;
		
			case 'select':
			
				//alert('map select: ' + model.attrs['name']);
				
				thisMarker.setIcon(mapIconLarge);
				
				
				_map = this.map;
				
				if (! model.attrs['lat']) {
					
				
					
					// suggest a location
					
					var geocoder = new google.maps.Geocoder();
					
					geocoder.geocode( { 'address': model.attrs['name']}, function(results, status) {
					
						
						
						
						if (status == google.maps.GeocoderStatus.OK) {
							//map.setCenter(results[0].geometry.location);
							var marker = new google.maps.Marker({
							    map: _map,
							    position: results[0].geometry.location
							});
							
							marker.setIcon("/archmap/media/ui/MapsMarker_SearchResult.png");
							google.maps.event.addListener(marker, 'click', function() {  
								_map.setCenter(results[0].geometry.location);
								_map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
								_map.setZoom(16);

							});		
							
							model.tmpMarker = marker;
						} else {
							
							// Use place search to a comma...
							var name = model.attrs['name'];
							var placeName = name.substring(0, name.indexOf(","));
							logit('search: ' + placeName);
							
							geocoder.geocode( { 'address': placeName}, function(results, status) {

								// try again with just place name
								if (status == google.maps.GeocoderStatus.OK) {
									//map.setCenter(results[0].geometry.location);
									var marker_p = new google.maps.Marker({
									    map: _map,
									    position: results[0].geometry.location
									});
									
									marker_p.setIcon("/archmap/media/ui/MapsMarker_SearchResult.png");
									google.maps.event.addListener(marker_p, 'click', function() {  
										_map.setCenter(results[0].geometry.location);
										_map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
										_map.setZoom(16);

									});		

									model.tmpMarker = marker_p;
								} else {
									alert("Geocode was not successful for the following reason: " + status);
								}
		

							});
						}
					
					});
	 
	 			}
				break;
				
			case 'deselect':

				thisMarker.setIcon(model.mapIconUrl());
				if (model.tmpMarker) {
					
					model.tmpMarker.setMap(null);
				} 
				break;
		
			case 'value_changed':
				
				//if (msg.field == 'preservation') {
					//thisMarker.setIcon(this.iconUrl(thisMarker.model));
					
					thisMarker.setIcon(thisMarker.model.mapIconUrl());
				
				//}
				break;
			
			case 'item_added':
				model = msg.model;
				this.dropItemMarker(model);
				break;

			case 'collection_loaded':
				var collection = this.collections[msg.key];
				logit(msg.key);
				logit('MAP::notify: COLLECTION collection_loaded:: ' + collection.toString()+ ' $!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$!$$!$!$!$!$!');
				this.plotCollection(collection);
				break;
		
		}
	}
	
	
	Map_View.prototype.plotCollection = function(collection) {
		var _this = this;
		if (collection && collection.items) {
			$.each(collection.items, function() {
				if (collection.attrs.to_entity == "Image") {
					_this.plotImage(this);
				} else {
					_this.dropItemMarker(this);
				}
			});
		}
	}
	Map_View.prototype.plotImage = function(model) {
		var _this = this;
						
		var imageBounds;
		if (! model.attrs.lat) {
			imageBounds = _this.map.getBounds();
		} else {
			imageBounds = model.getBounds();
		}
		
			
	 	var overlay = new ProjectedOverlay(this.map, model.getUrl('full'), imageBounds, {'percentOpacity': 55}) ;
		
		var sw = imageBounds.getSouthWest();
		var ne = imageBounds.getNorthEast();

		var mapIcon = '/media/ui/maps/map_icon_sm/map_icon_handle.png';
		var sw_Marker = new google.maps.Marker({
      		map: _this.map,
      		draggable:true,
      		title:model.attrs.name,
      		icon: mapIcon, 
      		position: sw
		});
		sw_Marker.model = model;
		
		var ne_Marker = new google.maps.Marker({
      		map: _this.map,
      		draggable:true,
      		title:model.attrs.name,
      		icon: mapIcon, 
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
		
		
	}

	Map_View.prototype.dropItemMarker = function(model) {
		var position = model.getPosition();
		
		model.addEventListener(this);
		
		//var iconUrl = this.iconUrl(model);
		
		//logit('Map_View.dropItemMarker model.getEntity()='+model.getEntity());
		var iconUrl = model.mapIconUrl();
		
		var mapMarker = new google.maps.Marker({
      		map:this.map,
			animation: google.maps.Animation.DROP,
      		draggable:true,
      		title:model.attrs.name,
      		icon: iconUrl, 
      		position: position
		});
		this.markers[model.getKey()] = mapMarker;
		
		mapMarker.model = model;
		
		google.maps.event.addListener(mapMarker, 'click', function() {  
			request_ProfileView(model.attrs.entity, model.attrs.id);
		});		
		google.maps.event.addListener(mapMarker, 'mouseover', function() { 
			this.model.sendNotification({type: 'highlight'});
		});
		
		google.maps.event.addListener(mapMarker, 'mouseout', function() {  
			this.model.sendNotification({type: 'unhighlight'});
		});
		google.maps.event.addListener(mapMarker, 'dragend', function() {  
			this.model.setPosition(this.getPosition());
		});
		
		 
	}
	
	
		
	Map_View.prototype.addInteractivity = function() {
		var _this = this;
		this.element.find('.setBoundsButton').click(function(){
			_this.saveBounds();
		});
	}

	Map_View.prototype.saveBounds = function() {
		this.bounds = this.map.getBounds();
		this.model.setBounds(this.bounds);
		
	}
	Map_View.prototype.saveState = function() {
		
		this.center = this.map.getCenter();
		
	}
	Map_View.prototype.resize = function() {
		
		//this.map.setCenter(this.center);
		
		var width = this.element.width();
		//var height = width*.7;
		var height = this.element.height();;
		logit('width = ' + width);
		this.element.find('.map-viewport').css('height', height);

		google.maps.event.trigger(this.map, "resize");
		if (this.bounds) this.map.fitBounds(this.bounds);

	}
	
	Map_View.prototype.update = function(collection) {
		//this view does not use an html template file
		// plot the collection items
		
	}
	Map_View.prototype.toString = function() {
		return "Map_View :: "; 
	}
















// ! 
// ! *********** MODEL_PROFILE_VIEW **************
	ModelProfile_View.prototype 				= new View();
	ModelProfile_View.prototype.constructor 	= ModelProfile_View;

	function ModelProfile_View(model) {
		
		this.model = model;
		
		this.element = $('<div class="profile model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+'"></div>');
		this.element.data('viewController', this);
		
		
		// if a collection is loaded, then use that template....
		
		//this.templateName = model.entity+"Profile_View";
		
		this.templateName = model.entity+"Profile_View";

		
		this.process();
		
		//if (planView) {
			//planView.append("<div>Hello</div>");
		//}
		//alert('plan view: '+planView.text());
		
		

	}
	
		
	ModelProfile_View.prototype.addInteractivity = function(el) {
		var _this = this;
		
		this.element.find('.mapButton').click(function() {
			
			var dialogPosition = [0, 25];

			_this.element.dialog( "option", "position", dialogPosition );
			_this.element.dialog( "option", "width", $(window).width());
			_this.element.dialog( "option", "height", $(window).height()-25);
			
			_this.element.find('div.map-view').data('viewController').saveState();
			
			//_this.element.find('.leftColumn').append(_this.element.find('.related-items.entity-Image'));
			
			
			_this.element.find('.centerColumn').append(_this.element.find('.notes'));
			
			_this.element.find('.centerColumn').prepend(_this.element.find('div.map-view'));

			var width = _this.element.find('div.map-viewport').width();
			_this.element.find('div.map-viewport').css('height', width);
			var tmpEl = _this.element.find('div.map-view');
			var vc = tmpEl.data('viewController');
			
			if (vc) vc.resize();
			
			
			_this.element.find('.rightColumn').append(_this.element.find('related-items.entity-Building'));
			_this.element.find('.related-items.entity-Building ul.related-items-listview').height(650);
			
			
			
		});
		
		

		
		// __POSTERS poster_id; plan_image_id; lat_section_id; long_section_id
		this.element.find('.poster-view').each( function(){
			// get the field
			var _thisview = this;
			//$(this).css('height', 320);
			
			var frame = $('<div class="picture-frame"></div>');
			$(_thisview).append(frame);
			$(_thisview).append('<div class="picture-frame-shadow" style="width:340px;"></div>');


			//var accept = '.entity-Image';
	
			var accept = function(draggable) {
				return true;
				var ident = getIdent($(draggable));
				if ( $(this).find('.model_id-'+ident.id).length > 0) return false;
				if ($(draggable).hasClass('entity-'+_this.model.attrs.to_entity) && ! $(draggable).hasClass('model_id-'+_this.model.parent.attrs.id)) return true;
				return false;
			}

			var fieldname = getClassItemWithPrefix($(this), 'fieldname-') ;

			frame.droppable({
				hoverClass: 'activeOnWhite', 	
				activeClass: 'highlightOnWhite',
				accept: accept,
				over: function(event, ui) {
					var from_ident = getIdent($(event.target));
					var to_ident = getIdent($(ui.draggable));
					
					
					var from_model = _this.model;
					var to_model = $(ui.draggable).viewController;
					
					logit ('$(ui.draggable).viewController='+$(ui.draggable).viewController);
					//logit("-> " + to_ident.entity + '::'+ to_ident.id);
					//logit("--> is over me! "+ $(event.target).attr('class'));
					
					//logit("-> " + to_model.attrs.entity + '::'+ to_model.attrs.id);
					logit("--> is over me! enitiy: " + from_model.attrs.id + ', ' + from_model.attrs.name  );
					
				},
				out: function(event, ui) {
					logit("someone is left me! "+ $(event.target).attr('class'));
					
				},
				drop: function(event, ui) {
					logit("DROPPED: 1" );
					var from_ident = getIdent($(event.target));
					var to_ident = getIdent($(ui.draggable));
					logit("DROPPED: 2" );

					var model = dataStore.getModel(to_ident.entity, to_ident.id) ;
					
					logit("DROPPED: 3 " + to_ident.entity + '. ' + to_ident.id + ' model: ' + model.attrs.filename);
					
					// make dropped image the poster for this fieldname...
					logit('make Image: ' + to_ident.id + '  the ' + fieldname + ' for ' + from_ident.entity + ': ' + from_ident.id);
					
					_this.model.setAndSave(fieldname, model.attrs.id);
					
					_this.addImageProfileView (frame, model);
					frame.css('height', 320);
					
					//_this.addModelView(model);
					logit('/archmap2/api?request=addItemToList&session_id='+thisUser.attrs.session_id+'&from_entity='+from_ident.entity+'&from_id='+from_ident.id+'&to_entity='+to_ident.entity+'&to_id='+to_ident.id+'&relationship='+from_ident.relationship);
					
				}
			});


			
				
			if (fieldname) {
				
				if (_this.model.attrs[fieldname]) {
					
					dataStore.getModel("Image", _this.model.attrs[fieldname], function(model) {
						
						
						_this.addImageProfileView (frame, model);
						
						frame.css('height', 320);	
		
					} );				
					
				} else {
						frame.css('height', 20);
					
				}
			} 
		});
		

		
		
		// __ACTIVATE ALL EDITABLE FIELDS
		this.activateEditing();
		
		

	}
		
	ModelProfile_View.prototype.addImageProfileView = function(frame, model) {
						
						var profileView = new ImageProfile_View(model);
						//logit(profileView.element.html());
						profileView.element.css('width', 300);
						profileView.element.css('height', 320);
						
						//_this.element.find('#profile-pano_'+_this.model.attrs.id).append(profileView.element);
						
						frame.empty();
						
						frame.append(profileView.element);

	}
		

// ! 
// ! *********** MODEL_VIEW ************
	Model_View.prototype 					= new View();
	Model_View.prototype.constructor		= Model_View;

	function Model_View(model, parentView) {
		
		this.model = model;
		model.addEventListener(this);

		this.parentView = parentView;
		
		this.element = $('<li class="model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+' item-view"></li>');
		this.element.data('viewController', this);
		
		
		
		this.templateName = "Model_View";
		
		this.process();
		

	}
	
	Model_View.prototype.addInteractivity = function() {
		var _this = this;
		var _view = this;
		

		this.activateEditing();

		logit('adding interactivity for model_view');
		
		// if new, set to editing and focus…
		if ( this.model.isNew() ) {
			window.setTimeout(function() {
				//_view.element.find('.fieldname-descript').click();
				_view.element.find('.fieldname-name').click();
	
			}, 250);
		}
		

	}
	Model_View.prototype.notify = function(msg) {
		//logit("Model_View::notification! " + msg.key + ', '+ msg.type);
		var _this = this;
		
		switch (msg.type) {
			case "highlight":
				this.element.addClass('highlightOnWhite');
				break;
			case "unhighlight":
				this.element.removeClass('highlightOnWhite');
				break;
			case "reposition":
				this.bgDiv.removeClass('unlocated');
				this.bgDiv.addClass('located');
				break;
				
			case "value_changed":
				if (msg.field == "preservation") {
					this.bgDiv.css('opacity', msg.value/10);
				}
				break;
			case "value_saved":
				_this.element.removeClass("loading");
				break;
			
		
		}
		
	}

		
		

	

// ! 
// ! *********** PUBLICATION_VIEW ************
	Publication_View.prototype 					= new View();
	Publication_View.prototype.constructor		= Publication_View;

	function Publication_View(model, parentView) {
		
		this.model = model;
		model.addEventListener(this);
		
		this.parentView = parentView;

		this.element = $('<li class="model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+' item-view '+this.model.attrs.pubtypeName.toLowerCase()+'"></li>');
		this.element.data('viewController', this);
		
		this.suggestionView;

		this.templateName = "Publication_View";
		
		this.process();
		
		var _view = this;
		
		// hook up behavior of editing fields
		this.element.find('.inputfield').each( function(){
			var _this = $(this);
			$(this).click(function(){
				_view.activateInputFieldEditing(_this);
			});
		});
		this.element.find('.textarea').each( function(){
			var _this = $(this);
			$(this).click(function(){
				_view.activateTextAreaEditing(_this);
			});
		});
		
		// if new, set to editing and focus…
		if ( this.model.hasDefaultName() ) {
			window.setTimeout(function() {
				_view.element.find('.fieldname-contributors').click();
				_view.element.find('.fieldname-name').click();
	
			}, 250);
		}
		
		
		logit("CREATING Publication View - model.attrs.pubtypeName=" + model.attrs.pubtypeName);
		
		if ( model.attrs.pubtypeName == "Book" || model.attrs.pubtypeName == "EditedBook" ) {
			this.element.find('.Chapter').hide();
		}
		
		if (model.attrs.pubtypeName == "Chapter") {
			this.element.find('.Book').hide();
			
			// CHAPTER_NUM / CATNUM
			this.catnumField = this.element.find('.fieldname-catnum');
			if (! this.model.attrs.catnum) this.catnumField.append('-');

		}
	}
	Publication_View.prototype.toString = function() {
		return "Publication_View :: " + this.model.getKey(); 
	}
	
	Publication_View.prototype.notify = function(msg) {
		//logit("Model_View::notification! " + msg.key + ', '+ msg.type);
		var _this = this;
		
		switch (msg.type) {
			case "highlight":
				this.element.addClass('highlightOnWhite');
				break;
			case "unhighlight":
				this.element.removeClass('highlightOnWhite');
				break;
				
			case "value_changed":
				break;
			case "value_saved":
				_this.element.removeClass("loading");
				break;
		}
		
	}

		

// ! 
// ! *********** SHORT_CITATION_VIEW ************
	ShortCitation_View.prototype 					= new View();
	ShortCitation_View.prototype.constructor		= ShortCitation_View;

	function ShortCitation_View(model, parentView) {
		
		this.model = model;
		model.addEventListener(this);
		
		this.parentView = parentView;

		this.element = $('<li class="model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+' item-view '+this.model.attrs.pubtypeName.toLowerCase()+'"></li>');
		this.element.data('viewController', this);
		
		this.suggestionView;

		this.templateName = "ShortCitation_View";
		
		this.process();
		
		var _view = this;
		
		
		// hook up behavior of editing fields
		this.element.find('.inputfield').each( function(){
			var _this = $(this);
			$(this).click(function(){
				_view.activateInputFieldEditing(_this);
			});
		});

		this.pagesField = this.element.find('.fieldname-pages');
		if (! this.model.attrs.pages || this.model.attrs.pages == "" || this.model.attrs.pages == " " ) this.pagesField.append('-');
	
		
		
	}
	ShortCitation_View.prototype.toString = function() {
		return "ShortCitation_View :: " + this.model.getKey(); 
	}
	
	ShortCitation_View.prototype.notify = function(msg) {
		//logit("Model_View::notification! " + msg.key + ', '+ msg.type);
		var _this = this;
		
		switch (msg.type) {
			case "highlight":
				this.element.addClass('highlightOnWhite');
				break;
			case "unhighlight":
				this.element.removeClass('highlightOnWhite');
				break;
				
			case "value_changed":
				break;
			case "value_saved":
				_this.element.removeClass("loading");
				break;
		}
		
	}

		
		

// ! 
// ! *********** NOTE_CARD_VIEW ************
	NoteCard_View.prototype 					= new View();
	NoteCard_View.prototype.constructor		= NoteCard_View;

	function NoteCard_View(model, parentView) {
		
		this.model = model;
		model.addEventListener(this);
		
		this.parentView = parentView;
		
		this.element = $('<li class="model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+' item-view "></li>');
		this.element.data('viewController', this);
		
		this.templateName = "NoteCard_View";
		
		this.process();
		
		var _view = this;
		
		// hook up behavior of editing fields
		this.element.find('.inputfield').each( function(){
			var _this = $(this);
			$(this).click(function(){
				_view.activateInputFieldEditing(_this);
			});
		});
		this.element.find('.textarea').each( function(){
			var _this = $(this);
			
			
			//$(this).html($(this).text());
			$(this).html( $(this).html().replace(/\n/g, "<br>") );

			$(this).click(function(){
				_view.activateTextAreaEditing(_this);
			});
		});
		
		// PAGES
		this.pagesField = this.element.find('.fieldname-pages');
		
		if (this.parentView.model.attrs.from_entity == "Publication") {
			if (! this.model.attrs.pages) this.pagesField.append('-');
			
			// if new, set to editing and focus…
			if ( this.model.isNew() ) {
				window.setTimeout(function() {
					_view.element.find('.fieldname-pages').click();
					_view.element.find('.fieldname-descript').click();
					_view.element.find('.fieldname-name').click();
		
				}, 250);
			}
		} else {
			
			this.pagesField.parent().hide();
		}
		
		// PUBLIC_STATUS CHECKBOX
		this.isPublicCheckbox 		= this.element.find('input:[name="public_status"]');
		this.isPublicCheckbox.change(function () {
			if (_view.isPublicCheckbox.attr("checked")) {
				_view.model.setAndSave('public_status', 1);
			} else {
				_view.model.setAndSave('public_status', 0);
			}
		});
		if (this.model.attrs.public_status == 1) {
			this.isPublicCheckbox.attr('checked', true);
		} else {
			this.isPublicCheckbox.attr('checked', false);
		}

		
		
		// CARDTYPE OPTION
		// - identify
		this.cardtypeSelect = this.element.find('select:[name="cardtype"]');
		// - make interactive
		this.cardtypeSelect.change(function() {
			_view.model.setAndSave('cardtype', $(this).val());
			recent_NoteCard_cardtype = $(this).val();
			if ($(this).val() == 1) {
				// Quotes are public by default
				_view.isPublicCheckbox.attr('checked', true);
				window.setTimeout(function() {
					_view.model.setAndSave('public_status', 1);				
				}, 250);
				
				
				
			}
		});
		// - set to initial value
		this.cardtypeSelect.val(this.model.attrs.cardtype);




		

	}
	
	
	
	
	NoteCard_View.prototype.notify = function(msg) {
		//logit("Model_View::notification! " + msg.key + ', '+ msg.type);
		var _this = this;
		
		switch (msg.type) {
			case "highlight":
				this.element.addClass('highlightOnWhite');
				break;
			case "unhighlight":
				this.element.removeClass('highlightOnWhite');
				break;
				
			case "value_changed":
				break;
			case "value_saved":
				_this.element.removeClass("loading");
				break;
			
		
		}
		
	}

		
		
		
		


// ! 
// ! *********** BUILDING_SHORT_VIEW ************
	Building_Short_View.prototype 					= new View();
	Building_Short_View.prototype.constructor		= Building_Short_View;

	function Building_Short_View(model, parentView, editable) {
		
		
		this.model = model;
		model.addEventListener(this);
		
		this.parentView = parentView;
		
		this.element = $('<li class="model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+' item-view "></li>');
		this.element.data('viewController', this);
		
		this.templateName = "Building_Short_View";
		
		this.process();
		
		var _this = this;
		
		var _view = this;
		

	}






// ! 
// ! *********** BUILDING_VIEW ************
	Building_View.prototype 					= new View();
	Building_View.prototype.constructor		= Building_View;

	function Building_View(model, parentView, editable) {
		
		
		this.model = model;
		model.addEventListener(this);
		
		this.parentView = parentView;
		
		this.element = $('<li class="model-identity relparent entity-'+this.model.entity+' model_id-'+this.model.attrs.id+' item-view "></li>');
		this.element.data('viewController', this);
		
		this.templateName = "Building_View";
		
		this.process();
		
		var _this = this;
		
		var _view = this;
		
		
		//if (editable || this.model.isNew()) {
		
			// hook up behavior of editing fields
			this.element.find('.inputfield').each( function(){
				var _this = $(this);
				$(this).click(function(){
					_view.activateInputFieldEditing(_this);
				});
			});
			this.element.find('.textarea').each( function(){
				var _this = $(this);
				$(this).click(function(){
					_view.activateTextAreaEditing(_this);
				});
			});
			
		//}
		// if new, set to editing and focus…
		if ( this.model.isNew() ) {
			window.setTimeout(function() {
				_view.element.find('.fieldname-descript').click();
				_view.element.find('.fieldname-name').click();
	
			}, 250);
		}
		

		this.preservationSlider = this.element.find(".slider.preservation" ); 
		this.geoPrecisionSlider = this.element.find(".slider.geo_precision" ); 
		this.bgDiv = this.element.find('.model-view-background');
		
		
		
		if (this.model.attrs.lat) {
			//logit("mapicon for: " + this.model.attrs.name);
			this.element.find('.mapIcon').attr("src", this.model.mapIconUrl());		
		}
		
		
		
		this.element.find(".related-items-summary").click(function() {
			//alert("get related items");
			var ul = $(this).append('<ul></ul>');
			
			this.model.getAllRelatedItems(function() {
				alert("got'em")
			});
		
		}); 
		
		
		
		//logit('this.bgDiv: ' + this.bgDiv);
		//logit('PRESERVATION: ' + this.model.attrs.preservation);
		
		// PRESERVATION SLIDER
		if (this.model.attrs.preservation) {
			
			if (this.bgDiv) {
				this.bgDiv.css('opacity', this.model.attrs.preservation/10);

			}
						
			this.preservationSlider.slider({
				min: 	 1,
				max: 	5,
				value: _this.model.attrs.preservation,
				start: function () {
					_this.element.addClass('loading');
				},
				slide: function( event, ui ) {
					_this.model.setValue('preservation', ui.value);
				},
				change: function( event, ui ) {
					_this.model.saveValue('preservation', ui.value);
				}
			});
			this.geoPrecisionSlider.slider({
				min: 	 1,
				max: 	 5,
				value: _this.model.attrs.geo_precision,
				start: function () {
					_this.element.addClass('loading');
				},
				slide: function( event, ui ) {
					_this.model.setValue('geo_precision', ui.value);
				},
				change: function( event, ui ) {
					_this.model.saveValue('geo_precision', ui.value);
				}
			});
		} else {
			this.element.find('.slider-set.preservation').remove();
			this.element.find('.slider-set.geo_precision').remove();
		}
	


		// STYLE
		this.styleSelect = this.element.find('select:[name="style"]');
		this.styleSelect.change(function() {
			
			_this.model.setAndSave('style', $(this).val());
			recent_Building_style = $(this).val();
		});
		
		this.styleSelect.val(this.model.attrs.style);


		// CATNUM
		this.catnumField = this.element.find('.fieldname-catnum');
		if (this.parentView && this.parentView.model && this.parentView.model.parent && this.parentView.model.parent.attrs.isCatalog) {
			if (! this.model.attrs.catnum) this.catnumField.append('-');
		}
		
		this.quickeditsPanel = this.element.find('.quick-edits');
		//this.quickeditsPanel.hide();
		
		
		
		
		
		
		
		


	}
	
	Building_View.prototype.setModel = function(model) {
		this.model = model;
		model.addEventListener(this);
	
	}
	
	
	Building_View.prototype.notify = function(msg) {
		//logit("Model_View::notification! " + msg.key + ', '+ msg.type);
		var _this = this;
		
		switch (msg.type) {
			case "highlight":
				this.element.addClass('highlightOnWhite');
				
				break;
			case "unhighlight":
				this.element.removeClass('highlightOnWhite');
				break;
				
			case "select":
				this.element.addClass('ui-selected');
				break;
				
			case "deselect":
				this.element.removeClass('ui-selected');
				break;
				
			case "value_changed":
			
				this.element.find('.mapIcon').attr("src", this.model.mapIconUrl());
				break;
			case "value_saved":
				_this.element.removeClass("loading");
				
				this.element.find('.mapIcon').attr("src", this.model.mapIconUrl());
				
				
				break;
			
		
		}
		
	}

		
		
		
		
		
		
		
		
		
		
		
		

// ! 
// ! *********** IMAGE SLIDE VIEW ****************
	ImageSlide_View.prototype 					= new View();
	ImageSlide_View.prototype.constructor 		= ImageSlide_View;

	function ImageSlide_View(model, parentView) {
		
		this.model = model;
		this.parentView = parentView;
		
		this.element = $('<li class="model-identity entity-'+model.entity+' model_id-'+model.attrs.id+' item-view" style="float:left;"></li>');
		this.element.data('viewController', this);
		
		this.templateName = "ImageSlide_View";
		
		
		this.process();
		

	}
	

		
		
	

// ! 
// ! *********** IMAGE PROFILE VIEW **************
	ImageProfile_View.prototype 				= new View();
	ImageProfile_View.prototype.constructor 	= ImageSlide_View;

	function ImageProfile_View(model) {

		this.model = model;
		this.element = $('<div class="profile model-identity  entity-'+model.entity+'  model_id-'+model.attrs.id+'"></div>');
		this.element.data('viewController', this);
		
		this.templateName = "ImageProfile_View";
		
		this.imagePlayer;
		
		this.imageViewEl;
		this.controlPanelTimeout;
		
		this.process();
		


	}


	ImageProfile_View.prototype.setSize = function(width, height) {
		var imageViewEl = this.element.find("#image-viewer-"+this.model.attrs.id);
   		logit('* * * * ImageProfile_View.prototype.setSize... ' + width + ", " + height);
   		imageViewEl.css('width',  width);
    	imageViewEl.css('height', height);
    	
    	logit('ImageProfile_View.prototype.setSize('+width+', '+ height +')');
    	//this.imagePlayer.setViewerSize(width, height);
    	//this.imagePlayer.updatePanoramaCSS()
    	//var configString = '<panorama><view fovmode="0"><start width="'+width+'" pan="0" tilt="25" fov="70"/><min pan="0" tilt="-90" fov="5"/><max pan="360" tilt="90" fov="120"/></view></panorama>';
		//this.imagePlayer.readConfigString(configString);			

 	
	}
	
	ImageProfile_View.prototype.addInteractivity = function() {
		
		//  SEADRAGON OR PAN2VR_PLAYER VIEWER
		this.imageViewEl = this.element.find("#image-viewer-"+this.model.attrs.id);
	    	
	    var _this = this;
	    	
	    var url;
	    var viewer;
	    
    	if (this.model.attrs.filesystem == "B") {
    		// if type is "node" then play pano viewr
    		
    		if (this.model.attrs.image_type == "node" || this.model.attrs.image_type == "cubic") {
    		
    			// PANORAMA -- PANO_PLAYER
    			
    			this.imageViewEl.css('width',  "100%");
    			this.imageViewEl.css('height', this.imageViewEl.css('width'));
    			
    			
				//var building_id 		= 3;//this.model.attrs.id;
				var building_id 		= this.model.attrs.id;
				var millenium_folder;
				
				if (building_id < 1000) {
					millenium_folder = '0000';
					building_id =  String("0000" + building_id).slice(-4);
				}else {
					millenium_folder = Math.floor(building_id / 1000) * 1000;
				}	
				
				var fullfile = this.model.getUrl('full');
				//millenium_folder = String("0000" + n).slice(-4);	
				
				//alert (millenium_folder);
				var resolution 			= 'low';
				// INSTANTIATING PANO2VR
				this.imagePlayer = new pano2vrPlayer('image-viewer-'+this.model.attrs.id);	
				//var pano = new pano2vrPlayer(imageViewEl[0]);	
				this.imagePlayer.setFullscreen = wrap(this.imagePlayer.setFullscreen, function (toFullscreen) {
						logit('setFullscreen: ' + toFullscreen);
						if (toFullscreen)
							_this.expandDiv();
						else {
						
							_this.resetDiv();
							
						}
							
					});
				
						
				var node_id 			= '01';
				//var panosPath = '/archmap/media/buildings_panos/'+millenium_folder+'/'+building_id+'/'+node_id+'/'+resolution+'/'+building_id+'_'+node_id;
				
				var tiles = new Array();
				
				var cube_size = 1024;
				
				var cubeUrl = '/archmap_2/php_utils/cubic_image.php?imagedata='+fullfile + '--' + cube_size + "--";
				
				tiles[0] = cubeUrl+'front';
				tiles[1] = cubeUrl+'right';
				tiles[2] = cubeUrl+'back';
				tiles[3] = cubeUrl+'left';
				tiles[4] = cubeUrl+'top';
				tiles[5] = cubeUrl+'bottom';
				
				
				var configString = '<panorama><view fovmode="0"><start pan="0" tilt="15" fov="70"/><min pan="0" tilt="-90" fov="5"/><max pan="360" tilt="90" fov="120"/></view><input tilesize="1000" tilescale="1.01" tile0url="'+tiles[0]+'" tile1url="'+tiles[1]+'" tile2url="'+tiles[2]+'" tile3url="'+tiles[3]+'" tile4url="'+tiles[4]+'" tile5url="'+tiles[5]+'" /><control sensitifity="125" simulatemass="1" lockedmouse="0" lockedkeyboard="0" lockedwheel="0" invertwheel="1" speedwheel="1" invertcontrol="1" /></panorama>';
				this.imagePlayer.readConfigString(configString);			

  				this.imagePlayer.setPan(this.model.attrs.pan);
				this.imagePlayer.setTilt(this.model.attrs.tilt);
				this.imagePlayer.setFov(this.model.attrs.fov);
  		
				
   				var canvasEl = this.imageViewEl.find('#viewport').find('canvas');
 				var canvas = canvasEl[0];
				
				
				
				
				
				
    			// __CONTROL PANEL__
    			
    			var fullpageButtonEl = $('<img class="fullpageButton" src="/archmap_2/js/seadragon-ui-img/fullpage_rest.png" style="position: absolute; bottom:5; right: 5;z-index: 9999;" />');
    			
    			var viewport = this.imageViewEl.find('#viewport');
    			
    			viewport.append(fullpageButtonEl);
    			
    			fullpageButtonEl.find('.fullpageButton');
    			
    			fullpageButtonEl.click(function(){
    				   				    				
    				if (_this.imageViewEl.hasClass('fullscreen')) {
    					_this.imagePlayer.setFullscreen(false);
    				} else {
    					_this.imagePlayer.setFullscreen(true);
    				}
    				
    			});
    			
    			fullpageButtonEl.mouseover( function() {
	    			clearTimeout(_this.controlPanelTimeout);
    			});
    			fullpageButtonEl.hide();
    			
    			viewport.mouseover( function() {
	    			fullpageButtonEl.show();
	    			clearTimeout(_this.controlPanelTimeout);
    			});
    			viewport.mouseout( function() {
	    			_this.controlPanelTimeout = setTimeout(function(){
		    				fullpageButtonEl.fadeOut("slow");
		    			}, 650);	    			
    			});
    			
    			
    			
    			// ___FULLSCREEN
    			var setFullscreenButton = this.element.find("#fullscreen");
    			
    			setFullscreenButton.click(function(){
    			
    				_this.imagePlayer.setFullscreen(true);
    			});
    			
    			// ___SET VIEW	
    			var setViewLink = this.element.find("#set-view");
    			
    			setViewLink.click(function(){
    				
    				// __SAVE COORDINATES OF VIEW TO DB
    				_this.model.attrs.pan 	= _this.imagePlayer.getPan();
    				_this.model.attrs.tilt 	= _this.imagePlayer.getTilt();
    				_this.model.attrs.fov 	= _this.imagePlayer.getFov();
    				_this.model.saveModel();
    				
    				// GRAB STILL IMAGE FROM CANVAS
    				canvasEl = _this.imageViewEl.find('#viewport').find('canvas');
	 				canvas = canvasEl[0];

					if (canvas) {
						var data   = canvas.toDataURL('image/jpg');					
						
						// __REFRESH ICONS CURRENTLY DISPLAYED
					    var img =  $('.model-identity.entity-Image.model_id-'+_this.model.attrs.id).find('img');
					    img.attr('src', data);
					    img.attr('width', 100);
					    img.attr('height', 100);
	
	    				// __UPLOAD NEW ICON BASED ON CANVAS IMAGE
						$.post('/archmap_2/upload_center/uploadIconForImage.php', {
						        id : _this.model.attrs.id,
						        img_data : data.replace(/^data:image\/(png|jpg);base64,/, "")
						    },
						    function(data) {
							    // refresh any displays of this icon (update the src of any elements found with the url?editdate)
							  // var img =  $('.model-identity.entity-Image.model_id-'+_this.model.attrs.id).find('img');
							  // img.attr('src', _this.model.attrs.slideUrl+'&r='+(Math.floor(Math.random()*11)));
						    });  
					} 				
 				});
    		
    		} else {
    			// !  FILESYTEM B -- STILL IMAGE -- SEADRAGON PLAYER
	
 
				if (this.model.attrs.has_sd_tiles == 2) {		
					url = "/fcgi-bin/iipsrv.fcgi?DeepZoom=/home/tiles/"+this.model.attrs.id+"_full.tif.dzi";	// use the DeepZoom server				
				} else {
	 	    		url = '/archmap/media/images/'+this.model.attrs.filename +'_tiles/'+ this.model.attrs.id + '.xml';					
				}
				
	 			viewer = new Seadragon.Viewer(this.imageViewEl[0]);	
	        	viewer.openDzi(url);          
	          	
	          	/*
				viewer = OpenSeadragon({
					id: this.imageViewEl[0].id,
					prefixUrl: "/media/images/",
					tileSources : [url],
					visibilityRatio: 1.0,
					constrainDuringPan: true

				});
				*/
				
				
        window.onresize = function() {
          setTimeout(function(){
          viewer.viewport.goHome();
          }, 800); // 800ms is chosen at random
        }
	      /*    	viewer.addEventListener("resize", function() {
	 				viewer.viewport.goHome();
	    		});*/
	    		
	    		
	    		logit ('Seadragon this!: ' + url);
    		
	    	}
    		
    		
    		
    		
    		
    	} else {
    		//url = '/archmap/media/buildings_sd_tiles/1000/'+this.model.attrs.building_id+'/'+ (this.model.attrs.filename).substring(0,10) + '.xml';
    		
    		//url = '/archmap/media/buildings_sd_tiles/1000/'+this.model.attrs.building_id+'/'+ (this.model.attrs.filename).substring(0,10) + '.xml';
    		
    		url = this.model.attrs.media_folder+'/seadragon/'+ (this.model.attrs.filename).substring(0,10) + '.xml';
    		
    		
    		
    		
	 			viewer = new Seadragon.Viewer(this.imageViewEl[0]);	
	        	viewer.openDzi(url);          
	          	viewer.addEventListener("resize", function() {
	 				viewer.viewport.goHome();
	    		});
    		
    	}	    		    	
    		
    		
		var _view = this;
		
		// hook up behavior of editing fields
		this.element.find('.inputfield').each( function(){
			var _this = $(this);
			$(this).click(function(){
				_view.activateInputFieldEditing(_this);
			});
		});

	}
	
	ImageProfile_View.prototype.expandDiv = function() {
		//var imageViewEl = this.element.find("#image-viewer-"+this.model.attrs.id);
		
		logit('expandDiv: ' + this.imageViewEl.hasClass('fullscreen'));

		if (!this.imageViewEl.hasClass('fullscreen'))
		{         
		 this.imageViewEl.addClass('fullscreen');
		 logit('class added? ' + this.imageViewEl.hasClass('fullscreen'));
		 this.beforeFullscreen = {
		    parentElement: this.imageViewEl.parent(),
		    index: this.imageViewEl.parent().children().index(this.imageViewEl),
		    x: $(window).scrollLeft(), y: $(window).scrollTop()
		 };
		 $('html').css('overflow', 'hidden');
		 $('body').css('overflow', 'hidden');
		 $('body').append(this.imageViewEl).css('overflow', 'hidden');
		 window.scroll(0,0);
		 //$('#fullscreen_toggle').html("Close Fullscreen");
		} 
		
	}
	
	ImageProfile_View.prototype.resetDiv = function() {
		//var imageViewEl = this.element.find("#image-viewer-"+this.model.attrs.id);
     
		logit('resetDiv: this.imageViewEl.hasClass("fullscreen") = ' + this.imageViewEl.hasClass('fullscreen'));
		if (this.imageViewEl.hasClass('fullscreen')) {         
			this.imageViewEl.removeClass('fullscreen');
			//$('#fullscreen_toggle').html("Show Fullscreen");   
			if (this.beforeFullscreen.index+1 >= this.beforeFullscreen.parentElement.children().length) {
				//alert('restDiv: ' + this.imageViewEl.hasClass('fullscreen'));
				this.beforeFullscreen.parentElement.append(this.imageViewEl);
			} else {
				alert('restDiv: index=' + this.beforeFullscreen.index);
				this.imageViewEl.insertBefore(this.beforeFullscreen.parentElement.children().get(this.beforeFullscreen.index));
			}
			$('body').css('overflow', 'visible');
			$('html').css('overflow', 'visible');
			window.scroll(this.beforeFullscreen.x, this.beforeFullscreen.y);
		}
		
	}
	
	
	
	ImageProfile_View.prototype.update = function() {
		//alert("UPDATE! ");
		
	}

		
		
	
	
	
	
	
	
	
	
	
	
	// ! SCRAP YARD
	
	
	
	
	function PlaceEntryView(el) {
		this.el = el;
		if (! this.el) {
			this.el = $('<div></div>');
		}
		this.el.dialog();
	
		this.el.append('<div>Enter a list of Place names.</div>');
		var textarea = $('<textarea></textarea>');
			
			this.el.append(textarea);
		
		var button = $('<button type="button">Process</button>');
			button.click(function() {
				var data = textarea.val();
				var lines = data.split('\n');
				$.each(lines, function(i) {
					var name = lines[i];
					var catnum;
					var paren;
					if ( name.indexOf('(') > 0) {
						
						name = name.substring( 0, name.indexOf('(')-1  );
						
						paren = lines[i].substring( lines[i].indexOf('(')+1, lines[i].indexOf(')') );
						catnum = paren.substring(paren.indexOf(' ')+1)
					}
					logit(name + "**" + catnum );
					
					
				});
			});
		this.el.append(button);
	
	}
	PlaceEntryView.prototype = {
		
	
	}








