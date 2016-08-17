
$(document).ready(initializeTimeline);


function initializeTimeline() {

	// BIND EVENTS TO DATA_STORE  VIA THE HTML OBJECT
	$("html").bind("selectionChanged", renderTimeline);
 		
}

function updateTimeline() {

	var canvas = $("ul#timeline_ul");
	$(dataStore.xml).find("item").each(function() {
		var model 			= new Object();
			model.id 		= $(this).find("id").text();
			model.name 		= $(this).find("name").text();
			model.beg_year 	= $(this).find("beg_year").text();
		
		var x 				= (model.beg_year-period_beg_year) * scale;
		var cssClassName 	= (dataStore.selectedItems[model.id]) ? "toggleOn" : "bar";
		
		if (dataStore.selectedItems[model.id]) {
			$canvas.find("div#"+model.id).removeClass("bar");
			$canvas.find("div#"+model.id).addClass("toggleOn");
			
		} else {
			$canvas.find("div#"+model.id).removeClass("toggleOn");
			$canvas.find("div#"+model.id).addClass("bar");
		
		}
		
	});		
}


function renderTimeline() {
	var canvas = $("ul#timeline_ul");
		canvas.empty();
		
		$('ul').sortable({ placeholder: 'ui-state-highlight' });	
			
	// DISPLAY PARAMETERS
	var period_beg_year = 1120;
	var period_end_year = 1320;
	var year_bay 		= 10;
	var scale	 		= canvas.width() / 100.0; // wid / years
	
		
	// DRAW BACKGROUND GRID
	var tlCanvas = $("div#timelineBG");
		tlCanvas.empty();
	var c = 0;
	for (var year=period_beg_year; year<=period_end_year; year += year_bay) {
		var color = (c++ % 2 ? "#ffeeee" : "#eeffee" );
		// Year areas
		tlCanvas.append('<div style="font-size:9;opacity:.80;position:absolute;top:0;left:'+((year-period_beg_year)*scale)+'; width:'+(year_bay*scale-3)+'; height: 700px;background:'+color+';"><b>'+year+'</b>  </div>');
	}
	
	
	
	
	// PLOT ITEMS ON TIMELINE
	// dataStore:: loop through buildings
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
			dataStore.clickItem($(this).attr("item_id"));
		}
	);
	

}