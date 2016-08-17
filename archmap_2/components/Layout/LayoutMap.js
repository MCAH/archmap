		$(document).ready(initLayoutMap);
		
		function initLayoutMap() {
			
			$(window).bind('resize', function() {
				var ww = $("html").width()/ 1.6;
				var hh = $("html").height() / 9;
			    $('div#timeline_box').dialog('option', 'width', ww);
			    $('div#timeline_box').dialog('option', 'position', 'bottom');
			    
			});	
					
			var w = $("html").width()/ 1.4;
			var h = $("html").height() / 9;
			
			$('div#map_canvas').css('height',($(window).height() - $("div#header").height() ));
			$('div#timeline_box').dialog({ width: w, height: h, position: 'bottom' });
			
		}