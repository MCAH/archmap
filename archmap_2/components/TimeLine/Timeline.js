	
	//$(document).ready(initializeTimeline);
	$("html").bind("initialize", renderTimeline);
	$("html").bind("selectionChanged", updateTimeline);
	
	function updateTimeline() {
	
		var canvas = $("ul#timeline_ul");
		var select = dataStore.lastSelected;
		var key = select.reference+"/"+select.info.id;
		canvas.find("div.timeline-element").removeClass("toggleOn").addClass("bar");
		canvas.find("div.timeline-element div").remove();
		canvas.find("div.timeline-element[rel='"+key+"']").removeClass("bar").addClass("toggleOn").append('<div style="padding-left: 20; color:#ff3333;">Fire   <img src="http://www.learn.columbia.edu/archmap/media/interface/icons/Fire.png" width="10" height="10" /></div> <div style="padding:2;padding-left: 40; color:#773333;background:#ffefef;margin-bottom:3; ">Chevet  <div>*?????*-----------[*]</div><div style="padding-left:20;">*------*??* (Bony, 1983, p.213)</div> </div> <div style="padding-left: 110; color:#773333;">Nave *---------------------------------* </div>');
		var top_animate = parseInt(canvas.find("div.timeline-element[rel='"+key+"']").position().top);
		var left_animate = parseInt(canvas.find("div.timeline-element[rel='"+key+"']").css('left'));
		//alert(left_animate);
		canvas.parent().animate({ scrollLeft: left_animate - 85, scrollTop: top_animate - 85 }, 1000);
		//canvas.parent().scrollLeft(left_animate - 85).scrollTop(top_animate - 85);
	}
	
	
	function renderTimeline() {
		var canvas = $("ul#timeline_ul");
		canvas.empty();
			
		//$('ul').sortable({ placeholder: 'ui-state-highlight' });	
				
		// DISPLAY PARAMETERS
		
		

		var period_beg_year = dataStore.minYear - 5;
		var period_end_year = parseInt(dataStore.maxYear) + 5;
		var duration = period_end_year - period_beg_year;
		var scale = canvas.width() / duration; // wid / years

		
		var year_bay = duration/10;
		
		if (year_bay > 100) {
			year_bay = 100;
			
		} else if (year_bay > 50) {
			year_bay = 50;
		} else if (year_bay > 25) {
			year_bay = 25;
		} else if (year_bay > 10) {
			year_bay = 10;
		} else if (year_bay > 5) {
			year_bay = 5;
		} else { 
			year_bay = 1;
		}
			
			

			
		// DRAW BACKGROUND GRID
		var tlCanvas = $("div#timelineBG");
		tlCanvas.empty();
		var c = 0;
		for (var year=period_beg_year; year<=period_end_year; year += year_bay) {
			var color = (c++ % 2 ? "#ffeeee" : "#eeffee" );
			// Year areas
			tlCanvas.append('<div style="font-size:9;opacity:.80;position:absolute;top:0;left:'
				+((year-period_beg_year)*scale)+'; width:'+(year_bay*scale-3)
				+';height:700px;background:'+color+';"><b>'+year+'</b>  </div>');
		}
		
		// PLOT ITEMS ON TIMELINE
		// dataStore:: loop through buildings
		
		for(var d in dataStore.data) {
		
			var model = dataStore.data[d].info;
			var x = ( model.beg_year - period_beg_year ) * scale;
			var zindex = 2000;
			var duration = model.end_year - model.beg_year;
			var wid = duration*scale;
			if (wid <=0) wid=300;
			
			var html = '<li><div class="bar timeline-element" id="'+d+'" rel="'+d+'" '
				+'style="z-index:'+(zindex++)+'; margin:3px;font-size:9px;width:'+wid+';'
				+'position:relative;top:20px;left:'+x+'px;"><b>'+model.name+'</b> </div> </li>';
			//alert(html)
			canvas.append( html );
			
		}
		
		/*
		$(dataStore.xml).find("item").each(function() {
			var model 			= new Object();
				model.id 		= $(this).find("id").text();
				model.name 		= $(this).find("name").text();
				model.beg_year 	= $(this).find("beg_year").text();
			
			var x 				= (model.beg_year-period_beg_year) * scale;
			var cssClassName 	= (dataStore.selectedItems[model.id]) ? "toggleOn" : "bar";
		   	
		   	var zindex = 2000;
		   	
		   	if ((dataStore.selectedItems[model.id])) {
		   		canvas.append('<li><div id="'+model.id+'" item_id="'+model.id+'" class="'+cssClassName+'" style="z-index:'+(zindex++)+';margin:3;font-size:9;position:relative;top:20;left:'+x+';"><b>'+model.name+'</b>  <div style="padding-left: 20; color:#ff3333;">Fire   <img src="http://www.learn.columbia.edu/archmap/media/interface/icons/Fire.png" width="10" height="10" /></div> <div style="padding:2;padding-left: 40; color:#773333;background:#ffefef;margin-bottom:3; ">Chevet  <div>*?????*-----------[*]</div><div style="padding-left:20;">*------*??* (Bony, 1983, p.213)</div> </div> <div style="padding-left: 110; color:#773333;">Nave *---------------------------------* </div> </div>');
		   	
		   	} else {
		   		canvas.append('<li><div  id="'+model.id+'" item_id="'+model.id+'" class="'+cssClassName+'" style="z-index:'+(zindex++)+'; margin:3;font-size:9;position:relative;top:20;left:'+x+';"><b>'+model.name+'</b>  </div></li>');
		   		//canvas.find("div."+cssClassName).draggable({helper: 'clone', opacity: .5});
		   	}
		});
		*/		
		
		
		// BIND EVENTS TO EACH DIV
		$('div#timeline_canvas').find('div').hover(
			function() { 
				$(this).addClass('over');
			},
			function() { $(this).removeClass('over');}
		);
		
		// CLICK EVENT
		$('div#timeline_canvas').find('div').click(
			function() { 
				//$(this).addClass('toggleOn');
				dataStore.clickItem($(this).attr("rel"));
			}
		);
		
	
	}