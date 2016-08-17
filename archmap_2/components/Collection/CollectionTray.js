
	$(document).ready(function() {
	
		$("html").bind("collectionListArrived", collectionDataArrived);
		
		// GET INITIAL DATA
		dataStore.getAllCollections();
		
	
		$("div#collections").toggle( 
			function(e) {
				$(this).animate({left:0}, 500);
			},
			function(e) {
				$(this).animate({left:-200}, 500);
			}
		);
		
		
	 		
	});
	
	function collectionDataArrived(xml) {
		var canvas = $("ul#collectionList");
		canvas.empty();
		
		for(var d in dataStore.collections) {
		
			var model = dataStore.collections[d].info;
			
		
		
			canvas.append('<li item_id="'+model.id+'" style="padding-bottom:6;"> <a href"">'+model.name+'</a>  </li>');      		
		}
				
		$('ul').sortable({ placeholder: 'ui-state-highlight' });
		$('li').click(function() { dataStore.getCollection($(this).attr("item_id")); } );
	
	}
