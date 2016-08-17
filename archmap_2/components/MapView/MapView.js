	
	var map;
	// Create our "tiny" marker icon
	//var blueIcon = new GIcon(G_DEFAULT_ICON);
	//blueIcon.iconSize = new GSize(10,10);
	//blueIcon.image = "http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png";
	
	var iconBlue = new GIcon();
	iconBlue.image = 'http://labs.google.com/ridefinder/images/mm_20_blue.png';
	iconBlue.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
	iconBlue.iconSize = new GSize(12, 20);
	iconBlue.shadowSize = new GSize(22, 20);
	iconBlue.iconAnchor = new GPoint(6, 20);
	iconBlue.infoWindowAnchor = new GPoint(5, 1);
	
	$("html").bind("initialize", initializeMap);
	$("html").bind("selectionChanged", highlightSelected);
	$("html").bind('resize', function() {
		map.setCenter(new GLatLng(49.0, 2.8)); 
	});
	
	function initializeMap() {
	
		if (GBrowserIsCompatible()) {
			map = new GMap2(document.getElementById("map_canvas"));
			map.setCenter(new GLatLng(49.0, 2.8), 5);
			map.setUIToDefault();
			map.setMapType(G_SATELLITE_MAP);
			renderMap(); // one time only deal, unless necessary refresh-type thing
			
			///// OSM CUSTOM STYLE SWEETNESS
			///// with many thankyous to Tom Taylor's Boundaries tool
			///// http://boundaries.tomtaylor.co.uk/
			
			var copyOSM = new GCopyrightCollection('<a href="http://www.openstreetmap.org/">OpenStreetMap</a>');
			copyOSM.addCopyright(new GCopyright(1, new GLatLngBounds(new GLatLng(-90, -180), new GLatLng(90, 180)), 0, ' '));
				
			var osmLayer = new GTileLayer( copyOSM, 3, 18, {
				//tileUrlTemplate: 'http://b.tile.cloudmade.com/072c71925949590983c1e45c3b17fe0b/7843/256/{Z}/{X}/{Y}.png',
				tileUrlTemplate: 'http://b.tile.cloudmade.com/072c71925949590983c1e45c3b17fe0b/8351/256/{Z}/{X}/{Y}.png',
				isPng: true, opacity: 1.0 } );
			
			var osmMap = new GMapType( [osmLayer], G_NORMAL_MAP.getProjection(), 'OSM' );
			map.addMapType(osmMap);
			//map.setMapType(osmMap);
		}
		
	}
	
	function highlightSelected() {
		for(var d in dataStore.data)
			dataStore.data[d].info.marker.setImage('http://labs.google.com/ridefinder/images/mm_20_green.png');
		var select = dataStore.lastSelected.info.marker;
		select.setImage('http://labs.google.com/ridefinder/images/mm_20_red.png');
		map.panTo(select.getLatLng());
		select.selected = true;
	}
    
	function renderMap() {
	
		map.clearOverlays();

		var w = $("window").width();
		var icon_w = w / 100;
		
		var lat_min;
		var lat_max;
		var lng_min;
		var lng_max;

		// and plot

		for(var d in dataStore.data) {
		
			var model = dataStore.data[d].info;
			
			if (model.lat != 0) {
				if (! lat_min || model.lat < lat_min) lat_min = model.lat;
				if (! lat_max || model.lat > lat_max) lat_max = model.lat;
				if (! lng_min || model.lng < lng_min) lng_min = model.lng;
				if (! lng_max || model.lng > lng_max) lng_max = model.lng;
			}
			
			var latlng = new GLatLng( model.lat, model.lng );
			marker = new GMarker( latlng, { icon: iconBlue, title: d } );
			marker.selected = false;
			model.marker = marker;
			
			GEvent.addListener(marker, "click", function() {
				dataStore.clickItem(this.getTitle());
			});
			
			map.addOverlay(marker);
		}

		if (lat_min) {
			
			var b1 = new GLatLng(lat_min, lng_min);
			var b2 = new GLatLng(lat_max, lng_max)
			boundingBox = new GLatLngBounds(b1, b2);
			
			var z = map.getBoundsZoomLevel(boundingBox);
			if (z > 6) z=6;
			map.setZoom(z);
			map.setCenter( boundingBox.getCenter());
		}
	}