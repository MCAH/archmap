







var thisUser;
var loginPanel;
var tickleTimer;

var selectedObject;

var talliable = true;


var x;
var y;

var editMode = false;

Seadragon.Config.imagePath = '/js/seadragon-ui-img/'; // = 'http://seadragon.com/ajax/0.8/img/';
Seadragon.Config.immediateRender = true;
Seadragon.Config.animationTime = 3;
Seadragon.Config.zoomPerScroll = 1.08;
Seadragon.Config.zoomPerClick = 1.0;
Seadragon.Config.maxZoomPixelRatio = 1;
Seadragon.Config.visibilityRatio = 1;
Seadragon.Config.minZoomImageRatio = 2.0;


var currentElement;
var currentlyEditing_entity = "None"
var currentlyEditing_id = 0;
			
// ! --------- DOM MANIPULATORS	------------------------------------------------------
	
	
	
	
	
	
// SEADRAGON
	
	
	
	DraggableOverlayMouseTracker.prototype = new Seadragon.MouseTracker();
	DraggableOverlayMouseTracker.prototype.constructor = DraggableOverlayMouseTracker;

   function DraggableOverlayMouseTracker(element, viewer)
      {
      Seadragon.MouseTracker.call(this, element);
      this.viewer = viewer;
      this.theElement = element;

      this.pressHandler = function(tracker, position)
         {
         console.log(" SEADRAGON PRESSED!");
         this.viewer.setMouseNavEnabled(false);

         // remember where the widget was originally drawn
         this.elementHalfDimensionsInPixels = Seadragon.Utils.getElementSize(this.theElement).divide(2);
         var topLeftCorner = Seadragon.Utils.getElementPosition(this.theElement).minus(Seadragon.Utils.getElementPosition(this.viewer.elmt));
         this.elementLocationInPixelCoords = topLeftCorner.plus(this.elementHalfDimensionsInPixels);
         };

      this.dragHandler = function(tracker, position, delta, shift)
         {
         this.elementLocationInPixelCoords = this.elementLocationInPixelCoords.plus(delta);

         var originalLocationInPointsCoords = viewer.viewport.pointFromPixel(this.elementLocationInPixelCoords);
         var dimensionsInPixelCoords = Seadragon.Utils.getElementSize(this.theElement);
         var dimensionsInPointsCoords = viewer.viewport.deltaPointsFromPixels(dimensionsInPixelCoords);
         var halfDimensionsInPixelCoords = dimensionsInPixelCoords.divide(2);
         var halfDimensionsInPointsCoords = viewer.viewport.deltaPointsFromPixels(halfDimensionsInPixelCoords);

         var topLeftInPointsCoords = originalLocationInPointsCoords.minus(halfDimensionsInPointsCoords);
         var boundsRectInPointsCoords = new Seadragon.Rect(
               topLeftInPointsCoords.x,
               topLeftInPointsCoords.y,
               dimensionsInPointsCoords.x,
               dimensionsInPointsCoords.y);
         this.viewer.drawer.updateOverlay(this.theElement, boundsRectInPointsCoords);
         };

      this.releaseHandler = function(tracker, position, insideElmtPress, insideElmtRelease)
         {
         if (!insideElmtPress)
            {
            return;         // ignore releases from outside
            }

         this.elementLocationInPixelCoords = null;

         this.viewer.setMouseNavEnabled(true);
         };
      }

   $.ajaxSetup({
      type: 'GET',
      dataType: 'jsonp',
      timeout: 3000,
      cache: false,
      global: false
   });	
	
	
	
	
			
function addSeaDragonOverlays(viewer) {
	
	
}












// ! ADD SEADRAGON VIEWER
var sd_beforeFullscreen;	




function addSeadragonViewer(el) {
	logit("--- adding viewer to " + el.attr("data-id"));
	
	var image_id = el.attr("data-image_id");
	
	if (el.attr("data-has_sd_tiles") == 2) {		
		url = "/fcgi-bin/iipsrv.fcgi?DeepZoom=/home/tiles/"+el.attr("data-image_id")+"_full.tif.dzi";	// use the DeepZoom server				
	} else {
   	 	logit("+++++++ filesys " + el.attr("data-filesystem"));
		if (el.attr("data-filesystem") == "B") {
    		url = '/archmap/media/images/'+el.attr("data-filename") +'_tiles/'+ el.attr("data-image_id") + '.xml';	
    	} else {
    		if (el.attr("data-filename")) {
				url = '/archmap/media/buildings/001000/'+el.attr("data-filename").substring(0,4) +'/seadragon/'+el.attr("data-filename").replace("_w.jpg","") + '.xml';	
				logit("+++++++ URL " + url);
    		} else {
	    		
	    		return;
    		}
 		}		
	}
	logit("addSeadragonViewer: " + url);
	
	var  imageArea = el.find(".imageViewer");
	if (! imageArea || imageArea.length == 0) imageArea = el;
	

	imageArea.css("width", "100%");
	imageArea.css("height", "100%");
	
	var viewer = new Seadragon.Viewer(imageArea[0]);	
	
	viewer.addEventListener("open", addSeaDragonOverlays);

	viewer.openDzi(url);  
	

	logit("CREATED SEA DRAGON VIEWER 1: " + viewer);
	el.data("viewer", viewer);

	imageArea.droppable({
		 accept: ".drag-icon",
		 activeClass: "ui-state-default",
		 drop: function( event, ui ) {
		 	var pixel = Seadragon.Utils.getMousePosition(event).minus(Seadragon.Utils.getElementPosition(viewer.elmt));
		 	var point = viewer.viewport.pointFromPixel(pixel);
		 	
		 		
		 	logit("!!!!!!!!!!!!!!!!!! viewer = " + viewer);
		 	
		 	addFeatureToSeadragon(viewer, point, ui.draggable.data("entity"), ui.draggable.data("id"), ui.draggable.data("name"));

		 	savePlotOnImage(image_id, ui.draggable.data("entity"), ui.draggable.data("id"), point);
	
		}
	});

	viewer.addEventListener("resize", function() {
		
		if (viewer.isFullPage()) {
			//expandDiv(el);
			//beforeFullscreen = { x: $(window).scrollLeft(), y: $(window).scrollTop() };
			
		} else {
			//resetDiv(el);
			window.scroll(sd_beforeFullscreen.x, sd_beforeFullscreen.y);
		}
	});

	viewer.addEventListener("open", function() {
		var zoomSettingsDefaultForPanos = (el.data("fov") == "70");
		if (! zoomSettingsDefaultForPanos) {
			if (el.data("pan") && el.data("tilt") && el.data("pan") != "undefined" && el.data("tilt") != "undefined") {
				var centerPoint = new Seadragon.Point(el.data("pan"), el.data("tilt"));
				logit("centerPoint :::: "+ el.data("pan"));
				viewer.viewport.panTo(centerPoint, true);		
			}
			if (el.data("fov") && el.data("fov") != "undefined" ) {
				viewer.viewport.zoomTo(el.data("fov"), false);
			}
		}
		sd_beforeFullscreen = { x: $(window).scrollLeft(), y: $(window).scrollTop() };
		
		
		
		
		
		
		// plot OLD MGF images
		logit(" ----------------------------------------> IMAGE PLOTS ");
			/*
			var data = {
						request:	'getOldImagePlotsForImageid',  
						id:			el.attr("data-image_id"), 
					}
		
				$.each( data, function( key, value ) {
				  logit( "image_plots : " + key + ": " + value );
				});	
		
				$.ajax({
				    type: 'POST',
				    dataType:"json", 
				    url: '/api',
				    data: data,
				    success: function(json_data) {
				       
				        
				        
				        $.each(json_data, function(k, image){
				         	//logit('image plots: pos_x=' + image["pos_x"]);
					        addImageToSeadragon(viewer, image);
					        
				        });
				        
				        
				    }
				});		
			*/	

		
	});
	

	Seadragon.Utils.addEvent(imageArea[0], "mousedown", function(event) {
	logit("Mouse down on seadragon");
		sd_beforeFullscreen = { x: $(window).scrollLeft(), y: $(window).scrollTop() };
	});
	
	Seadragon.Utils.addEvent(imageArea[0], "mousewheel", function(event) {
		/*
		mouseDownPos = Seadragon.Utils.getMousePosition(event);		

		if (! mouseDownPrev ||  mouseDownPrev.x != mouseDownPos.x ||  mouseDownPrev.y != mouseDownPos.y ) {
			mouseDownPrev = mouseDownPos;
			var panToPixel = mouseDownPos.minus(Seadragon.Utils.getElementPosition(viewer.elmt));		
			panToPixel.y += $("#allImages").scrollTop();
			panToPoint = viewer.viewport.pointFromPixel(panToPixel);
			
		}
		logit(mouseDownPos.toString() + " " + $("#allImages").scrollTop() + " --- " + panToPoint);
		
		viewer.viewport.panTo(panToPoint);
		*/
	}); 
	
	el.find(".set-view").click(function() {
		saveImagePanAndZoom(el, viewer);
	});
 	
 	logit("CREATED SEA DRAGON VIEWER 2: " + viewer);


	return viewer;      
}





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


// placeholde to return to spot on page
var beforeFullscreen;
var imageWindowWasOpen = false;
function expandDiv(el) {
	if ( ! el.hasClass('fullscreen'))
	{         
		imageWindowWasOpen = imageWindow.dialog( "isOpen" );
		imageWindow.dialog("close");
		
		 el.addClass('fullscreen');
		 beforeFullscreen = {
		    parentElement: el.parent(),
		    index: el.parent().children().index(el),
		    x: $(window).scrollLeft(), y: $(window).scrollTop()
		 };
		 // block page scrolling
		 //$('html').css('overflow', 'hidden');
		 $('body').css('overflow', 'hidden');
		 
		 // move el directly to body
		 $('body').append(el).css('overflow', 'hidden');
		 //window.scroll(0,0);
		 $(window).scrollTop(0);
		 
		 
		 
	} 
}

function resetDiv(el) {
	
	if (el.hasClass('fullscreen')) {  
	
	       
		el.removeClass('fullscreen');
		if (beforeFullscreen.index >= beforeFullscreen.parentElement.children().length) {
			beforeFullscreen.parentElement.append(el);
		} else {
			el.insertBefore(beforeFullscreen.parentElement.children().get(beforeFullscreen.index));
		}
		$('body').css('overflow', 'visible');
		$('html').css('overflow', 'visible');
		window.scroll(beforeFullscreen.x, beforeFullscreen.y);
		
		if (imageWindowWasOpen == true) {
			imageWindow.dialog("open");
		}
		imageWindowWasOpen = false;
	}
}










function addImageToSeadragon(viewer, image) {

 	var img = $('<img class="sd-icon" style="opacity:.75;width:16; height:16;" src="/archmap_2/media/ui/CircleIcon.png" data-entity="Image" data-id="'+image.id+'" title="'+image.title+'" />');
	
	img.tooltip({
		track: true,
		tooltipClass: "tooltip-item" ,
		position: { my: "left+25 center", at: "right center" },
		content: function() {
			var retEl = $('<div> ' + image.title + ' <div> <img src="'+ image.url300 +'" width=300 height=300 /></div></div>');
			return retEl;
		}		
	});
	
	var placement = Seadragon.OverlayPlacement.CENTER;
	var point =  new Seadragon.Point(parseFloat(image.pos_x), parseFloat(image.pos_y)-.25);
	
logit(image.pos_x + ", " + image.pos_y + " -- " + point.x);
	var overlay = viewer.drawer.addOverlay(img[0], point, placement);


	viewer.drawer.update();


}


function addFeatureToSeadragon(viewer, point, entity, id, name) {
	var imageEntityEl = $(viewer.elmt).closest("[data-entity]");
	var image_id = imageEntityEl.data("id");


	var placement = Seadragon.OverlayPlacement.CENTER;
	
	
	var c = $('<canvas width="500" height="500"></canvas>');
	var context = c[0].getContext('2d');
	context.beginPath();
	context.moveTo(0, 0);
	context.lineTo(450000, 50000);
	context.lineTo(50000, 45000);
	context.strokeStyle = '#ff0000';
	context.lineWidth = 25;
	 context.closePath();
	 
	  context.fillStyle = '#ffcccc';
      context.fill();
	context.stroke();
	

	/*
	var paper = Raphael(100, 150, 320, 200);
	var circle = paper.circle(50, 40, 10);
	circle.attr("fill", "#f00");
	circle.attr("stroke", "#fff");
	*/
      
      
      
	//var img = document.createElement("img");
 	var img = $('<img class="sd-icon" style="opacity:.75;width:16; height:16;" src="/archmap_2/media/ui/CircleIcon.png" data-entity="'+entity+'" data-id="'+id+'" title="'+name+'" />');
    //img.src = ;
	
	var imageSrc;
	if (entity == "Building") 
	{
			var len = bldgs.length;
			for (var i = 0; i<len; i++) {
			
				
				if(bldgs[i].id == id)
				{
					imageSrc = bldgs[i].poster_url300;
					console.log(bldgs[i].name);
					console.log(bldgs[i].poster_url300);
				}
				
			 
			}	
				
		
	} else if  (entity == "Feature"){
	
			var len = features.length;
			for (var i = 0; i<len; i++) {
			
				
				if(features[i].id == id)
				{
					imageSrc = features[i].poster_url300;
					console.log(features[i].name);
					console.log(features[i].poster_url300);
				}
				
			 
			}	
	
	/*
		var tmp = $('.entity-profile[data-entity="'+entity+'"][data-id="'+id+'"]');
		var gallery = tmp.find('.item-gallery');
		var enlargeEl = gallery.find('.image-view-thumbnail');
		firstImage = gallery.children(":first").find("img");
		imageSrc = firstImage.attr('src').replace("100", "300");
		*/
	}
	
	
	
	
	// MOUSE OVER
	img.tooltip({
		track: true,
		tooltipClass: "tooltip-item" ,
		position: { my: "left+25 center", at: "right center" },
		content: function() {
			var retEl = $('<div> ' + name + ' <div> <img src="'+ imageSrc +'" width=300 height=300 /></div></div>');
			return retEl;
		}		
	});
	
	
	// DOUBL-CLICK
	img.dblclick(function() {
		//enlargeFigure(enlargeEl);
		//window.location = "/archmap_2/Site/Collection?site="+site_id+"&building_id=" + id;
	});
	img.bind('mousedown', function() {
		if(! editMode)
		{
			if (entity == "Feature"){
				window.location = "/archmap_2/Site/Collection?site="+site_id+"&entity="+entity+"&id=" + id;
			}
			else{
				window.location = "/archmap_2/Site/Collection?site="+site_id+"&building_id=" + id;
			}
		}
			
	});


	// Keep viewer from panning when dragging a Feature icon
	var center;
	
	//logit("point " + point);
	var overlay = viewer.drawer.addOverlay(img[0], point, placement);
	//var overlay2 = viewer.drawer.addOverlay(paper[0], new Seadragon.Rect(.5,.5,.2,.2));
	//var overlay3 = viewer.drawer.addOverlay(c[0], new Seadragon.Rect(.5,.5,.01,.01));
	
	
	
	
	img.draggable({
		start: function() {
	    	
	    	center = viewer.viewport.getCenter();
		},
		drag: function() {
			viewer.viewport.panTo(center);
			
		 	var newPixel = new Seadragon.Point(x, y).minus(Seadragon.Utils.getElementPosition(viewer.elmt));
		 	var newPoint = viewer.viewport.pointFromPixel(newPixel);
		 	viewer.drawer.updateOverlay(img[0],newPoint, placement);
		 	console.log(newPoint.x + " " + newPoint.y);
		},
	
	   stop: function() {
		
		 	var newPixel = new Seadragon.Point(x, y).minus(Seadragon.Utils.getElementPosition(viewer.elmt));
		 	var newPoint = viewer.viewport.pointFromPixel(newPixel);
		 	console.log(newPoint);
		 	viewer.drawer.updateOverlay(img[0],newPoint, placement);
		 	savePlotOnImage(image_id, entity, id, newPoint);
		}
	});
	
	viewer.drawer.update();
	
}

