		$(document).ready(initLayoutTimeline);
		
		function initLayoutTimeline() {
			
			//$(window).bind('resize', doResize);	
					
			//$('div#map_box').bind('resize', function(event, ui) {map.setCenter(new GLatLng(49.0, 2.8), 5)} );	

			//var w = 300; //$("html").width()/ 5;
			//var h = 250; //$("html").height() / 6;
			//$.ui.dialog.defaults.bgiframe = true;
			
			//$('div#map_box').dialog({ width: w, height: h, position: ['right','top'], resize: function(event, ui) {map.setCenter(new GLatLng(49.0, 2.8), 5); } });
			
			$("div#map_canvas").css('height','300px');
		}
		
		//function doResize() {
		    //$('div#map_box').dialog('option', 'position', ['right','top']);
		//}
