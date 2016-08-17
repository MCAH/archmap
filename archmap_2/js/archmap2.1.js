	var dataStore;
	var thisUser;
	var loginPanel;
	var tickleTimer;
	
	var theLibraryView;

	 
	var ctrlPressed = false;
	var shiftPressed = false;
	
	
	var templates = new Object();

	Seadragon.Config.imagePath = '/js/seadragon-ui-img/'; // = 'http://seadragon.com/ajax/0.8/img/';
	Seadragon.Config.immediateRender = true;
	Seadragon.Config.zoomPerScroll = 1.08;
	Seadragon.Config.maxZoomPixelRatio = 1;
	Seadragon.Config.visibilityRatio = 1.0;
	Seadragon.Config.minZoomImageRatio = 2.0;

	
	var mapIconLarge = 'http://maps.google.com/mapfiles/marker.png';
	var mapIconSmall = 'http://labs.google.com/ridefinder/images/mm_20_red.png';

	// short term memory
	var recent_Building_style;
	var recent_NoteCard_cardtype;
	
	 

	 // support fullwindow for pano2vr_player based on: http://gardengnomesoftware.com/forum/viewtopic.php?f=6&t=7197
	 // This can go away once custom pano player is written
	   var wrap = function (functionToWrap, before, after, thisObject) {
	      return function () {
	         var args = Array.prototype.slice.call(arguments),
	            result;
	         if (before) before.apply(thisObject || this, args);
	         result = functionToWrap.apply(thisObject || this, args);
	         if (after) after.apply(thisObject || this, args);
	         return result;
	      };
	   };





	// SET IT ALL IN MOTION -- THE BIG START!!!
	
  	$(document).ready(function(){
	  	
	  	//alert(redirect_uri);
	  	
	  	
	  	
		dataStore = new DataStore();

		var thisUserData = $.jsper.get('thisUser');
		
		if (thisUserData) {
			logit ('YES USER');
			var attrs = $.jsper.get('thisUser').attrs;
			thisUser = new Model(attrs);
			dataStore.addModel(thisUser);
			logit(thisUser.attrs.name);
			tickle();
		} else {
			logit ('NO USER');
		}
		
		
		
		
		$(window).keydown(function(evt) {
		  if (evt.which == 17) { // ctrl
		    ctrlPressed = true;
		  } else if (evt.which == 16) { // ctrl
		    shiftPressed = true;
		    logit('shiftPressed = ' + shiftPressed);
		  }
		}).keyup(function(evt) {
		  if (evt.which == 17) { // ctrl
		    ctrlPressed = false;
		  } else if (evt.which == 16) { // ctrl
		   shiftPressed = false;
		    logit('shiftPressed = ' + shiftPressed);
		  }
		});
		

		


		$('.profileLink').live('click', requestProfileFromElement);
	//	$('.profileLink').live('hover', function() {$(this).css('color','blue')});
		
		var tmpls = $('.tmpl');
		tmpls.each(function() {
			logit($(this).attr('id'));
			templates[$(this).attr('id')] = $(this).html();
		});
		
		
		
		var sbv = new SearchBox_View();
		
		$("#subheader").append(sbv.element);

		
		
		
		// Which Page to Land On?
		
		var pathnameParts = window.location.pathname.split('/');
	  	//alert (pathnameParts[1]);

	  	//alert(landingEntity + ' --> ' + landingId);
		if (landingEntity && landingId) {
			request_ProfileView(landingEntity, landingId);
		} else {
			var recentEntity = $.jsper.get('recentEntity');
			var recentId = $.jsper.get('recentId');
			if (recentEntity) {
				request_ProfileView(recentEntity, recentId);
			}
		
		}
		
	});
	
	
	
	
	
	
	
	
	
	
	
	
	function loadTemplate(templateName, callback) {
		if (templates[_this.templateName]) {
			callback();
			return;
		}
		var pathroot = "/templates/";
		
		$.post(this.pathroot+templateName+'.html', { }, function(data) {
			templates[templateName] = data;
			callback();
		});

	}

	



	// ! **************** OPENING PROFILES
	var currentDialogPosition = [200, 0];

	function requestProfileFromElement() {
		var ident = getIdent( $(this) );
		logit('[select-item 2 ('+ident.entity+', '+ident.id+')]');
		request_ProfileView(ident.entity, ident.id)
	
	}
	function request_ProfileView(entity, id) {
		logit('Request for Profile made: (request_ProfileView) ' + entity + '::' + id);
		dataStore.getModel(entity, id, display_ProfileView);
	}
	
	
	
	
	function display_ProfileView(model) {
	
		logit('display model: ' + model.attrs.name);
		
		var entity 	= model.entity;
		var id 		= model.attrs.id;
		
		var profile = $('.profile.model-identity.entity-'+entity+'.model_id-'+id);

		if (profile && profile.length > 0) {
			logit('profile already open');
			profile.dialog("moveToTop");		// this profile is already open.
		
		} else {
			
			$.jsper.set('recentEntity', entity);
			$.jsper.set('recentId', id);
			
			
			
			// CREATE THE PROFILE
			var profileView;
			
			if (model.entity == "Image") {
				profileView = new ImageProfile_View(model);
			} else {
				profileView = new ModelProfile_View(model);

			} 			


			
			logit('ON CLICK shiftPressed = ' + shiftPressed);
			
			
			
			
			
			
			// OPEN PROFILE AS FULL PAGE
			if (model.entity != "Image" && ! shiftPressed) {
			
				// JUST TURN PAGE INSTEAD (REDIRECT)!
				//alert(model.entity + ":" + model.attrs.id + ": "+ landingEntity);
				
				
				// landing variables are set in the php page main.php
				if (! landingEntity ||  (landingEntity != model.entity && landingId != model.attrs.id) ) {

					//window.location = "/"+model.entity+"/"+model.attrs.id;

					
				} else {
				
					// SET PROFILE
					$('#fullpage').empty();
					$('#fullpage').append(profileView.element); 
					profileView.element.width($(window).width());
					return;
					
					
					// SET COLLECTION SIDE BAR
					
				}
				
				
							
			}
				
				
				
			// OPEN PROFILE IN DIALOG WINDOW
				
			var max_size = 600;
			var minWidth = 350;
			var dialogWidth = 1000;
			var dialogHeight = 600;
			
			var ratio = model.attrs.height /  model.attrs.width;
			
				currentDialogPosition[0] += 50;
				currentDialogPosition[1] += 50;
			var dialogPosition	= currentDialogPosition;
			
		
			if (entity == "Image") {
				// check image size and open window to same proportion
				
				if (model.attrs.image_type == "node" || model.attrs.image_type == "cubic") {
					
					dialogWidth = 500;
					dialogHeight = 500;
				} else {
				
					if (parseFloat(model.attrs.width) > parseFloat(model.attrs.height)) {
						dialogWidth = max_size;
						dialogHeight = max_size * ratio;
					} else {
					
						dialogHeight = max_size;
						dialogWidth = max_size / ratio;
						if (dialogWidth < minWidth) dialogWidth = minWidth;
						
					}
				
				}
				dialogHeight *= 1.19;
				dialogPosition = "right";
			}
			
			logit('OPENING DIALOG : '+ profileView.element);
			
			// OPEN DIALOG
			profileView.element.dialog({
				title: ''+model.entity + "    |    <b>" + model.attrs.name+'</b>',
				width: dialogWidth,
				height: dialogHeight,
				position: dialogPosition,
				closeOnEscape: true,
				resizable: true,
				resizeStart: function () {
					var mapView = profileView.element.find('div.map-view');
					if (mapView.length > 0) {
						mapView.data('viewController').saveState()
					}
					
				
				},
				resize: function(event, ui) {
					var mapView = profileView.element.find('div.map-view');
					if (mapView.length > 0) {
						mapView.data('viewController').resize();
					}
					profileView.setSize(profileView.element.css('width'), profileView.element.css('height'));
//					profileView.imagePlayer.toggleFullScreen();
					
				 },
				close: function() { 
					profileView.element.remove();
					
					var topDialog;
					var topZ = 0;
					var dialogs = $('div.ui-dialog');
					$.each(dialogs, function() {
						var zIndex = $(this).css('z-index');
						if (zIndex > topZ) {
							topDialog = $(this);
							topZ = zIndex;
						}
					});
					if (topDialog) {
						
						topDialog.focus();
					}
					
				}
			});
		}

		
		
	}




	function openLibraryService(requestingView, pubtype) {
			if (! theLibraryView) {
			
				theLibraryView = new Library_View(pubtype);
			}
			theLibraryView.setRequestingView(requestingView);
				
			theLibraryView.element.dialog({
				title: "Archmap Library Service",
				modal: true,
				width: 1200,
				height: 500,
				show: "fade",
				hide: "fade"
			
			});
			
			
	}
	function closeLibraryService() {
		theLibraryView.element.dialog("close");
	}







	// ! **************** USER MANAGEMENT


	
	
	function tickle() {
		logit('tickle');
		$.getJSON('/api', 
			{request:'tickle', session_id:thisUser.attrs.session_id}, function(data) {
				logit('tickle RESPONSE');
				if (data[0] && data[0].result && data[0].result == 'SUCCESS') {
					if ($('#loginButton').html() == "Login" ) {
						showUserLoggedIn();
						logit('showUserLoggedIn');
					}
					thisUser.timestamp = new Date();
					
					setTimeout( function() { tickle();  }, 600000); // every 10 minutes
				} else {
					thisUser.timestamp = null;
					showUserLoggedOut();
				}
		});
	}
	function loginButtonClicked() {
	
		if (loginPanel) loginPanel.remove();
		
		if ($('#loginButton').html() == "Logout" && thisUser && thisUser.attrs && thisUser.attrs.isLoggedIn) {
			// LOGOUT
			logit('logout called');
			$.getJSON('/api', 
				{request:'logout', session_id:thisUser.attrs.session_id}, function(data) {
					if (!data) {
						alert('Could not contact the server.');
						return;
					} else if (data[0] && data[0].result && data[0].result != "SUCCESS") {
						alert('logout: ' + data[0] && data[0].result);
						return;
					} 		
					logit('logout received');
					showUserLoggedOut();
					
					// stop tickle timer
			});
			return;
		} 
		var tmpemail = "";
		if (thisUser) {
			tmpemail = thisUser.attrs.email;
		}
		loginPanel = $('<div id="loginPanel"> <formset> <table><tr><td align="right">Email: </td> <td><input id="loginEmail" class="email" value="'+tmpemail+'" /></td></tr>  <tr><td>Password: </td> <td> <input id="loginPass" type="password" class="password" /></td></tr></table>  </formset></div>');
		
		loginPanel.dialog({
				title: "Archmap Login",
				width: 350,
				modal: true,
				show: "fade",
				hide: "fade",
				buttons: {
					Login: function() {
						var email = $('#loginEmail').val();
						var pword = $('#loginPass').val();
						if (!email) {
							alert("Please enter an email address.");
							return;
						}
						if (!pword) {
							alert("Please enter a password.");
							return;
						}
						

						var dialog = $(this);
						logit('?request=login&email='+email+'pword='+pword);
						$.getJSON('/api', 
							{request:'login', email:email, pword:pword}, function(data) {
								if (!data) {
									alert('Could not contact the server.');
									return;
								} else if (data[0] && data[0].result) {
									alert(data[0] && data[0].result);
									return;
								} 		
								thisUser = new Model(data);
								
								logit('Setting user');
								$.jsper.set('thisUser', thisUser);
								showUserLoggedIn();
								tickle();
								
								loginPanel.html('<center>Thank you for logging in!</center>');
								loginPanel.dialog('option', 'buttons', {
									    'Ok': function() {
									        myFunction();
									        $(this).dialog('close');
									    }
								});
								
								setTimeout( function() { loginPanel.dialog( "close" );  }, 700);
							});
					},
					Cancel: function() {$( this ).dialog( "close" ); }
				}
			}
		);
		setTimeout( function() { loginPanel.find('#loginEmail').focus().select();  }, 100);

		$('#loginPass').keypress(function(event) {
			if (event.which == '13') {
				$(".ui-dialog button:contains('Login')").click();
			} 			
		});
	}
	function showUserLoggedIn() {
		$('#loginButton').html('Logout'); 
		$('#headerUserButton').html(thisUser.attrs.name);
		$('#headerUserButton').click(function() {
			//getPage(thisUser);
			request_ProfileView('Person', thisUser.attrs.id);

		});
		$('#headerUserButton').show('fade');
	}
	function showUserLoggedOut() {
		thisUser.attrs.isLoggedIn = 0;
		$.jsper.set('thisUser', thisUser);

		$('#loginButton').html('Login'); 
		//$('#headerUserButton').html('Guest');
		$('#headerUserButton').hide('fade');
	}
	
	






	
	// ! ************** Utilities
	function windowResize() {
		$(".stage-height").css({height: $(window).height()-50});
		//$(".accordion-content").css({height: $(window).height()-400});
		
	}
	
	
	
	
	
	
	// ** GET_IDENT **
	
	function getIdent(el) {
	//	logit('[getIdent() CALLLED]');

		if (! el) {
			// logit ('[getIdent]: el is empty - ' +el);
			return;
		}

		// Return these values, if possible
		var fieldname, entity, id, from_entity, from_id, relationship;
		
		
		// establish these dom entities that cascade into the identity of an element
		var modelIdentityEl;
		var relationshipIdentityEl;
		var relationshipParentEl;
		
		// FIELDNAME
		fieldname 		= getClassItemWithPrefix(el, 'fieldname-');
		if (! fieldname) {
			fieldnameEl = el.parent();
			fieldname 	= getClassItemWithPrefix(fieldnameEl, 'fieldname-');
		}
		if (! fieldname) {
			fieldnameEl = el.parents('.fieldname:eq(0)');
			fieldname 		= getClassItemWithPrefix(fieldnameEl, 'fieldname-');
		}
		
		// MODEL-IDENTITY
		// The model-identity is simply the entity name and the id of a model.
		// The provided element may have its identityy within it. If not, look to the first parent that claims it holds the data
		// for the model-identity with in its class attribute.
		if (el.hasClass('model-identity')) {
			modelIdentityEl = el;
		} else {
			modelIdentityEl = el.parents('.model-identity:eq(0)');
		}
		if (modelIdentityEl) {
			entity 			= getClassItemWithPrefix(modelIdentityEl, 'entity-');
			id 				= getClassItemWithPrefix(modelIdentityEl, 'model_id-');
		}
		
		// RELATIONSHIP
		// In building relationships, the model will be added to its parent with a relationtionship typ.
		// FOr example, Publication->Person may be an 'author' or 'editor' or some other typ.
		// First check if the element passed to this function has a relationship specified in it.
		// If not, look up the stack.
		if (el.hasClass('relationship')) {
			relationshipIdentityEl = el;
		} else {
			relationshipIdentityEl = el.parents('.relationship:eq(0)');
		}
		if (relationshipIdentityEl && relationshipIdentityEl.attr('class')) {
			relationship 	= getClassItemWithPrefix(relationshipIdentityEl, 'relationship-');
		}
		
		// RELATED PARENT
		relationshipParentEl 		= el.parents('.relparent:eq(0)');
		if (relationshipParentEl) {
			from_entity 			= getClassItemWithPrefix(relationshipParentEl, 'entity-');
			from_id 				= getClassItemWithPrefix(relationshipParentEl, 'model_id-');
		}
		
		
		return {fieldname: fieldname, entity:entity, id:id, from_entity:from_entity, from_id:from_id,  relationship: relationship};
	}
	
	
	function getClassItemWithPrefix(el, prefix) {
		if (! el) {
			// logit ('[getClassItemWithPrefix]: el is empty');
			return;
		}
		if (! el.attr('class')) {
			// logit ('[getClassItemWithPrefix]: el has no class attribute: ' + el);
			return;
		}
		
		var classes = el.attr('class').split(/\s+/);
		for(var i = 0; i < classes.length; i++){
  			var className = classes[i];
  			if(className.indexOf(prefix) == 0){
    			return className.substr( className.indexOf('-')+1 );
 		 	}
		}
		return;
	}
	
		
	
	

	function clone(obj) {
	    if (null == obj || "object" != typeof obj) return obj;
	    var copy = obj.constructor();
	    for (var attr in obj) {
	        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
	    }
	    return copy;
	}

	function logObject(obj) {
	   
	    for (var attr in obj) {
	        logit ('attr['+attr+'] = '+ obj[attr]);
	    }
	   
	}