function savePlotOnImage(image_id, entity, id, point, subtype) {
	logit ("saving plot: "+image_id+", "+entity+", "+id+", "+point);
	
	
		data= {};
		
		data['request'] 		= 'saveRelationChanges';
	//	data['session_id']		= thisUser.session_id;

		data['from_entity'] 	= "Image";
		data['from_id'] 		= image_id;
		
		data['to_entity'] 		= entity;
		data['to_id'] 			= id;
		
		data['pos_x'] 			= point.x;
		data['pos_y'] 			= point.y;
		
		data['relationship'] 	= "plot";

			
		
		
		$.post('/api', data, function(json_data) {
				logit("plot saved");
			});
	
}





















// ! * PANO_VIEWER
function addPanoViewer(el, cube_size) {
	
	
	
	if(! cube_size) cube_size = 1024;


	el.find(".click-zoom").removeClass("click-zoom");
	
	var  imageAreaEl = el.find(".imageArea");

	if (! imageAreaEl || imageAreaEl.length == 0) imageAreaEl = el;

    imageAreaEl.css('width',  "100%");
	imageAreaEl.css('height', imageAreaEl.css('width'));	

	imageAreaEl.empty();
	imageAreaEl.addClass("interactive");


	// INSTANTIATING PANO2VR
	//var imagePlayer = new pano2vrPlayer('image-viewer-'+el.data("id"));	
	var imagePlayer = new pano2vrPlayer(imageAreaEl.attr("id"));	

	
	imagePlayer.setFullscreen = wrap(imagePlayer.setFullscreen, function (toFullscreen) {
		logit('setFullscreen: ' + toFullscreen);
		if (toFullscreen)
			expandDiv(imageAreaEl);
		else {
			resetDiv(imageAreaEl);	
		}			
	});	

	var tiles = new Array();
	
	//var cube_size = 1024;
	 
	var fullfile = '/archmap/media/images/'+el.data("filepath") +'_full.jpg';
	
	
						
	logit("addPanoVIewer :: fullfile = " + fullfile + ' has_sd_tile='+el.data("has_sd_tiles"));
	
	if (el.data("has_sd_tiles") == 3) 
	{
		var cubeUrl = '/archmap/media/images/'+el.data("filepath") + '_face_' + cube_size + "_";
		
		tiles[0] = cubeUrl+'0'; // front
		tiles[1] = cubeUrl+'1'; // right
		tiles[2] = cubeUrl+'2'; // back
		tiles[3] = cubeUrl+'3'; // left
		tiles[4] = cubeUrl+'4'; // top
		tiles[5] = cubeUrl+'5'; // bottom
		
		//alert('tiles[0]='+tiles[0]);
	}
	else
	{
			
		var cubeUrl = '/archmap_2/php_utils/cubic_image.php?imagedata='+el.data("filepath") + '--' + cube_size + "--";
		
		tiles[0] = cubeUrl+'front';
		tiles[1] = cubeUrl+'right';
		tiles[2] = cubeUrl+'back';
		tiles[3] = cubeUrl+'left';
		tiles[4] = cubeUrl+'top';
		tiles[5] = cubeUrl+'bottom';
		
	}
	
	
	
	var configString = '<panorama><view fovmode="0"><start pan="0" tilt="15" fov="70"/><min pan="0" tilt="-90" fov="5"/><max pan="360" tilt="90" fov="120"/></view><input tilesize="1000" tilescale="1.01" tile0url="'+tiles[0]+'" tile1url="'+tiles[1]+'" tile2url="'+tiles[2]+'" tile3url="'+tiles[3]+'" tile4url="'+tiles[4]+'" tile5url="'+tiles[5]+'" /><control sensitifity="125" simulatemass="1" lockedmouse="0" lockedkeyboard="0" lockedwheel="0" invertwheel="1" speedwheel="1" invertcontrol="1" /></panorama>';
	imagePlayer.readConfigString(configString);			

	imagePlayer.setPan(el.data("pan")+10);
	
	imagePlayer.setTilt(el.data("tilt")-20);
	
	
	
	imagePlayer.setFov(el.data("fov")+10);

	var timer;
	var speed = .4;
	setTimeout(function() {
		timer = setInterval(function() {
			
			if (imagePlayer.getFov() < el.data("fov"))
				clearInterval(timer);
			
			
			imagePlayer.setPan(imagePlayer.getPan()-speed);
			imagePlayer.setTilt(imagePlayer.getTilt()+(2*speed));
			imagePlayer.setFov(imagePlayer.getFov()-speed);
			
			speed *= .93;
			if (speed < .03) speed = .03;
		}, 50);
	
	}, 500);
	
		//var canvasEl = this.imageViewEl.find('#viewport').find('canvas');
		//var canvas = canvasEl[0];
				
				
	// __CONTROL PANEL__
	
	var fullpageButtonEl = $('<img class="fullpageButton" src="/archmap_2/js/seadragon-ui-img/fullpage_rest.png"  />');
	//var imageViewNoteButtonEl = $('<img class="fullpageButton" src="/archmap_2/js/seadragon-ui-img/fullpage_rest.png"  />');
	
	var viewport = imageAreaEl.find('#viewport');
	var viewer = imageAreaEl.find('#viewer');
	
	viewport.append(fullpageButtonEl);
	//viewport.append(imageViewNoteButtonEl);

	var controlPanelTimeout;
	
	fullpageButtonEl.mousedown(function(){
		logit("fullpageButtonEl::mousedown");				
		if (imageAreaEl.hasClass('fullscreen')) {
			imagePlayer.setFullscreen(false);
		} else {
			imagePlayer.setFullscreen(true);
			$('html').css('overflow', 'visible');
		}
		
	});
	/*
	fullpageButtonEl.mousedown(function(){
		logit("imageViewNoteButtonEl::mousedown");				
		alert('Write a note');
		
	});
	*/
	
	/*
	
	fullpageButtonEl.mouseover( function() {
		clearTimeout(controlPanelTimeout);
	});
	
	fullpageButtonEl.hide();
	
	
	viewport.mouseover( function() {
		fullpageButtonEl.show();
		clearTimeout(controlPanelTimeout);
	});
	viewport.mouseout( function() {
		controlPanelTimeout = setTimeout(function(){
				fullpageButtonEl.fadeOut("slow");
			}, 650);	    			
	});
	
*/

	el.find(".set-view").click(function() {
		saveImagePanAndZoom(el, imagePlayer);
	});


	return imagePlayer;
	
}



 




function rand(length,current){
 current = current ? current : '';
 return length ? rand( --length , "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz".charAt( Math.floor( Math.random() * 60 ) ) + current ) : current;
}


function insertHTMLAtCursor(htmlElement) { 
    var sel, range, html; 
    sel = window.getSelection();
    
    if (sel == null || sel.rangeCount == 0) return;
    
    range = sel.getRangeAt(0); 
    range.deleteContents(); 
   // var htmlNode = $(htmlString);
    range.insertNode(htmlElement[0]);
	range.setStartAfter(htmlElement[0]);
    sel.removeAllRanges();
    sel.addRange(range);        
}

function insertHTMLAtSelection(sel, htmlElement) { 
    var range, html; 
    
    range = sel.getRangeAt(0); 
    range.deleteContents(); 
   // var htmlNode = $(htmlString);
    range.insertNode(htmlElement[0]);
	range.setStartAfter(htmlElement[0]);
    sel.removeAllRanges();
    sel.addRange(range);        
}

function getTextSelection() {
	
	var sel = window.getSelection();
	
	return sel;
}

function getCharsBeforeCursor() {
    var range = window.getSelection().getRangeAt(0);
    if (range.collapsed) {
        text = range.startContainer.textContent.substring(3, range.startOffset+1);
        return text.split(/\b/g).pop();
    }
    return '';
}


var imageWindow;

var shiftKey = false;


