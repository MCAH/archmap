$(document).ready(initializeMap);
	
	
	var map;
	
	  
	
    function initializeMap() {
    
     		
		if (GBrowserIsCompatible()) {
			map = new GMap2(document.getElementById("map_canvas"));
			map.setCenter(new GLatLng(49.0, 2.8), 5);
			//map.setUIToDefault();
			map.setMapType(G_SATELLITE_MAP);
			renderMap();
		}
      
		$("html").bind("selectionChanged", renderMap);
     	

		$("html").bind('resize', function() {
			//var ww = $("html").width()/ 1.6;
			//var hh = $("html").height() / 9;
 			map.setCenter(new GLatLng(49.0, 2.8));		    
		});	
		
		

    }
    
    function renderMap() {
	
		map.clearOverlays();


		
       // Create our "tiny" marker icon
        var blueIcon = new GIcon(G_DEFAULT_ICON);
      	blueIcon.iconSize = new GSize(10,10);
        blueIcon.image = "http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png";


		var w = $("window").width();
		
		var icon_w = w / 100;
		
		var newIcon =	MapIconMaker.createMarkerIcon({width: 20, height: 20, primaryColor: "#8877ff"});	
		var selIcon =	MapIconMaker.createMarkerIcon({width: 25, height: 25, primaryColor: "#ff7788"});	
			
		// Set up our GMarkerOptions object
		markerOptions 		= { icon:newIcon };
		selmarkerOptions 	= { icon:selIcon };

			
		var lat_min;
		var lat_max;
		var lng_min;
		var lng_max;
	
		var tester = 99;

		$(dataStore.xml).find("item").each(function() {
		
			var model 			= new Object();
				model.id 		= $(this).find("id").text();
				model.name 		= $(this).find("name").text();
				model.lat  		= $(this).find("lat").text();
				model.lng  		= $(this).find("lng").text();
				
				//alert(lat_min + "<" +model.lat + "<"+lat_max);
				if (model.lat != 0) {
					if (! lat_min || model.lat < lat_min) lat_min = model.lat;
					if (! lat_max || model.lat > lat_max) lat_max = model.lat;
					if (! lng_min || model.lng < lng_min) lng_min = model.lng;
					if (! lng_max || model.lng > lng_max) lng_max = model.lng;
				}
            	var latlng = new GLatLng(model.lat, model.lng);
	           
		           
	           	var marker;
	            
	           	if(dataStore.selectedItems[model.id]) {
	           		marker = new GMarker(latlng, selmarkerOptions);
	           		marker.selected = true;
	           	} else {
	           		marker = new GMarker(latlng, markerOptions);
	           		marker.selected = false;
	           	}
	           	marker.id = model.id;
	           	
	           	
				GEvent.addListener(marker, "click", function() {
    				
    				dataStore.clickItem(this.id);
    				
    				
  				});	           
  				map.addOverlay(marker);
	            
		});		
		
		var newIcon =	MapIconMaker.createMarkerIcon({width: 20, height: 20, primaryColor: "#88ff66"});	
		var selIcon =	MapIconMaker.createMarkerIcon({width: 25, height: 25, primaryColor: "#ff7755"});	
			
		// Set up our GMarkerOptions object
		markerOptions 		= { icon:newIcon, title:"amiens" };
		selmarkerOptions 	= { icon:selIcon };

		$(dataStore.xml).find("Person").each(function() {
		
			var model 			= new Object();
				model.id 		= $(this).find("id").text();
				model.name 		= $(this).find("name").text();
				model.lat  		= $(this).find("lat").text();
				model.lng  		= $(this).find("lng").text();
				
				//alert(lat_min + "<" +model.lat + "<"+lat_max);
				if (model.lat != 0) {
					if (! lat_min || model.lat < lat_min) lat_min = model.lat;
					if (! lat_max || model.lat > lat_max) lat_max = model.lat;
					if (! lng_min || model.lng < lng_min) lng_min = model.lng;
					if (! lng_max || model.lng > lng_max) lng_max = model.lng;
				}
            	var latlng = new GLatLng(model.lat, model.lng);
	           
		           
	           	var marker;
	            
	           	if(dataStore.selectedItems[model.id]) {
	           		marker = new GMarker(latlng, selmarkerOptions);
	           		marker.selected = true;
	           	} else {
	           		marker = new GMarker(latlng, markerOptions);
	           		marker.selected = false;
	           	}
	           	marker.id = model.id;
	           	
	           	
				GEvent.addListener(marker, "click", function() {
    				
    				dataStore.clickItem(this.id);
    				
    				
  				});	           
  				map.addOverlay(marker);
	            
		});		
		
		//lat_min =  40;
		//lat_max = 50.0;
		//lng_min =  1.0;
		//lng_max = 4.0;;

		if (lat_min) {
			
			var b1 = new GLatLng(lat_min, lng_min);
			var b2 = new GLatLng(lat_max, lng_max)
			boundingBox = new GLatLngBounds(b1, b2);
			
			var z = map.getBoundsZoomLevel(boundingBox);
			if (z > 6) z=6;
			map.setZoom(z);
			map.setCenter( boundingBox.getCenter());
		}


		//frameAll();

		//alert(res);
	
      
     }