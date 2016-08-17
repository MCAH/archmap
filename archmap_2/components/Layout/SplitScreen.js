	$(document).ready(initLayoutSplitScreen);
		
	function initLayoutSplitScreen() {
		$("div#stage").css('height',$(window).height() - $("div#header").height() );
		var stage_height = $("div#stage").height();
		$("#map_canvas").css('height',(stage_height/1.5)+"px");
		$("#timeline_box").css('height',(stage_height/3)+"px");
	}