// ! INIT
$( document ).ready(function() {

	initializeMap();
	
	logit(" ---- DOCUMENT READY ------ in archmap.3.1 --------------------------------------------------------------------------- ");


	
	$(".edit-mode-only").hide();
	$("#wysiwyg-text-edit-menu").css({left:-1000});


	// SHIFT KEY
	
	$(document).bind('keyup keydown', function(e){ 
		logit("SHIFT: "+ e.shiftKey); 
		shiftKey = e.shiftKey
	});
	
	
	
	
	imageWindow = $('<div id="imageWindow"></div>');
	imageWindow.dialog({ autoOpen: false, 
						dialogClass:'fixed-dialog', 
						modal: false,
						open: function() { $(".ui-dialog").addClass("ui-dialog-shadow"); }
						});
	
	
	var thisUserData = $.jsper.get('thisUser');
	
	if (thisUserData) {
		logit ('YES USER');
		thisUser = $.jsper.get('thisUser');
		tickle();
	} else {
		logit ('NO USER');
	}
		


	if ( $_GET("monumentsScrollTop") != "") {
		$(".monument-list").scrollTop($_GET("monumentsScrollTop"));
		
	}




	
	var keymap = [];
	
	// cmd-e -- go to edit mode
	$(document.body).keydown(function (e) {
            if (e.keyCode == 69) {
                if (e.metaKey) {
                    //logit("toggle edit");
                    e.preventDefault();
                    
                    
                    
                    if (thisUser && thisUser.isLoggedIn) {
	                     toggleEditMode();
                    } else {
	                    raiseLogin();
                    }
                   
                }
            }
	});
	
	
	    
    
	$(document).mousemove(function (e) {
        x = e.pageX;
        y = e.pageY;
    });
    
    
    $('.search-field').liveSearch({url: '/api?request=search&collection='+$('.search-field').attr('data-collection')+'&searchString='});
    










	var allImagesImmediate = $(".allImagesImmediate");
	if (allImagesImmediate[0]) 
	{
		openImageGalleryOnPage(allImagesImmediate);
	}
	






	// SET UP DROP_ZONE 
	Dropzone.autoDiscover = false;
	
	
	//$( ".list-item-tip" ).tooltip({
	//			track: false,
	//			tooltipClass: "tooltip-item"	  		
	//			});
	 /*
	 $( document ).tooltip({
      		items: ".list-item",
      		tooltipClass: "tooltip-item",	
      		position: { my: "left+25 center", at: "right center" },	
	  		content: function() {
			
				var retEl = $('<div >HELLO  </div>');
				return retEl;
			}		
		});
	*/	
	
	
	// DRAG DROP
	
	 $( ".drag-icon" ).draggable({
	 	opacity: 0.7,
	 	cursorAt: { top: -12, left: -12 }, 
	 	
		start: function() {
			
		},
		drag: function(event, ui) {
			
			if (document.caretRangeFromPoint) {
				range = document.caretRangeFromPoint(event.clientX, event.clientY);
				textNode = range.startContainer;
				
				//offset = range.startOffset;
				//logit("offset: " + offset);
				
				if(textNode)
				{					
					var sel = window.getSelection();
					sel.removeAllRanges(); 
					sel.addRange(range);
				}
					
			}
				
		},
		stop: function() {
		//alert("dropped");
		}
    });

	$(".text-figure-droppable").droppable({
		accept: ".drag-icon",
		activeClass: "valid-draggable",
		drop: function(event, ui) {
			logit("Add figure ref to text! ");
			
			
			if (document.caretRangeFromPoint) {
				range = document.caretRangeFromPoint(event.clientX, event.clientY);
				textNode = range.startContainer;
				parentElement = textNode.parentElement;
				
				logit("parentElement "+$(textNode).html());
				offset = range.startOffset;
				logit("range.startContainer: " + textNode.nodeValue);
				
				
				var linkText = '<a class="text-figure-link" data-entity="ImageView" rel="figure" data-id="' + ui.draggable.data("id") + '" data-pan="' + ui.draggable.data("pan") + '" data-tilt="' + ui.draggable.data("tilt") + '" data-fov="' + ui.draggable.data("fov") + '">(Fig. <span class="fig-num">' + ui.draggable.data("id") + '</span>)</a>';
				
				
				var sel = window.getSelection();
				
				//var range = document.getSelection().getRangeAt(0);
				var nnode = document.createElement("span");
					range.surroundContents(nnode);
					nnode.innerHTML = linkText;

			}
			
			event.preventDefault();
			
		}	
		

	});

	$(".droppable-listitem").droppable({
		accept: ".image-draggable",
		activeClass: "valid-draggable",
		drop: function(event, ui) {
		
			//alert("dropped an image! change " + $(this).data("id") + " to " + ui.draggable.data("id")+  ", type="+ui.draggable.data("filename"));
			var _this =  $(this);
			var from_entity = $(this).attr("data-entity");
			var from_id 	= $(this).attr("data-id");	
			var relationship = $(this).attr("data-relationship");
			logit("relationship: " + relationship);
			
			var to_entity =	ui.draggable.data("entity");
			var to_id	  = ui.draggable.data("id");
			
			
			addItemToList(from_entity, from_id, to_entity, to_id, relationship, function(){
				logit("Item added");
				
				var note = $('<div style="color:blue;">'+from_entity+' added!</div>');
				
				_this.append(note);
				
				setTimeout(function(){
					 note.fadeOut( "slow", function() {
						 	// Animation complete.
					});
				}, 500);				
				
			});
		}
	});
	
	$(".image-droppable").droppable({
		accept: ".image-draggable",
		activeClass: "valid-draggable",
		drop: function(event, ui) {
		
			//alert("dropped an image! change " + $(this).data("id") + " to " + ui.draggable.data("id")+  ", type="+ui.draggable.data("filename"));
			
			$(this).attr("data-id", 				ui.draggable.data("id"));
			$(this).attr("data-image_type", 		ui.draggable.data("image_type"));
			$(this).attr("data-filesystem", 		ui.draggable.data("filesystem"));
			$(this).attr("data-filepath", 			ui.draggable.data("filepath"));
			$(this).attr("data-filename", 			ui.draggable.data("filename"));
			
			if (ui.draggable.data("image_id"))
				$(this).attr("data-image_id", 		ui.draggable.data("image_id"));
			else
				$(this).attr("data-image_id", 		ui.draggable.data("id"));

			$(this).attr("data-has_sd_tiles", 		ui.draggable.data("has_sd_tiles"));
			$(this).attr("data-pan", 				ui.draggable.data("pan"));
			$(this).attr("data-tilt",				ui.draggable.data("tilt"));
			$(this).attr("data-fov", 				ui.draggable.data("fov"));
			
			$(this).find("[data-id]").attr("data-id", 				ui.draggable.data("id"));
			
			var imageArea = $(this).find("imageArea");
			imageArea.attr('id', "image-viewer-"+ui.draggable.data("image_id"));
			logit("SO: " + $(this).attr("data-id") );
			
			var player;
			if (ui.draggable.data("image_type") == "cubic" || ui.draggable.data("image_type") == "node") {
				player = addPanoViewer( $(this) );
			}
			else {
				logit("ADD SEADRAGON VIEWER (.image-droppable)");
				player = addSeadragonViewer( $(this) );
			}
			
			var entityEl = $(this).closest(".entity-profile");
			
			saveChanges(entityEl.attr("data-entity"), entityEl.attr("data-id"), $(this).attr("data-fieldname"), $(this).attr("data-image_id")); 
			
		}
	});


	
	$( ".tooltip-default" ).tooltip({
				track: false,
				tooltipClass: "tooltip-item"	  		
				});

	// FOOTNOTE
	
	
	// ! LINK: ADD FIGURE TO ITEM GALLERY BUTTON
	$(document).on("mousedown", '.addFootnoteButton', function(event) {

	
	   logit("ADD FOOTNOTE");
       var fnid = rand(12);
	   
	   var footnoteLink = $('<a id="fnref_'+fnid+'" href="#fn_'+fnid+'" class="footnoteLink" rel="footnote">1</a>');
 
      
       insertHTMLAtCursor(footnoteLink);
 
       var div = $(document.activeElement);
       var ol = div.find('ol.footnotes');
       if (! ol.length) {
	     // create
	     ol = $('<ol class="footnotes"></ol>');
	     div.append(ol);  
       } 
       //ol.append('<li id="fn_'+fnid+'"><p> Note <a href="#fnref_'+fnid+'" rev="footnote">&</a></p></li>');
       
       
       ol.append('<li id="fn_'+fnid+'"><p>Note</p></li>');
       
      
       
	   tallyFootnotes();
    });	
    
    
    $("a[rel|='footnote']" ).bind("mouseover", overFootnote);
	$("a[rel|='footnote']" ).bind("mouseout", closeFootnote);
		
	$('.footnoteLink').bind("destroyed", function(){
	  alert('destroy');
	})		
		
	// ! EDITMODE -- DEACTIVATE PASSAGES INLINE EDITING
	$("#headerEditButton").on("click", function(){
	
		toggleEditMode();
	
	});
	

	function toggleEditMode() {
	
		if (editMode) {
			editMode = false;
			$(".edit-mode-only").hide();
			
			
			
			
			
			$("#wysiwyg-text-edit-menu").css({left:-1000});
			
			$('#headerEditButton').text("Edit");
			
			$('.editable').each(function() {
				setEditable($(this), false);
			});
			
			
			var passages = $(".passage");
			passages.each(function () {
				var text =  $(this).find('.editable').text();
				
				if ( text == "edit") {
					$(this).hide();
				};
				
			});
			
			
			$("a[rel|='footnote']" ).bind("mouseover", overFootnote);
			$("a[rel|='footnote']" ).bind("mouseout", closeFootnote);








		} else {
			// ! EDITMODE -- ACTIVATE PASSAGES INLINE EDITING
			
			// SET TO EDIT MODE
			// -- Show and enable buttons
			// -- Enable editable text fields
			
			editMode = true;
			
			
			// To show items only visible in editmode, simple add the class ".edit-mode-only"
			$(".edit-mode-only").show();
			
			
			$('#headerEditButton').text("Viewer");
			

			
			
			$(".passage").show();
			
			$('.editable').each(function() {
				setEditable($(this), true);
			});
			
			$("a[rel|='footnote']" ).unbind("mouseover", overFootnote);
			
								
								
			// GALLERY MENU
			//$(".item-gallery .gallery.menu").append('<img class="addGalleryItemButton        new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 />');
								
			//$(".item-gallery .image.menu"  ).append('<img class="removeGalleryItemButton  delete button"  src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 />');
								
			
			// LIST BLOCK MENU
			//$(".list-block-label").append('<img class="addButton new button" title="Add an item to this list" src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 />');
			
				
			
			// BUTTON APPEARENCE // 
			
			// CLICKS
			$('.menu, .button.new').mousedown(function() {
			      $(this).attr('src','/media/ui/buttons/ButtonPlusDown.png');
			    });
			$('.menu, .button.delete').mousedown(function() {
			      $(this).attr('src','/media/ui/buttons/ButtonMinusDown.png');
			    });
			
			// HOVERS
			$('.menu .button.new').hover(
			    function(){
			      $(this).attr('src','/media/ui/buttons/ButtonPlusHover.png')
			    },
			    function(){
			      $(this).attr('src','/media/ui/buttons/ButtonPlusNormal.png')
			    }
			);	
			$('.menu .button.delete ').hover(
			    function(){
			      $(this).attr('src','/media/ui/buttons/ButtonMinusHover.png')
			    },
			    function(){
			      $(this).attr('src','/media/ui/buttons/ButtonMinusNormal.png')
			    }
			);
			
			
			
			
			
			
			
			
			
			
			
			







			// TOOLTIP TITLES ...
			
			$.each($(".button"), function() {
				logit(" button: " + $(this).attr("class"));
				
				if($(this).hasClass("tooltip-default"))
					return true;
				
				var entityEl = $(this).closest("[data-entity]");
				
				
				var itemName = entityEl.data("entity");
				if (itemName == "Feature") {
					if (entityEl.data("subtype")) itemName = entityEl.data("subtype");
				}
				var uberEntityEl = entityEl.closest("[data-entity]").parent().closest("[data-entity]");
				var uberItemName = uberEntityEl.data("entity");
				
				if (uberItemName == entityEl.data("entity")) {
					uberEntityEl = uberEntityEl.parent().closest("[data-entity]");
					uberItemName = uberEntityEl.data("entity");
				}
				if (uberItemName == "Feature") {
					uberItemName = uberEntityEl.data("subtype");
				}
				logit(" --> itemName: " + itemName + ", uberItemName: "+uberItemName);
			
				var a_an = "a";
				var f = itemName.substr(0,1).toLowerCase();
				if ("aeiou".indexOf(f) > -1) 
					a_an = "an";
				
				
				if ($(this).hasClass("new")) 
					$(this).attr("title", "Add a new " + capitaliseFirstLetter(itemName) + " to this " +uberItemName);					
				else if ($(this).hasClass("delete"))
					$(this).attr("title", "Delete this " + capitaliseFirstLetter(itemName) + " from this " +uberItemName);
			});		

			$( ".button" ).tooltip({
				track: true,
				tooltipClass: "tooltip-item"	  		
				});

		}
	
		
		
		
		
		// 
		
		
		
		
		
		
	}	
		
		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* NOW IN LIVE LINKS
	$('.scrollable').mouseenter(function(){
       $("body").css("overflow","hidden");
    });
    $('.scrollable').mouseleave(function(){
    	$("body").css("overflow","auto");
    });
	*/
	
	// When moused over a scrollable div, or over something like a Canvas that is zoomable, don't let the page scroll.
    $('.scrollable__').bind('scroll', function() {
    	// when hitting the bottom of a scollable, delay the body scrolling
    	// scrollTop is  the number of pixels that are hidden from view above the scrollable area.
    	if( $(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight   ||  $(this).scrollTop() == 0) {
            setTimeout(function(){
            	$("body").css("overflow","auto");    
            }, 2000);
        } else {
        	//$("body").css("overflow","hidden");
        }                         
	});
	
	
	// preload interactive viewers where needed, for eample, on a BuildingMonograph
	$.each($(".picture.immediate"), function() {		
		
		
		if ($(this).data("image_type") != "cubic" && $(this).data("image_type") != "node") {
			logit("PROCESSING IMMEDIATE SEADRAGON =================!!!!!! " + $(this).css("width"));
			logit("ADD SEADRAGON VIEWER (.picture.immediate)");
			addSeadragonViewer($(this));
        } else {
        	logit("immediate pano!!");
	        addPanoViewer($(this));
        }
	

	});
	
	
	$("#allImages").hide();
	
	$("#allImagesButton").click(function(){
		var allImages = $("#allImages");
		
		allImages.empty();

		//if (allImages.css("display") == 'none') {
			if (allImages.length == 1) {
				var imagesJSON = GetRelatedItems("Building", allImages.data("building_id"), "Image", "depiction", addAllImages);
			}
			$("#allImages").show(2000);
			
		//}
		
	});
	// ! UPLOAD IMAGES BUTTON
	//$("#uploadImagesButton").click(function(){
	
	
	$(document).on("click", ".uploadImagesButton", function() {
		
		var from_entity 	= $(this).parent().data('from_entity');
		var from_id 		= $(this).parent().data('from_id');
		var relationship 	= $(this).parent().data('relationship');
		
		var relString = "";
		if (relationship &&  relationship != "")
			relString = '<input type="HIDDEN" name="relationship" value="'+relationship+'">';
			
		var dropzoneForm = $('<form action="/archmap_2/upload_center/UploadFromDropzone.php" class="dropzone" id="dropzoneUpload" style="display:none;"><input type="HIDDEN" name="tester" value="Wowsa!"><input type="HIDDEN" name="session_id" value="'+thisUser.session_id+'"> <input type="HIDDEN" name="from_entity" value="'+from_entity+'"> <input type="HIDDEN" name="from_id" value="'+from_id+'"> '+relString+'  <div class="dz-default dz-message"><span>Drop files here to upload</span></div></form>');
		
		
		$(this).after(dropzoneForm);
		
		var myDropzone = new Dropzone(dropzoneForm.get(0), {
			previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-success-mark\"><span>✔</span></div>\n  <div class=\"dz-error-mark\"><span>✘</span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>",
			maxFilesize: 50,
			clickable: false
		});
		
		//myDropzone.on("dragstart", function(file) {
		//alert("drag started ");
		//});
		
		//myDropzone.on("success", function(file, response) {
		// alert(response);
		//});
		
		//Dropzone.options.dropzoneUpload = {
		 // 	tester2: "Yousa"
		 // 	};
		
		dropzoneForm.show(2000);
		
		
	});
	
	





});




// ! NEW LIST_BLOCK_ITEM - add a new record to a list

// The item could be, for example, an ImageView or a Passage
function addNewItemToListBlock(listBlock) {
	
	

		// different templates for different types of entities....
		var tmpl = $('<div class="entity-profile feature list-item deletable" data-entity="Feature" data-subtype="'+listBlock.data("subtype")+'"><table width="100%"><tr><td valign="top" width="110px" class="item-gallery" data-entity="ImageView"><div class="image-view-thumbnail no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="100" height="100" /></div></td><td valign="top" class="info"></td></div>');
		  
		  
		  var nameField 	= $('<div data-entity="Feature" data-field="name"     class="editable" contenteditable="true">'+listBlock.data("subtype")+'</div>');
		  var descriptField = $('<div data-entity="Feature" data-field="descript" class="editable" contenteditable="true">edit</div>');
		  
		  
		  
		  var info = tmpl.find(".info");
		  info.append(nameField);
		  info.append(descriptField);
		  
		  //info.append(footer);
		
		  listBlock.append(tmpl);
	          
	          
	          
	          
		// 1. MEANWHILE - SAVE THE NEW ITEM TO THE DATABASE
		//    	ASSUME THE ID WILL ARRIVE AND BE ADDED TO THE ELEMENT BEFORE THE FIRST BLUR/SAVE OCCURS	
		data = {};
		data["name"] 	= listBlock.data("subtype");
		data["subtype"] = listBlock.data("subtype");
		
		// 		CHECK UP THE DOM TO SEE IF THERE IS A RELATIONSHIP (IF LIST< THEN PROBABLY)
		//    	DEFINE: from_entity, fromid, and possibly, relationship
		
		var profileEl 	= listBlock.closest( ".entity-profile" );
		if (profileEl) {
			if (profileEl.data("entity") && profileEl.data("id")) {
				data["from_entity"] = profileEl.data("entity");
				data["from_id"] 	= profileEl.data("id");
			
				
				var relationshipEl 	= listBlock.closest( "[data-relationship]" );											
				if (relationshipEl.length == 1) {
					logit("does HAVE relationship");
					var relationship = relationshipEl.data("relationship");
					if (relationship) {
						data["relationship"] = relationship;
					}
				} else {
					logit("does NOT have relationshipEl");
				}
				
			}
		} 
		
		
		// 2. SAVE THE RECORD AND USE RESPONSE TO SET ID IN DOM ELEMENT
		addRecord(listBlock.data("entity"), data, function(json_data) {
			// add the id to the passage div data...
			tmpl.attr("data-id", json_data['id']);
			nameField.attr("data-id", json_data['id']);
			descriptField.attr("data-id", json_data['id']);
			
			logit("field? - " + nameField.data("field"));
			
			setEditable(nameField, true);
			setEditable(descriptField, true);
		});
			
			          
			          
		return tmpl;
	
}




// ! +++ SET_EDITABLE
function setEditable(el, isEditing) {
	
	el.attr('contenteditable', isEditing);
	
	if (isEditing) {
			
			//$('.editable').ckeditor();
			
			if (el.html() == "")
			{
				el.html("edit " + el.attr("data-fieldname"));
			}
			
			el.blur(function(e) {
				
			
				if ($(this).data("from_entity"))
				{
					
					var relationship = $(this).attr("data-relationship")
					if (! relationship || relationship == "")
						relationship = "null";
						
					var fieldname = $(this).attr("data-fieldname");

					logit("save relation "+$(this).data("from_entity")+", "+$(this).data("from_id")+", "+$(this).data("to_entity")+", "+$(this).data("to_id")+", "+relationship+", "+fieldname+"="+$(this).html()+"!");
					updateRelatedItemFields($(this).data("from_entity"), $(this).data("from_id"), $(this).data("to_entity"), $(this).data("to_id"), relationship, fieldname, $(this).html());
				}
				else 
				{
					logit("save "+$(this).data("id")+", "+$(this).attr("data-field")+"!");

					saveChanges($(this).data("entity"), $(this).data("id"), $(this).attr("data-field"), $(this).html());
					
				}
				
					

			});
			el.mousedown(function() {
					currentElement = $(this);
					currentlyEditing_entity 	= $(this).data("entity");
					currentlyEditing_id			= $(this).data("id");
					
					// display wysiwyg menu
					//$("#wysiwyg-text-edit-menu").appendTo($(this));
					var options = {
					    "my": "right bottom",
					    "at": "right top-8",
					    "of": $(this)
					};
					$("#wysiwyg-text-edit-menu").position(options);
					$("#wysiwyg-text-edit-menu").show();
			});		
			el.keyup(function(e) {

				if (e.keyCode == 46 || e.keyCode == 8) {
					
					
					if (talliable) {
						tallyFootnotes();
					}
				}
			});
			el.bind('dragend',function(event){
				tallyFootnotes();
							
			});
		
	}	else {
			if (el.html() == "edit " + el.attr("data-fieldname"))
			{
				el.empty();
			}

	
			el.attr('contenteditable','false');
			
			el.unbind();
		
		
	}
	
	
}

function tallyFootnotes() {
	
	var div = $(document.activeElement);
	var ol = div.find('ol.footnotes')
	logit(div.attr('id'));
	
	var prevelem;
	var rels = div.find('a[rel="footnote"]');
	rels.each(function( index ) {
	   	$(this).text(index+1);
	   	var id = $(this).attr('id');
	   	id = id.replace('fnref_', 'fn_');
	   	
	   	var li = $('#'+id);
	   	if (! prevelem) {
		   	ol.prepend(li);
	   	} else {
		   	li.insertAfter(prevelem);
	   	}
	   	logit(index + ': ' + id);
	   	prevelem = li;
	});
	if (prevelem && prevelem.nextAll() && prevelem.nextAll().length) {
		prevelem.nextAll().remove();
	}
	
       
       // sort footnotes
	
}

function overFootnote(e) {
	var footnote_id = $(this).attr('href').replace("#",'');
	var footnote_html = $($(this).attr('href')).html().replace('<a href="#fnref_ab57d" rev="footnote">↩</a>', '');
   
   var at = "left";
   var offset = "-570 0"
   //alert(document.body.offsetWidth - e.pageX );
   //if(document.body.offsetWidth - e.pageX < 550) {
   //		at = "right";
   //		offset = "-270 0"
   //}
    var scrollTop = $(window).scrollTop();
    logit(scrollTop);
    var dialog = $('<div class="footnoteDialog">'+footnote_html+'</div>').dialog(
    	{title: "Footnote",
    	    		create: function (event, ui) {
				$(".ui-widget-header").hide();
			},
 
    	width: 400, dialogClass:'transparent',position: [e.pageX+10, e.pageY-20 - scrollTop]
    	});
}
function closeFootnote() {
	
	$('.footnoteDialog').dialog('close');
}

function overFigureLink(e, id) {
  
   var at = "left";
   var offset = "-570 0"

    var scrollTop = $(window).scrollTop();
   
   
    logit(scrollTop);
    
   var folder = "000";
   if (id > 1000)
   folder = "001";
   
 	var figImage = $('<div class="figureLinkDialog"><img src="/archmap/media/imageviews/'+folder+'/'+id+'_300.jpg" width="300" height="300" /></div>');
   
    var dialog = figImage.dialog(
    	{title: "Figure",
    	 create: function (event, ui) {
				$(".ui-widget-header").hide();
			},
 
    	width: 300, dialogClass:'transparent',position: [e.pageX+10, e.pageY-20 - scrollTop]
    	});
}
function closeFigureLink() {
	
	$('.figureLinkDialog').dialog('close');
}













function gotToMapFor(urlalias) {
	
	window.location = "/"+urlalias+"/map";
}


// ! --------- LIVE LINKS	------------------------------------------------------
$(document).on("mousedown", ".picture.link", function() {
	//alert("go to building " + $(this).data("building_id"));
	window.location = "/archmap_2/Site/Collection?resource="+$_GET("resource")+"&building_id=" + $(this).data("building_id");

});




$(document).on("mousedown", "#closeContent", function() {
//alert( $(this).data("urlalias") );
	//window.location = "/archmap_2/Site/Collection?resource="+$_GET("resource");
	window.location = "/" + $(this).data("urlalias") + "/map";
});

$(document).on("mouseenter", ".scrollable", function() {
	$("body").css("overflow","hidden");
});
$(document).on("mouseleave", ".scrollable", function() {
    $("body").css("overflow","auto");
});


$(document).on("mousedown", ".attributes-icon", function() {
   attrsEl = $(this).parent().find(".attributes-sheet");
   attrsEl.slideToggle();
   if (attrsEl.css('display') == 'none') {
	   //$(this).attr("title", "Show Attributes");
   } else {
	   //$(this).attr("title", "Hide Attributes");
	   
   }

});

$(document).on("mousedown", ".images-icon", function(e) {
   
   
  
   	if (e.shiftKey) 
   		attrsEl = $(".images-icon").next();
   	else
   		attrsEl = $(this).next();
   
   
   
   attrsEl.slideToggle();
   if (attrsEl.css('display') == 'none') {
	   //$(this).attr("title", "Show Attributes");
   } else {
	   //$(this).attr("title", "Hide Attributes");
	   
   }

});

// ! ATTRIBUTES
$(document).on("click", ".attributes-sheet :checkbox", function() {

	var entityEl = $(this).closest('[data-entity]');
	

	//logit("check " +entityEl.data("entity") + ":" + entityEl.data("id") + " :: " + $(this).next().text() + " - "+ $(this).is(':checked'));
	saveAttribute(entityEl.data("entity"), entityEl.data("id"), $(this).data("attr_id"), $(this).is(':checked'));
});



function saveAttribute(entity, item_id, attr_id, val) {
	
	var data = {};
	data['request'] 		= 'saveAttribute';
	data['session_id']		= thisUser.session_id;
	data['entity'] 			= entity;
	data['item_id']				= item_id;
	data['attr_id'] 		= attr_id;
	data['val']				= val;
	
	logit('saveAttribute:: /api?request=saveAttribute&session_id='+thisUser.session_id+'&entity='+entity +'&item_id='+item_id + '&attr_id='+attr_id+ '&val='+val);
	$.getJSON('/api', data, function() {
		logit('Success');
	});
	
}


$(document).on("mousedown", ".click-zoom", function() {
	
	$(this).removeClass("click-zoom");
	
	if(! $(this).hasClass("interactive")) {
		if( $(this).data("image_type") == "cubic" || $(this).data("image_type") == "node") {
			addPanoViewer($(this));
		} else {
			addSeadragonViewer($(this));
		}
		
	}
		
});

//! SEARCH FIELD
//$(document).on("keydown", ".search-field", function (event) {
	//logit("--"+event.which+" - " + $(this).val());
	
//});

/*
$(window).on('load resize', function() {

	$(".footer") $(document).scrollTop()
    $content.toggleClass('fixedContent', $wrapper.outerHeight(true)  $content.offset().top - $content.outerHeight(true) - $(document).scrollTop() > $(window).height());
});
*/


// ! ====================
// ! ==== MAP MANAGEMENT
// ! ====================

var markers = {};

function removeMarkerForItem(entity, id)
{
	var marker = markers[entity+"_"+id];
	
	if (! marker)
		return;

	marker.setMap(null);
}
function highlight(entity, id)
{
	var marker = markers[entity+"_"+id];
	
	if (! marker)
		return;
		
	var iconUrl = "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";
	/*
	marker.setAnimation(google.maps.Animation.BOUNCE);
	setTimeout(function() {
        marker.setAnimation(null)
    }, 500);
    */
    marker.setIcon(iconUrl);
}
function unhighlight(entity, id)
{
	var marker = markers[entity+"_"+id];
	
	if (! marker)
		return;


	var iconUrl = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
	if ($_GET("building_id") == id)
		var iconUrl = "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png";
	
		
	//marker.setAnimation(google.maps.Animation.NONE);
	marker.setIcon(iconUrl);
}



// ! ====================
// ! ==== LIST MANAGEMENT
// ! ====================


// ! ADD ITEM TO A COLLECTION LIST
$(document).on("click", ".addItemToCollectionButton", function (e) {

	e.preventDefault();

	var item_list = $(this).closest(".item-list");
	var items = item_list.find(".items");
	
	
	$(this).hide();
	
	// CREATE A FORM THAT SUPPROTS LIVE SEARCH TO SHOW SUGGESTIONS FOR ADDING TO THE COLLECTION
	
	var newAddItemForm = $('<div style="width: 100%;margin-bottom:10;margin-top:20;"></div>');
	
	
	// we need a collection/essay id
	var from_entity = $(this).data("from_entity");
	var from_id 	= $(this).data("from_id");
	var to_entity 	= $(this).data("to_entity");
	
	
	if (to_entity == "Publication")
		newAddItemForm.append("Enter keywords from a publication title or author's name:");
	else if (to_entity == "Essay")
		newAddItemForm.append("Enter keywords from a collection or site's name:");
	else
		newAddItemForm.append("Enter keywords from " + to_entity + "'s name:");
	
	
	var textField = $('<input data action="add-item"  style="width:100%;" />');
	
	newAddItemForm.append(textField);
	
	var requestTerm = "search";
	if (to_entity == "Publication")
		requestTerm = "searchPublication";
	
	textField.liveSearch({url: '/api?request='+requestTerm+'&entity='+to_entity+'&searchString='}, function(item) {
		
		// USER SELECTED SUGGESTION FROM THE DROP DOWN LIST OF SEARH RESULTS...
		
		logit(item.entity + " " +item.id + " " + item.name + " to " + $('.search-field').attr('data-collection'));
		
		addItemToList(from_entity, from_id, item.entity, item.id, null, function(ret)
		{
			logit("added item "+item.name);
			//createMarkerForBuilding(item.id, item);
			
			var record = $('<dt class="list-item"  data-site="'+from_entity+'" data-id="'+item.id+'" data-from_entity="'+from_entity+'" data-from_id="'+from_id+'" data-to_entity="'+item.entity+'" data-to_id="'+item.id+'"></dt>');
			record.append('<button class="edit-mode-only remove-list-item-button"><span style="font-size:10;">-</span></button>');
			
			logit("append "+item.name + " to " + items);
			
			switch(item.entity)
			{
				case "Building":
					record.append('<a href="/archmap_2/Site/Collection.php?collection=1&building_id='+item.id+'">'+item.name+'</a>');
					
					if (from_entity == "Publication")
					{
						pagesField= $('<div data-from_entity="'+from_entity+'" data-from_id="'+from_id+'" data-to_entity="'+to_entity+'" data-to_id="'+item.id+'" data-fieldname="pages" class="editable" contenteditable="true" >editp pages</div>');
						record.append(pagesField);
						setEditable(pagesField, true);
					}
					createMarkerForBuilding(item.id, item);
					break;
				
				case "Publication":
					record.append('<a href="/archmap_2/Site/Collection.php?collection=1&building_id='+item.id+'">'+item.name+'</a>');
					
					if (from_entity == "Building")
					{
						pagesField= $('<div data-from_entity="'+from_entity+'" data-from_id="'+from_id+'" data-to_entity="'+to_entity+'" data-to_id="'+item.id+'" data-fieldname="pages" class="editable" contenteditable="true" >editp pages</div>');
						record.append(pagesField);
						setEditable(pagesField, true);
					}
					break;
			}
			
			
			items.prepend(record);

		
		});
		
	});
	
	// USER HITS RETURN TO CREATE NEW ITEM, NOT IN DB YET
	textField.bind('keypress', function (e) {
	
		logit("keypress " + e.keyCode);
		
	    if(e.keyCode == 13) // ACTUALLY ADD A __NEW__ ITEM (NOT FROM THE DROPDOWN SEARCH RESULTS)
	    {
	       $("#jquery-live-search").empty();
	       
	       // add the building
	       
	        data = {};
	        data['from_entity'] = from_entity;
	        data['from_id'] 	= from_id;
	        data["name"]		= $(this).val();
	        
	        addRecord(to_entity, data, function(data) {
	        
	        		        	
	        	newAddItemForm.remove();
	        	
	        	var record = $('<dt class="list-item"  data-site="'+from_entity+'" data-id="'+data['id']+'" data-from_entity="'+from_entity+'" data-from_id="'+from_id+'" data-to_entity="'+to_entity+'" data-to_id="'+data['id']+'"></dt>');
	        	
	        	record.append('<button class="edit-mode-only remove-list-item-button"><span style="font-size:10;">-</span></button>');
				
				if (to_entity == "Building")
					record.append('<a href="/archmap_2/Site/Collection.php?collection=1&building_id='+data['id']+'">'+data.name+'</a>');
				if (to_entity == "Essay")
					record.append('<a href="/archmap_2/Site/Collection.php?collection='+data['id']+'&building_id='+from_id+'">'+data.name+'</a>');
				else 
					record.append('<div>'+data.name+'</div>');
				
				/*
				var dragIcon = $('<img class="drag-icon icon32" 	src="/archmap_2/media/ui/CircleIcon.png" 		width="16" height="16"  data-entity="Building" data-id="'+data.id+'" data-name="'+data.name+'" />');
				
				dragIcon.draggable({
					 opacity: 0.7, 
					 helper: "clone"
					 });
					 
					 listItemMenu.append
				
				listItem.append(dragIcon);
				*/
				
				items.prepend(record);

				$(".addItemToCollectionButton").show();
	
	        });
	    }
	});
	
	
	
	
	
	
	
	
	
	
	
	var doneButton = $('<button>Done</button>').click(function(e) {
		e.preventDefault();
		$(this).hide();
		newAddItemForm.remove();
		$(".addItemToCollectionButton").show();
		$(this).remove();
	});
	newAddItemForm.append(doneButton)
	
	$(this).parent().append(newAddItemForm);
	

});


// ! REMOVE LIST ITEM BUTTON
$(document).on("click", ".remove-list-item-button", function (e) {
	e.preventDefault();

	var listItem = $(this).closest(".list-item");
	
	var from_entity = listItem.data("from_entity");
	var from_id	 	= listItem.data("from_id");

	var to_entity 	= listItem.data("entity");
	var to_id	 	= listItem.data("id");
	
	logit("remove list item: " + from_entity+":"+from_id + " => "+ to_entity+":"+to_id);


	listItem.hide("puff", {}, 1000, function() {
		$(this).remove();
		});
	
	logit("now remove marker");
	if ($.isFunction(removeMarkerForItem)) 
		removeMarkerForItem(to_entity, to_id);
	
	removeItemFromList(from_entity, from_id, to_entity, to_id, function(){
		
	});

});






// ! LIST ITEM LINK
$(document).on("click", ".monument-link", function (e) {
	e.preventDefault();

	var id = $(this).closest(".list-item").data("id");
	var site = $(this).closest(".list-item").data("site");
	
	
	window.location = "http://archmap.org/archmap_2/Site/Collection?site="+site+"&building_id="+id +"&monumentsScrollTop="+ $(this).parent().scrollTop();
});

// ! LIST ITEM OVER
$(document).on("mouseover", ".list-item", function (e) {
	e.preventDefault();

	
	var entity= $(this).data("to_entity");
	var id = $(this).data("to_id");
	
	highlight(entity, id);
});

// ! LIST ITEM OUT
$(document).on("mouseout", ".list-item", function (e) {
	e.preventDefault();

	var entity= $(this).data("to_entity");
	var id = $(this).data("to_id");
	
	unhighlight(entity, id);
});




// ! LINK: BIBLIO TITLE
$(document).on("mousedown", ".biblio-link", function () {
	
	var id = $(this).parent().data("id");
	
	//alert("yo "+id);
	 window.location = "http://archmap.org/Site/Publication.php?id="+id;
});


// ! LINK: ADD FOOTNOTE
$(document).on("remove", ".footnoteLink", function () {
alert("remove");
	 tallyFootnotes();
});

// ! LINK: TALLY FOOTNOTE NUMBERS
$(document).on("mousedown", ".editable", function() {
	
	talliableOn();
});

$(document).on("mousedown", "ol.footnotes", function(event) {
	event.stopPropagation();
	talliableOff();	
});

$(document).on("mouseover", "a[rel='figure']", function(event) {
	event.stopPropagation();
	overFigureLink(event, $(this).data("id"));
});
$(document).on("mouseleave", "a[rel='figure']", function(event) {
$('.figureLinkDialog').dialog('close');
});

$(document).on("mousedown", "a[rel='figure']", function(event) {
	event.stopPropagation();
	overFigureLink(event, $(this).data("id"));
});

// ! LINK: ADD FIG TO PASSAGE TEXT
$(document).on("mouseleave", '.figureLinkDialog', function(event) {
	$('.figureLinkDialog').dialog('close');
});


$(document).on("mousedown", ".download-button", function(event) {
	//$("#downloadDialog").append($("<iframe />").attr("src", "www.ancientworlds.net")).dialog();
	
	var iframe = $('<iframe height="1" />');
	iframe.attr("src", "Catalog2RTF.php");
	$('<div id=#downloadDialog"></div>').append("Creating document... ").append(iframe).dialog();
	
});


$(document).on("mousedown", ".download-buttonBuildings", function(event) {
	//$("#downloadDialog").append($("<iframe />").attr("src", "www.ancientworlds.net")).dialog();
	
	var iframe = $('<iframe height="1" />');
	iframe.attr("src", "CatalogBuildings2RTF.php");
	$('<div id=#downloadDialog"></div>').append("Creating document... ").append(iframe).dialog();
	
});



$(document).on("mouseenter", '.entity-profile.feature', function(event) {
	logit("high "+ $(this).data("id"));
	$('.feature-icon[data-id="'+$(this).data("id")+'"]').addClass("icon-highlight");
});

$(document).on("mouseleave", '.entity-profile.feature', function(event) {
	$('.feature-icon').removeClass("icon-highlight");
});

// ! LINK: ADD TAG BUTTON

$(document).on("mousedown", '.addTag', function(event) {

	var tagItems = ["sculpture", "structure", "wall opening"];
	
	var tagDialog = $('<div>Please selct Tags to add.</div>');
	
	var tagChoices = $('<div></div>');
	tagDialog.append(tagChoices);
	
	for (var i = 0; i < tagItems.length; ++i) {
		var input = $('<input type="checkbox" name="tagItems" value="'+tagItems[i]+'">'+tagItems[i]+'<br>');
    	tagChoices.append(input);
	}
	

	
	tagDialog.dialog({

      title: "Add a Tag",
      height: 300,
      width: 350,
      modal: true,
      buttons: {
			Cancel: function() {
				$( this ).dialog( "close" );
			},
			"Add Checked Tags": function() {
			
				$( this ).dialog( "close" );
			}
			
	  }								
	});

});














	
	
// ! ................ IMAGE GALLERIES AND VIEWING ......................... //

// ! LINK: OPEN IMAGE GALLERY

$(document).on("mousedown", '.openImageGallery', function(event) {
	openImageGalleryFrom($(this));
});

// ! LINK: ADD FIGURE TO ITEM GALLERY BUTTON
$(document).on("mousedown", '.addFigureButton', function(event) {
			
	
   // 1. SELECT THE GALLERY: the item-gallery to add an image to... 
   
   var itemGallery = $(this).closest(".item-gallery");
   
   
   if (itemGallery.length > 0) {
	   // This is clicking on a blank thumbnail 
	   currentElement = $(this).closest(".entity-profile");
	   
	   // select the gallery...
	   // This function only opens the generic image gallery. What happens when you click on an image there dependes on the selected state of
	   // itmes in the dom.. the mode, so to speak
	   $(".selectedItem").removeClass("selectedItem");
	   itemGallery.addClass('selectedItem');
	   openImageGalleryFrom($(this));
	   
  } else {
   		// Called from a text field or area
   		// currentElement was already selected when clicking on a text field.
   		//    - THIS MUST BE ADDED FIRST WHILE WE HAVE A CURSOR POSITION. ONCE WE OPEN THE DIALOG BOX, WE WILL LOSE THIS.
   		$(".selectedItem").removeClass("selectedItem");
   		var figureLink = $('<a class="selectedItem text-figure-link" data-entity="ImageView" rel="figure">(Fig. 1)</a>');
   		
   		var clickedEl = $(document.activeElement);
   		
   		var buildingEl = clickedEl.closest('.mono-profile');
		if (buildingEl.length == 0) {
			buildingEl = clickedEl.closest('.main-content');
		}
   		//alert(buildingEl.data("id"));
   		insertHTMLAtCursor(figureLink);
   		
   		
   		openImageGalleryFrom(buildingEl)
   		
   		
   }
	
	//openImageGalleryFrom($(this));


});	




$(document).on("mousedown", '.choose-poster', function(event) {
	openImageGalleryFrom(event);

});





// ! -----------------------------------------------------

// ! OPEN IMAGE GALLERY
function openImageGalleryFrom(clickedEl) {
	
	imageWindow.empty();
	imageWindow.dialog("open");
	imageWindow.dialog( {
		title:   "Images",
    	width:   $( window ).width()  * .7,
		height:  $( window ).height() * .8
    });
	
	
	// [2.] POPULATE THE GALLERY.... if it does not already have all its images loaded
	//		- later have queries for gathering a gallery of images
	//		- for now, just get all the images for this profile.
	
	var buildingEl = clickedEl.closest('.mono-profile');
	if (buildingEl.length == 0) {
		buildingEl = clickedEl.closest('.main-content');
	}
	var entity = buildingEl.data('entity');
	var building_id = buildingEl.data('id');
	
	var imagesJSON = GetRelatedItems(entity, building_id, "Image", "depiction", function(data) {
		addToThumbnailsGallery(data, imageWindow);
	});
	
	
}


// ! OPEN IMAGE GALLERY
function openImageGalleryOnPage(allImagesEl) {
	
	
	// [2.] POPULATE THE GALLERY.... if it does not already have all its images loaded
	//		- later have queries for gathering a gallery of images
	//		- for now, just get all the images for this profile.
	
	var entity 		= allImagesEl.data("entity");
	var id 			= allImagesEl.data("id");
	var relationship = allImagesEl.data("relationship");
	
	
	logit("GGet images related to " + entity + ":" + id + " ++relationship="+ relationship);
	
	var imagesJSON = GetRelatedItems(entity, id, "Image", relationship, function(data) {
		addToThumbnailsGallery(data, allImagesEl);
	});
	
	
}

// ! ===> ADD IMAGES TO THUMNAIL_GALLERY
// - Lays out images as thumbnails with float lefts.
// - Basic mission is to layout static images with a faint background of itself.
// - The calling function can add whatever functionality it wants to the thumbnails
// * for now this is only Image data, later, allow for imageView data alternatively
function addToThumbnailsGallery(imgdata, thumbnailGalleryEl) {
		
	logit("ADDING IMAGES TO GALLERY " + imgdata[0]);
	
	if (! thumbnailGalleryEl) {
		  thumbnailGalleryEl = $("#allImages");
	}
	
	var size = 100;

	$.each(imgdata.items, function (k,v) {
		var w, h;
	
		if (v.image_type == "cubic" || v.image_type == "node") {
			// PANO
			thumbnail = $('<div  class="image-thumb100 enlargeFigureButton" data-entity="Image" title="AM.PANO.'+v.id+', '+v.author_name+'" data-image_type="'+v.image_type+'" data-id="'+v.id+'"  data-filesystem="'+v.filesystem+'" data-filepath="'+v.filepath+'" data-filename="'+v.filename+'" data-has_sd_tiles="'+v.has_sd_tiles+'" data-pan="'+v.pan+'" data-tilt="'+v.tilt+'" data-fov="'+v.fov+'">	<div id="image-viewer-'+v.id+'" class="imageArea">		<img src="'+v.url100+'" width="'+size+'" height="'+size+'" /></div> </div>');
		} else {
			// SEADRAGON
			thumbnail = $('<div  class="image-thumb100 enlargeFigureButton" data-entity="Image" title="AM.IMG.'+v.id+', '+v.author_name+'" data-image_type="'+v.image_type+'" data-id="'+v.id+'" data-filesystem="'+v.filesystem+'"  data-filepath="'+v.filepath+'" data-filename="'+v.filename+'" data-has_sd_tiles="'+v.has_sd_tiles+'" data-pan="'+v.pan+'" data-tilt="'+v.tilt+'" data-fov="'+v.fov+'">	<div class="image-bg">									<img src="'+v.url100+'" width="'+size+'" height="'+size+'" /></div> </div>');
			
			if (v.id ==	 32912 ||  v.id  == 32915) 
				logit("image "+v.id+": " +v.width + ", " + v.height);
			
			
			if (parseFloat(v.width) > parseFloat(v.height)) {
				w = size;
				h = size * (v.height / v.width);
			} else {
				h = size;
				w = size * (v.width / v.height);
			}
			if (v.id ==	 32912 ||  v.id  == 32915)  
				logit("image "+v.id+": "+size+" -- " +w + ", " + h);
			
			thumbnail.append('<div style="position:absolute;left: '+(size-w)/2+';top: '+(size-h)/2+';z-index:10;"><img src="'+v.url100+'" /></div>');
		}
		
		
		thumbnail.addClass("image-draggable");
		thumbnail.draggable({ 
			opacity: 1.0, 
			helper: "clone",
			appendTo: 'body',
			zIndex: 1000001,
			revert: "invalid",
			start: function(event, ui) {
				$(ui.helper).removeClass("enlargeFigureButton");
				$(ui.helper).addClass("image-dragging");
				 $("body").css("overflow","hidden");
				 logit("STOP OVERFLOW");
				 scrollTop = $("body").scrollTop();
			},
			drag: function (e) {
				  $("body").scrollTop(scrollTop);
			}
					
		});



		thumbnailGalleryEl.append(thumbnail);
		
		
		
		
		
		
		
	});
}
	
	
	
	
// ! ENLARGE:: DISPALY IMAGE VIEWER: IN DIALOG IMAGE VIEWER
//   - Two place this can be called from. 
//		1. a thumbnail on a page. Next and prev, may be to next feature, etc.
//		2. from a gallery of thumbnails. Next/Prev would be to other images in the gallery.
//
//		



$(document).on("mouseup", '.enlargeFigureButton', function(event) {

	var callingEntityEl = $(this).closest('[data-entity]'); // this should either be Image or ImageView
	
	enlargeFigure(callingEntityEl);
});

function enlargeFigure(callingEntityEl) {
		
	
	//alert( 'enlarge figure ' +$(this).data("entity")+  " :: " + $(this).data("image_type") + " for "+entityProfile.data('entity') + " "+entityProfile.data('id'));
	//return;
	imageWindow.empty();
	imageWindow.dialog("open");
	imageWindow.dialog( {
		title:	 "Image",
    	width:   $( window ).width()  * .7,
		height:  $( window ).height() * .9
    });

	var layout = $('<div style="position: relative;"></div>');
	imageWindow.append(layout);
	  
	  
  	// for now, deselect everything else if an ImageView
  	// with the assumption that these are in a list of features
   	if (callingEntityEl.data('entity') == "ImageView") 
   		$(".selectedItem").removeClass("selectedItem");
	
	callingEntityEl.addClass('selectedItem');

	// 	Having a separate containor helps to bound the interactive viewer, whether pano or seadragon
	var imageViewContainer = $('<div style="position:relative;"></div>');
	var size = imageWindow.height();
	imageViewContainer.css("width", size);
	imageViewContainer.css("height", size);
	layout.append(imageViewContainer);

	
	// The id to give the view should always be of an Image. 
	// * If the calling item is an ImageView, get the original image id from "image_id"
	var image_id = (callingEntityEl.data('entity') == "ImageView") ? callingEntityEl.data("image_id") : callingEntityEl.data("id");
	
	
	
	// Create an imageArea
	var imageArea = $('<div id="image-viewer-'+callingEntityEl.data("id")+'" class="imageArea imageViewer" data-entity="'+callingEntityEl.data('entity')+'"data-id="'+callingEntityEl.data('id')+'" data-image_id="'+image_id+'" data-image_type="'+callingEntityEl.data("image_type")+'"  data-filesystem="'+callingEntityEl.data("filesystem")+'" data-filepath="'+callingEntityEl.data("filepath")+'" data-filename="'+callingEntityEl.data("filename")+'" data-has_sd_tiles="'+callingEntityEl.data("has_sd_tiles")+'" data-pan="'+callingEntityEl.attr("data-pan")+'" data-tilt="'+callingEntityEl.attr("data-tilt")+'" data-fov="'+callingEntityEl.attr("data-fov")+'"></div>');
	imageViewContainer.append(imageArea);
	
	
	
	// CREATE VIEWER BASED ON IMAGE_TYPE
	var isPano = false;
	if( imageArea.data("image_type") == "cubic" || imageArea.data("image_type") == "node") {									
		isPano = true;
		imagePlayer = addPanoViewer(imageArea, 1024);
	} else {
		logit("ADD SEADRAGON VIEWER (enlargeFigure)");
		imagePlayer = addSeadragonViewer(imageArea);
	}
	
	addBehaviorToImageViewer(imageArea, imagePlayer,isPano);
	
	
	// Add fields for image info and mapping
	
	var form = $('<div style="position:absolute;left:'+size+';top:0;padding:20;"></div>');
	layout.append(form);
	
	var nameField = $('<div  data-entity="'+callingEntityEl.data('entity')+'" data-id="'+callingEntityEl.data("id")+'" data-field="name"     class="editable" contenteditable="false">'+callingEntityEl.data("name")+'</div>');
	
	
	form.append(nameField);
}

	
// ! ADD BEHAVIOR TO IMAGE VIERWER
function addBehaviorToImageViewer(imageArea, imagePlayer,isPano) {
	
	/* Activities when wieing an image in an image viewer:
			[1] Creating a new Feature
					Nothing is selected. You are doing image exploration and 
					when you see something interesting in your current framing, 
					you create a feature of a certain type and add it some where, 
					for example, to the current building as an "incorporated" feature.
					When you click on Add feature:
						(a.) select feature type
						(b.) select relationships for this feature
						(c.) position the feature in any number of spaces or time
						(d.) switch to mode 3.
			
			[2] Adding a new ImageView to a selected item-gallery
					Once you add the view, 
						(a.) You are in mode 3.
						
			[3] Edit an existing ImageView
					Once you have reset the ImageView, you may
						(a.) you may close the dialog
						(b.) reedit the zoom * pan
						(c.) create a new feature
						
					
	*/
	
				
				
				
				
	if (thisUser && thisUser.isLoggedIn) {
		
		var  selectedItem = $('.selectedItem');
  
		logit("selectedItem - entity = "+selectedItem.data("entity"));
		logit("AN ITEM IS SELECTED??: "+ selectedItem.attr('class') + " --- "+selectedItem.length);
		if (selectedItem.length == 1) {
			logit("AN ITEM IS SELECTED: "+ selectedItem.attr('class'));
			
			if(selectedItem.hasClass("text-figure-link"))
			{
				logit("ADD TO TEXT FIGURE LINK");
				
				// we are adding an image to an item's gallery
				var fromEntityEl = selectedItem.parent().closest('[data-entity]');
				var itemName = fromEntityEl.data('entity');
				logit(itemName);
				if (itemName == "Feature") {
					itemName = fromEntityEl.data('subtype');
					itemName = itemName.charAt(0).toUpperCase() + itemName.slice(1);
				}


				var button = $('<div class="imageButton" title="Choose the zoom and pan of this view as a Figure for this text.">Add this Image selection as a Figure for the text</div>');
				imageArea.append(button);
				
				button.click(function() {
					//alert("create Image View");
					saveImageView(imageArea, imagePlayer, isPano, fromEntityEl.data('entity'), fromEntityEl.data('id'));
					button.remove();
					
				});
				
				
			}
			else if (selectedItem.hasClass("item-gallery")) {
				
				// MODE [2]. Adding a new ImageView to a selected item-gallery
				
				// we are adding an image to an item's gallery
				var fromEntityEl = selectedItem.parent().closest('[data-entity]');
				var itemName = fromEntityEl.data('entity');
				logit(itemName);
				if (itemName == "Feature") {
					itemName = fromEntityEl.data('subtype');
					itemName = itemName.charAt(0).toUpperCase() + itemName.slice(1);
				}
				
				var button = $('<div class="imageButton" title="Choose the zoom and pan of this view as an image of Feautre">Add this Image selection to the selected '+itemName+'</div>');
				imageArea.append(button);
				
				button.click(function() {
					//alert("create Image View");
					saveImageView(imageArea, imagePlayer, isPano, fromEntityEl.data('entity'), fromEntityEl.data('id'));
					button.remove();
				});
				
				
				
				
				
			} else if (selectedItem.data("entity") == "ImageView") {
				
				// IMAGE VIEW
				var resetImageButton = $('<div class="imageButton" title="Reset the zoom and pan of this view (resets all thumbnails as well).">Reset selected ImageView</div>');
				
				resetImageButton.click(function() {
					saveImageView(imageArea, imagePlayer, isPano);
					resetImageButton.remove();
					imageWindow.dialog("close");
					
				});
				imageArea.append(resetImageButton);
				
								
			}
			
		} else {
			// nothing selected, perhaps create a feature?
			
		}
					
	}
			
			
	
}








// ! *** SAVE_IMAGE_PAN_AND_ZOOM

function saveImagePanAndZoom(imageArea, imagePlayer) 
{
	var canvasEl = imageArea.find('canvas');
	canvas = canvasEl[0];

	logit("saving pan and zoom for image " + canvas);

	if (canvas) {
	
		// USE THE CANVAS TO CREATE AN IMAGE
		var img_data   = canvas.toDataURL("image/jpg", 0.8);		
		
		// PREPARE TO SEND
		data= {};
		
		//data['request'] 		= 'saveImageView';
		data['request'] 		= 'saveChanges';
		data['session_id']		= thisUser.session_id;
		
		data['entity'] 			= "Image";
		data['id'] 		= imageArea.data("id");
		var image_type 			= imageArea.data("image_type");
		
		// GET CUREENT IMAGE VIEW STATE
		// At this point, by the time the user has clicked the "selectButton",
		// the user has panned and zoomed the image to frame the item of interest within the larger image.
		// Use this state to define this new ImageView in the database
		if (image_type == "cubic" || image_type == "node") {
			// get pano2VR attrs
			data['pan'] 			= imagePlayer.getPan();
			data['tilt'] 			= imagePlayer.getTilt();
			data['fov'] 			= imagePlayer.getFov();
		} else {
			// get Seadragon attrs
			logit("SEADRAGON PARAMETERS "+imagePlayer.viewport.getCenter());
			var sd_center			= imagePlayer.viewport.getCenter();
			data['pan'] 			= sd_center.x;
			data['tilt'] 			= sd_center.y;
			data['fov'] 			= imagePlayer.viewport.getZoom();
			
		}
		
				
		
		logit('** REQUEST TO SAVE IMAGE PAN AND ZOOM ** /api?request=saveChanges&session_id='+thisUser.session_id );
		$.each(data, function(k,v){
			logit("data["+k+"] = "+ v);
			
		});
		logit(" ======= ");
		
		
		
		//saveMultiChanges("Image", el.data("id"), {pan:imagePlayer.getPan(), tilt:imagePlayer.getTilt(), fov:imagePlayer.getFov()});

		$.post('/archmap_2/upload_center/uploadIconForImage.php', {
		        id : data['id'],
		        img_data : img_data.replace(/^data:image\/(png|jpg);base64,/, "")
		    }); 

		$.getJSON('/api', data, function(json_data) {
				
				var id = json_data['id'];
				// the data will have the new id of the image view
				logit('**** RESPONSE IMAGE.id='+id + ' ****');
				
				
				// 2. UPDATE IMAGE  THUMBNAILS ANYWHERE VISIBLE
				
																
				// 3. UPLOAD NEW THUMBNAIL IMAGE TO SERVER
				   				   
				   				   
				
			});

	}
	
}


// ! *** SAVE_IMAGE_VIEW
function saveImageView(imageArea, imagePlayer, isPano, from_entity, from_id) 
{
	
	var canvasEl = imageArea.find('canvas');
	canvas = canvasEl[0];
	
	if (canvas) {
	
		// USE THE CANVAS TO CREATE AN IMAGE
		var img_data   = canvas.toDataURL("image/jpg", 0.8);		
		
		
		// CREATE AN IMAGE_VIEW IN THE DATABASE AND RELATE IT TO THE PROFILE ITEM (Passage, Feature, etc.)

		// 1. PREPARE REQUEST FOR NEW IMAGE_VIEW

		data= {};
		
		//data['request'] 		= 'saveImageView';
		data['request'] 		= 'saveChanges';
		data['session_id']		= thisUser.session_id;

		data['entity'] 			= "ImageView";
		
		// if the imageview is new, there is no id et
		if ( imageArea.data('entity') == "ImageView" && imageArea.data("id") ) {
			data['id'] = imageArea.data("id");
		}
		
		
		data['image_id'] = imageArea.data("image_id");
		

		
		// GET CUREENT IMAGE VIEW STATE
		// At this point, by the time the user has clicked the "selectButton",
		// the user has panned and zoomed the image to frame the item of interest within the larger image.
		// Use this state to define this new ImageView in the database
		if (isPano) {
			// get pano2VR attrs
			data['pan'] 			= imagePlayer.getPan();
			data['tilt'] 			= imagePlayer.getTilt();
			data['fov'] 			= imagePlayer.getFov();
		} else {
			// get Seadragon attrs
			var sd_center			= imagePlayer.viewport.getCenter();
			data['pan'] 			= sd_center.x;
			data['tilt'] 			= sd_center.y;
			data['fov'] 			= imagePlayer.viewport.getZoom();
			
		}

		if (from_entity) {
			data['from_entity'] 	= from_entity;
			data['from_id'] 		= from_id;	
			data['relationship'] 	= "figure";
		} 
		
		
		// 2. SEND REQUEST FOR NEW IMAGE_VIEW
		
		logit('** REQUEST TO SAVE IMAGE_VIEW ** /api?request=saveChanges&session_id='+thisUser.session_id );
		$.each(data, function(k,v){
			logit("data["+k+"] = "+ v);
			
		});
		logit(" ======= ");
		
	
		
		$.getJSON('/api', data, function(json_data) {
				
				var id = json_data['id'];
				// the data will have the new id of the image view
				logit('**** RESPONSE IMAGE_VIEW.id='+id + ' ****');
				
				var  selectedItem = $('.selectedItem');
				logit("selectedItem: "+selectedItem.attr("class"));
				
				// ADD THE NEW ID FOR THE IMAGE_VIEW
				selectedItem.attr("data-id", id);
				
				// FIGURE IN A TEXT PASSAGE?
				if (selectedItem.hasClass("text-figure-link"))
				{
					var passage = selectedItem.parent("[data-entity]");
					selectedItem.removeClass("selectedItem");
					saveChanges(passage.data("entity"), passage.data("id"), passage.attr("data-field"), passage.html());

				}
				
				
				// 2. UPDATE IMAGE VIEW THUMBNAILS OR ADD THUMBNAIL TO NEAREST GALLERY
				var thumbs = $('[data-entity="ImageView"][data-id="'+id+'"]');
				$.each(thumbs, function() {
					logit('thumb');
					$(this).find("img.thumbnail").attr('src', img_data);				
					$(this).attr("data-pan", data['pan']);	
					$(this).attr("data-tilt", data['tilt']);
					$(this).attr("data-fov", data['fov']);
				});
				
				if (from_entity) {
					// assume this was a new ImageView
					var img = $("<img />");
					img.attr('src', img_data);
					img.attr('width', 100);
					img.attr('height', 100);
					img.attr('data-id', id);
					var newThumb = $('<div class="image-view-thumbnail" data-entity="ImageView" data-id="'+id+'"></div>');
					newThumb.append(img);
					
					var galleryEl = currentElement.find(".item-gallery");
					if (galleryEl.length < 1) {
						galleryEl = currentElement.parent().find(".item-gallery")
					}
					galleryEl.find(".no-image").remove();
					galleryEl.append(newThumb);
				}	
				
																
				// 3. UPLOAD NEW THUMBNAIL IMAGE TO SERVER
								
				$.post('/archmap_2/upload_center/uploadIconForImageView.php', {
				        id : id,
				        img_data : img_data.replace(/^data:image\/(png|jpg);base64,/, "")
				    }); 
				   
				   
					//dialog.close();
				
			});
		
	}	
	

}





$(document).on("mouseup", '.click-zoom', function(e) {
	$(this).unbind(e);
	$(this).removeClass("click-zoom");
	
	var picture = $(this);
	
	if(! picture.hasClass("interactive")) {
		
		// ADD ZOOMABLE/PANNABLE PLAYER
		
		var isPano = false;
		var imagePlayer;
		
		if( picture.data("image_type") == "cubic" || picture.data("image_type") == "node") {									
			isPano = true;
			imagePlayer = addPanoViewer(picture);
		} else {
			logit("ADD SEADRAGON VIEWER (.click-zoom - on mouseup)");
			imagePlayer = addSeadragonViewer($(this));
			setTimeout(function() { $("#floaterThumb-"+picture.data("id")).hide("fade", function() { $(this).remove()}); }, 500);
		}


	}

});



// ! ADD A LIST BLOCK
		
$(document).on("mouseup", '.addButton', function(event) {
	$(this).attr('src','/media/ui/buttons/ButtonPlusNormal.png');
	
	var listBlock = $(this).closest(".list-block");
	
    var newItem = addNewItemToListBlock(listBlock);  

	// SCROLL TO THE NEW FEATURE...
	//get the top offset of the target anchor
    var target_offset = newItem.offset();
    var target_top = target_offset.top;
	
    //goto that anchor by setting the body scroll top to anchor top
    $('html, body').animate({scrollTop:target_top}, 500, 'easeInSine');


});


// ! ADD A FEATURE  TO  A FEATURE LIST
// This will add the blank feature to either an existing sublist nased on the selected subtype
// or create a new sublist if one does not exist
$(document).on("mouseup", '.add-feature.button', function(event) {

	var entityProfile = $(this).closest(".entity-profile");
	var popup = $('<div style="padding: 20; text-align:center;"><div  style="margin-bottom: 50;">Choose the subtype of the Feature<br /> you would like to the '+entityProfile.data('entity')+': <br /><b>'+entityProfile.find(".title").text()+'</b></div> </div>');
	
	
	var featureSubtypes = getFeatureSubtypes(function(json_data) {
	
		// Generate the OPTIONS pulldown menu of subtypes
		var subOptionsSelect = $('<select id="featureSubtypesOptions" style="font-size:36;"></select>');
		$.each( json_data, function( key, val ) {
		    subOptionsSelect.append( "<option value='" + val.name + "'>" + val.name + "</li>" );
		  });
		popup.append(subOptionsSelect);
		
		
		popup.dialog({

		      title: "Add a Feature",
		      height: 300,
		      width: 350,
		      modal: true,
		      buttons: {
					Cancel: function() {
						$( this ).dialog( "close" );
					},
					"Add Feature": function() {
						var subtype;
						var subtype_key = subOptionsSelect.val();
						$.each( json_data, function( key, val ) {
							if (val.name == subtype_key) {
								subtype = val;
							}
						});
										
						
						//alert("add a " + subtype_key);
						
						// first see if there is already a sublist for this subtype
						var featureBlock = $('.feature-block[data-subtype="'+subtype_key+'"]');
						
						if(featureBlock.length == 0) {
							// feature block does not exist yet for this sublist, 
							// we must create it
							featureBlock = $('<div class="feature-block" data-entity="Feature" data-subtype="'+subtype_key+'"> <div class="block-list-label" data-entity="Feature" data-subtype="'+capitaliseFirstLetter(subtype_key)+'"><b>'+subtype.name_plural+'</b><hr></div> </div>');
							
							// add it to the DOM
							$("#feature-list-items").append(featureBlock);
						}	
						addNewItemToListBlock(featureBlock);
						
						// create a new feature record and add its form to the featureBlock
						
						
						// SCROLL TO THE NEW FEATURE...
						//get the top offset of the target anchor
				        var target_offset = featureBlock.offset();
				        var target_top = target_offset.top;
			
				
				        //goto that anchor by setting the body scroll top to anchor top
				        $('html, body').animate({scrollTop:target_top}, 1500, 'easeInSine');
						
						$( this ).dialog( "close" );										
					}
					
			  }								
		});
							
		
	})
	
	
});





// ! DELETE BUTTONS
$(document).on("mouseup", '.menu .button.delete', function(event) {
	
	$(this).attr('src','/media/ui/buttons/ButtonMinusNormal.png');
	
	var deletable = $(this).closest(".deletable");
	
	logit("dealetable :: " + deletable.data("entity") + ":" + deletable.data("id"));
	
	var confirmationEl = $('<div class="dialog-note">Are you REALLY sure you want to delete this '+deletable.data("entity")+'?</div>');
	confirmationEl.dialog({
			      autoOpen: true,
			      title: "Delete "+deletable.data("entity")+" Confirmation",
			      height: 300,
			      width: 350,
			      modal: true,
			      buttons: {
						"Delete": function() {
							logit("really deleting :: " + deletable.data("entity") + ":" + deletable.data("id"));
							deletRecordFromDatabase(deletable.data("entity"), deletable.data("id"), function(server_data) {
									
									logit('deleted from db: ' + server_data["message"]);
									
									if (server_data["success"] == "1") {
										
										logit(deletable.data("entity"));
										if (deletable.data("entity") == "ImageView") {
											// if last image in the gallery, add the no-icon image
											var gallery = deletable.closest(".item-gallery");
											logit(gallery);
											var imageViews = gallery.find(".image-view-thumbnail");
											logit(imageViews.length);
											if (imageViews.length <=1) 														
												gallery.prepend('<div class="image-view-thumbnail no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="100" height="100" /></div>');
	
										}
										
										removeEl = deletable;
										
										/*
										// delete item or rubric (if has only one item)?
										var rubric = deletable.closest(".rubric-block");
								 		var deletables = rubric.find(".deletable");
								 		logit("deletables.length = " + deletables.length);
								 		var removeEl;
								 		if (deletables.length == 1) {
									 		removeEl = rubric;
								 		} else {
									 		removeEl = deletable;
								 		}
								 		*/
										deletable.hide( "fast", function() {
									
									 		confirmationEl.dialog( "close" );
									 		removeEl.remove();
									 		
									 	});
									 	
									 	
									 	
										
										
									} else {
										confirmationEl.html('<div class="dialog-note">'+server_data["message"]+'</div>');
										confirmationEl.dialog('option', 'title', "Delete Cancelled");
										confirmationEl.dialog('option', 'buttons', {OK: function() {
											$( this ).dialog( "close" );
											}}); 
									}
																			
							});
							
							
							
							
								
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
				}			
	});				
	      
	
 
  //alert("delete passage");
});





















function talliableOff() {
	logit("talliable: false");
	talliable = false;
}
function talliableOn() {
	logit("talliable: true");
	talliable = true;
	
}
	

// ! DATABASE CALLS -------------------------------------------------------------------

// DATABSE CALLS





function getFeatureSubtypes(callback) {
	$.getJSON('/api', {
		'request':		'getFeatureSubtypes' 
		},  		
		callback);
	
	
}

function GetRelatedItems(from_entity, from_id, to_entity, relationship, callback, step, orderby) {

	if (! step) 	step = 20;
	if (! orderby)	orderby = "name";
	
	logit('GetRelatedItems:: /api?request=getRelatedItems&from_entity='+from_entity+'&from_id='+from_id+'&to_entity='+to_entity+'&relationship='+relationship);
		
	$.getJSON('/api', {
		'request':		'getRelatedItems',  
			from_entity:	from_entity, 
			from_id:		from_id, 
			to_entity: 		to_entity, 
			relationship:	relationship,
			step:			step,
			orderby: 		orderby						
		},  		
		callback);
}

function updateRelatedItemFields(from_entity, from_id, to_entity, to_id, relationship, fieldname, fieldvalue, callback)
{

	var data = {
				request:	'updateRelatedItemFields',  
				session_id: thisUser.session_id,
				from_entity:	from_entity, 
				from_id:		from_id, 
				to_entity: 		to_entity, 
				to_id: 			to_id, 
				relationship:	relationship,
			}
		data[fieldname] = fieldvalue;

	$.each( data, function( key, value ) {
	  logit( key + ": " + value );
	});	

		$.ajax({
		    type: 'POST',
		    dataType:"html", 
		    url: '/api',
		    data: data,
		    success: function(msg) {
		        logit('saved');
		    }
		});		

}

function saveChanges(entity, id, fieldname, fieldvalue) {
	logit('fieldname = '+fieldname+ ' fieldvalue='+fieldvalue+'--');
	if (fieldvalue == '<br>')  {
		logit ('set fieldvalue to null');
		fieldvalue = "";
		
	}
	
	logit('saveChanges:: /api?request=saveChanges&session_id='+thisUser.session_id+'&entity='+entity+'&id='+id+'&fieldname='+fieldname+'&fieldvalue='+encodeURI(fieldvalue) );
		
		/*
		$.post('/api', {
			request:		'saveChanges',  
			session_id: thisUser.session_id,
			entity:		entity, 
			id:			id, 
			fieldname: 	fieldname, 
			fieldvalue:	fieldvalue
		}, function(data) {
			logit('saved');
			// use new id, if there is one to rest the data in the dom
		});
		*/

		$.ajax({
		    type: 'POST',
		    dataType:"html", 
		    url: '/api',
		    data: {
				request:	'saveChanges',  
				session_id: thisUser.session_id,
				entity:		entity, 
				id:			id, 
				fieldname: 	fieldname, 
				fieldvalue:	fieldvalue
			},
		    success: function(msg) {
		        logit('saved');
		    }
		});		
		
}


function saveMultiChanges(entity, id, data) {
	data['entity'] 			= entity;
	data['id'] 				= id;
	data['request'] 		= 'saveChanges';
	data['session_id']		= thisUser.session_id;
	
	logit('saveMultiChanges:: /api?request=saveChanges&session_id='+thisUser.session_id+'&entity='+entity+'&id='+id );
	$.post('/api', data, function(data) {
			logit('saved... ');
		});
		
}

function addRecord(entity, data, callback) {
	data['entity'] 			= entity;

	data['request'] 		= 'saveChanges';
	data['session_id']		= thisUser.session_id;
	
	
	// define from_entity & from_id if you add to collection
	/*
	logit('addRecord:: /api?request=saveChanges&session_id='+thisUser.session_id+'&entity='+entity );
	$.each( data, function( key, value ) {
	  logit( key + ": " + value );
	});	logit(data);
	*/
	$.getJSON('/api', data, callback);
		
}

function addItemToList(from_entity, from_id, to_entity, to_id, callback)
{
	addItemToList(from_entity, from_id, to_entity, to_id, "null", callback)

}

function addItemToList(from_entity, from_id, to_entity, to_id, relationship, callback)
{
	data = {};
	data['from_entity'] = from_entity;
	data['from_id'] 	= from_id;
	data['to_entity'] 	= to_entity;
	data['to_id'] 		= to_id;
	data['relationship'] 		= relationship;
	
	data['request'] 		= 'addItemToList';
	data['session_id']		= thisUser.session_id;
	
	logit("================= "+addItemToList);
	$.each( data, function( key, value ) {
	  logit( key + ": " + value );
	});	

	$.getJSON('/api', data, callback);


}


function removeItemFromList(from_entity, from_id, to_entity, to_id, callback)
{
	data = {};
	data['from_entity'] = from_entity;
	data['from_id'] 	= from_id;
	data['to_entity'] 	= to_entity;
	data['to_id'] 		= to_id;
	
	if (shiftKey) 
	{
		logit("-DELETE!");
		data['remove_type'] 	= "delFromDB";
	}
	
	
	data['request'] 		= 'removeItemFromList';
	data['session_id']		= thisUser.session_id;
	
	$.getJSON('/api', data, callback);
}


function deletRecordFromDatabase(entity, id, callback) {
	var data = {};
	data['entity'] 			= entity;
	data['id']				= id;
	data['request'] 		= 'deleteItemFromDatabase';
	data['session_id']		= thisUser.session_id;
	
	logit('deleteItemFromDatabase:: /api?request=deleteItemFromDatabase&session_id='+thisUser.session_id+'&entity='+entity +'&id='+id);
	$.getJSON('/api', data, callback);
		
}















// MAPS



























// !-- LOGIN
function tickle() {
	logit('tickle');
	$.getJSON('/api', 
		{request:'tickle', session_id:thisUser.session_id}, function(data) {
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
	raiseLogin();
}
		
function raiseLogin(email) {
		if (loginPanel) loginPanel.remove();
		
		if ($('#loginButton').html() == "Logout" && thisUser && thisUser.isLoggedIn) {
			// LOGOUT
			logit('logout called');
			$.getJSON('/api', 
				{request:'logout', session_id:thisUser.session_id}, function(data) {
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
			tmpemail = thisUser.email;
		} else {
			tmpemail = email;
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
								
								thisUser = data;
								
								logit('Setting user');
								$.jsper.set('thisUser', thisUser);
								showUserLoggedIn();
								//tickle();
								
								loginPanel.html('<center>Thank you for logging in!</center>');
								loginPanel.dialog('option', 'buttons', {
									    'Ok': function() {
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
		if (""+tmpemail == "")
		{
			setTimeout( function() { loginPanel.find('#loginEmail').focus().select();  }, 100);
			
		}
		else 
		{
			setTimeout( function() { loginPanel.find('#loginPass').focus().select();  }, 1000);
			
		}

		$('#loginPass').keypress(function(event) {
			if (event.which == '13') {
				$(".ui-dialog button:contains('Login')").click();
			} 			
		});

}

function showUserLoggedIn() {
	$('#loginButton').html('Logout'); 
	$('#headerUserButton').html(thisUser.name);
	$('#headerUserButton').click(function() {
		//getPage(thisUser);
		//request_ProfileView('Person', thisUser.id);

	});
	$('.edit-show').show();
	$('#registerButton').hide();
	$('#headerUserButton').show();
}
function showUserLoggedOut() {
	thisUser.isLoggedIn = 0;
	$.jsper.set('thisUser', thisUser);

	$('#loginButton').html('Login'); 
	//$('#headerUserButton').html('Guest');
	$('.edit-show').hide('fade');
	$('#headerUserButton').hide('fade');
	$('#registerButton').show();
}



function registerButtonClicked() {
	var registerform = $("<form class=\"registration-form\"><div class=\"form-note\">Currently registration is open only to those people on the Archmap beta access list (this includes students in Holger Klien's summer program in Istanbul). If you are interested in testing Archmap's authoring features, please contact us using the link below.</div></form>");
	registerform.append('Information<hr>');
	registerform.append('<label>First name: </label><input id="firstname" autofocus required />');
	registerform.append('<label>Last name: </label><input id="lastname" required />');
	registerform.append('<label>Email: </label><input id="email" required />');
	registerform.append('<div class="form-note">Password<hr>The password must have at least 6 characters, one uppercase letter and one number.</div>');
	registerform.append('<label>Pssword: </label><input type="password" id="pass1" required />');
	registerform.append('<label>Retype password: </label><input type="password" id="pass2" required />');
	
	registerform.dialog({
		title: "Archmap Registration",
		modal: true,
		width: 400,
		buttons: [
	    {
	        id: "done",
	        text: "Register",
	        click: function() { 
	 	
				// validate form
			    $(":required").removeClass("error");

			    $(":required").each(function(k) {
				    logit($(this).attr("id") + "=" + $(this).val());
				    if ($(this).val() == "") 
				    {
					    $(this).addClass("error");
				    } 
				    
				    
				    if ($(this).attr("id") == "email" && ! validEmail($(this).val()) ) {
					    $(this).addClass("error");
				    }
				    if ($(this).attr("id") == "pass1" && ! validPassword($(this).val()) ) {
					    $(this).addClass("error");
				    }
				    if ($(this).attr("id") == "pass2" && $(this).val() != $("#pass1").val() ) {
					    $(this).addClass("error");
				    }
			    });
			    
			    if ($('.error').length > 0) {
				    logit("Failed");
				    return;
			    }
		
		
		       	var regdata = {};
				regdata['request'] 		= "register";
				regdata['firstname'] 	= $('#firstname').val();
				regdata['lastname'] 	= $('#lastname').val();
				regdata['email'] 		= $('#email').val();
				regdata['pword'] 		= $('#pass1').val();
		   
				logit('?request=register&firstname='+regdata['firstname']+'&lastname='+regdata['lastname']+'&email='+regdata['email']+'&pword='+regdata['pword']);
				$.getJSON('/api', regdata, function(data) {
						if (!data) {
							alert('Could not contact the server.');
							return;
						} else if (data[0] && data[0].result) {
							alert(data[0] && data[0].result);
							return;
						} 		
						
						
						/*
						thisUser = data;
						logit('Setting user');
						$.jsper.set('thisUser', thisUser);
						showUserLoggedIn();
						*/
						//tickle();
						
						registerform.html('<center>Thank you for registering! <p>We have just sent you an email. Please click on the confirmation link to confirm your registration.</center>');
						registerform.dialog('option', 'buttons', {
							    'Ok': function() {
							    
							        $(this).dialog('close');
							    }
						});
						
						
						//setTimeout( function() { loginPanel.dialog( "close" );  }, 700);
					});
			    


	        }
	    },
	    {
	        id: "cancel",
	        text: "Cancel",
	        click: function() {
	         	$(this).dialog("close"); 
	        }
	    }]
	});
	/*
	$("#registrationSubmit").click(function(e) {
		e.preventDefault();
		alert("yousa");
		
	});
	*/

}

function validEmail(e) {
    //var filter = /[a-z0-9._%+-]+@[a-z0-9.-]+\.(?:[a-z]{2}|edu|gov)$/;
    //return String(e).search (filter) != -1;
    
    if (e == "budaksamet@gmail.com") return true;
    if (e == "rolaelnounou3@gmail.com") return true;
    if (e == "dananabtiti@gmail.com") return true;
    if (e == "naznurayzeynep@gmail.com") return true;
    if (e == "ammar.des@gmail.com") return true;
    if (e == "hakan.yerebakan@boun.edu.tr") return true;
    if (e == "mustafa.yildiz1@boun.edu.tr") return true;
    if (e == "egezeytun@gmail.com") return true;
   
    
    
    
    var domain = e.replace(/.*@/, "");
    switch (domain) {
	   case "cyi.ac.cy":
	   case "columbia.edu":
	   case "barnard.edu":
	   case "mellon.org":
	   		return true;
    }
    return false; 
}
function validPassword(p) {
	var filter = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
	return String(p).search (filter) != -1;
}


function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}



	

// FROM: http://andreaslagerkvist.com/jquery/live-search/#jquery-plugin-source
jQuery.fn.liveSearch = function (conf, callback) {
    logit("liveSearch called");
    var config = jQuery.extend({
        url:            '/search-results.php?q=', 
        id:                'jquery-live-search', 
        duration:        400, 
        typeDelay:        300,
        loadingClass:    'loading', 
        onSlideUp:        function () {}, 
        uptadePosition:    false
    }, conf);
    
   

    var liveSearch    = jQuery('#' + config.id);

    // Create live-search if it doesn't exist
    if (!liveSearch.length) {
        liveSearch = jQuery('<div id="' + config.id + '"></div>')
                        .appendTo(document.body)
                        .hide()
                        .slideUp(0)
                        .css('z-index', 90000);

         // Close live-search when clicking outside it
        $('body').click(function(event) {
            var clicked = jQuery(event.target);

            if (!(clicked.is('#' + config.id) || clicked.parents('#' + config.id).length || clicked.is('input'))) {
                liveSearch.slideUp(config.duration, function () {
                    config.onSlideUp();
                });
            }
        });
    }

    return this.each(function () {
        var input                            = jQuery(this).attr('autocomplete', 'off');
        var liveSearchPaddingBorderHoriz    = parseInt(liveSearch.css('paddingLeft'), 10) + parseInt(liveSearch.css('paddingRight'), 10) + parseInt(liveSearch.css('borderLeftWidth'), 10) + parseInt(liveSearch.css('borderRightWidth'), 10);

        // Re calculates live search's position
        var repositionLiveSearch = function () {
            var tmpOffset    = input.offset();
            var inputDim    = {
                left:        tmpOffset.left, 
                top:        tmpOffset.top, 
                width:        input.outerWidth(), 
                height:        input.outerHeight()
            };

            inputDim.topPos        = inputDim.top + inputDim.height;
            inputDim.totalWidth    = inputDim.width - liveSearchPaddingBorderHoriz;

            liveSearch.css({
                position:    'absolute', 
                left:        inputDim.left + 'px', 
                top:        inputDim.topPos + 'px',
                width:        inputDim.totalWidth + 'px'
               
            });
        };

        // Shows live-search for this input
        var showLiveSearch = function () {
            
            // Always reposition the live-search every time it is shown
            // in case user has resized browser-window or zoomed in or whatever
            repositionLiveSearch();

            // We need to bind a resize-event every time live search is shown
            // so it resizes based on the correct input element
            $(window).unbind('resize', repositionLiveSearch);
            $(window).bind('resize', repositionLiveSearch);

            liveSearch.slideDown(config.duration);
        };

        // Hides live-search for this input
        var hideLiveSearch = function () {
            liveSearch.slideUp(config.duration, function () {
                config.onSlideUp();
                //$(this).trigger('keyup');
            });
        };

		var hoverTimer;
		
        input
            // On focus, if the live-search is empty, perform an new search
            // If not, just slide it down. Only do this if there's something in the input
            .blur(function() {
	            
	            hideLiveSearch();
            })
            .mouseleave(function() {
	            hoverTimer = setTimeout(function(){
	            	hideLiveSearch();
	            }, 1000)
	            
            })
            .mouseenter(function() {
	            clearTimeout(hoverTimer);
	            $(this).trigger('focus');
            })
            
            .focus(function () {
                if (this.value !== '') {
                    // Perform a new search if there are no search results
                    if (liveSearch.html() == '') {
                        this.lastValue = '';
                        input.keyup();
                    }
                    // If there are search results show live search
                    else {
                        // HACK: In case search field changes width onfocus
                        setTimeout(showLiveSearch, 1);
                    }
                }
            })
            // Auto update live-search onkeyup
            .keyup(function () {
           
                // Don't update live-search if it's got the same value as last time
                if (this.value != this.lastValue) {
                    input.addClass(config.loadingClass);

                    var q = this.value;

					logit(q);
					
					
                    // Stop previous ajax-request
                    if (this.timer) {
                        clearTimeout(this.timer);
                    }

                    // Start a new ajax-request in X ms
                    this.timer = setTimeout(function () {
                         var url = config.url + q;
                         logit(url);
                         if (q && q != "") 
                         {
                         // logit(url);
	                         $.ajax({
						        url: url,
						        type: 'get',
						        dataType: 'json',
						        async: false,
						        success: function(data) {
			                       
			                       
		                            input.removeClass(config.loadingClass);
		
									
		                            // Show live-search if results and search-term aren't empty
		                            if (data && data.length) {
		                                
		                                
		                                
		                                //liveSearch.html(data);
		                                liveSearch.empty();
		                                
		                                
		                                tmp = $('<div style="background-color: white;font-size:10;padding:10;"></div>');
		                                tmp.mouseleave(function()
		                                {
			                                 hoverTimer = setTimeout(function(){
									            	hideLiveSearch();
									            }, 1000);
										})
										.mouseenter(function() {
								            clearTimeout(hoverTimer);
								            
							            });
									                                
		                                $.each(data, function (k,v) {
		                                	if(v.name) 
		                                	{
			                                	if (callback)
			                                	{
				                                	
				                                	link = $('<div style="margin-bottom: 5;"><span>+ '+v.name+'</span></li>');
				                                	link.click(function() {
				                                			
					                                		callback(v);
					                                	});
													tmp.append(link);
				                             	}
			                                	else
			                                	{
			                                		tmp.append('<div style="margin-bottom: 5;"><a href="/archmap_2/Site/Collection?'+v.entity.toLowerCase()+'_id='+v.id+'">+ '+v.name+'</a></li>');
				                                	
			                                	}
		                                	}
		                                	
		                                });
		                                liveSearch.append(tmp);
		                                
		                                showLiveSearch();
		                            }
		                            else {
		                               hideLiveSearch();
		                            }
		 				        } 
						     });
						    }
						    else 
						    {
							  hideLiveSearch();  
						    }
	                  }, config.typeDelay);

                    this.lastValue = this.value;
                }
            });
    });
}

	
			
				
				
					
						// ADD BEHAVIOR TO EACH THUMBNAIL...
						
								// ! --> SELECT IMAGEVIEW
								/*
								var selectButton = picture.find(".image-selector");
								selectButton.show("slow");
								selectButton.mousedown(function(event) {
									$(this).unbind(event);

									// CREATE AN IMAGE_VIEW
									logit("image selected");
									
									var canvasEl = picture.find('canvas');
									canvas = canvasEl[0];
									
									if (canvas) {
									
										// USE THE CANVAS TO CREATE AN IMAGE
										var img_data   = canvas.toDataURL("image/jpg", 0.8);		
										
										//dialog.destroy();
										
										
										
										
										// CREATE AN IMAGE_VIEW IN THE DATABASE AND RELATE IT TO THE PROFILE ITEM (Passage, Feature, etc.)
		
										// 1. PREPARE REQUEST FOR NEW IMAGE_VIEW

										data= {};
										
										//data['request'] 		= 'saveImageView';
										data['request'] 		= 'saveChanges';
										data['session_id']		= thisUser.session_id;

										data['entity'] 			= "ImageView";
										
										data['image_id'] 		= picture.data("id");
										
										// GET CUREENT IMAGE VIEW STATE
										// At this point, by the time the user has clicked the "selectButton",
										// the user has panned and zoomed the image to frame the item of interest within the larger image.
										// Use this state to define this new ImageView in the database
										if (isPano) {
											// get pano2VR attrs
											data['pan'] 			= imagePlayer.getPan();
											data['tilt'] 			= imagePlayer.getTilt();
											data['fov'] 			= imagePlayer.getFov();
										} else {
											// get Seadragon attrs
											var sd_center			= imagePlayer.viewport.getCenter();
											data['pan'] 			= sd_center.x;
											data['tilt'] 			= sd_center.y;
											data['fov'] 			= imagePlayer.viewport.getZoom();
											
										}

										if (currentElement && currentElement.data("entity")) {
											data['from_entity'] 	= currentElement.data("entity");
											data['from_id'] 		= currentElement.data("id");	
										} else {
											var entityEl = _this.closest(".deletable");
											logit("found:: " + entityEl.attr("class"));
											data['from_entity'] 	= entityEl.data("entity");
											data['from_id'] 		= entityEl.data("id");	
										
										}
										data['relationship'] 	= "figure";
										
										
										// 2. SEND REQUEST FOR NEW IMAGE_VIEW
										
										logit('** REQUEST TO CREATE NEW IMAGE_VIEW ** /api?request=saveChanges&session_id='+thisUser.session_id+'&image_id='+data['image_id']+'&from_entity='+data['from_entity']+'&from_id='+data['from_id']+'&pan='+data['pan']+'&tilt='+data['tilt']+'&fov='+data['fov'] );
										
										
										$.getJSON('/api', data, function(json_data) {
												
												var id = json_data['id'];
												// the data will have the new id of the image view
												logit('**** RESPONSE IMAGE_VIEW.id='+id + ' ****');
												
												// 1. ADD THE ID TO THE FIGURE_LINK IN THE PASSAGE TEXT AND SAVE PASSAGE
												if (figureLink) {												
													figureLink.attr('data-id', id);
													figureLink.parent().parent().blur();
													var par = figureLink.parent('[data-entity="Passage"]');
													logit(".editable blur: "+par.length+', '+par.attr('class'));
												}
												
												// 2. ADD THUMBNAIL TO NEAREST GALLERY
												var img = $("<img />");
												img.attr('src', img_data);
												img.attr('width', 100);
												img.attr('height', 100);
												img.attr('data-id', id);
												img.attr('class', "thumbnail enlargeFigureButton");
												var newThumb = $('<div class="image-view-thumbnail deletable" data-entity="ImageView" data-id="'+id+'" data-image_id="'+data['image_id']+'"  data-image_type="'+picture.data("image_type")+'"  data-filesystem="'+picture.data("filesystem")+'" data-filename="'+picture.data("filename")+'" data-has_sd_tiles="'+picture.data("has_sd_tiles")+'" data-pan="'+data['pan']+'" data-tilt="'+data['tilt']+'" data-fov="'+data['fov']+'"><div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div></div>');
												newThumb.prepend(img);
												
												
												var galleryEl = _this.closest(".item-gallery");
												//if (galleryEl.length < 1) {
												//	galleryEl = currentElement.parent().find(".item-gallery")
												//}
												galleryEl.find(".no-image").remove();
												galleryEl.append(newThumb);
														
																								
												// 3. UPLOAD NEW THUMBNAIL IMAGE TO SERVER
												
												$.post('/archmap_2/upload_center/uploadIconForImageView.php', {
												        id : id,
												        img_data : img_data.replace(/^data:image\/(png|jpg);base64,/, "")
												    }); 
												   
													//dialog.close();
												
											});
										
									}
								});
	
	
								
								
							}
							*/	
	




