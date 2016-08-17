{include file="header.tpl"}

	


	<script>
		var bldgs;
		
		logit("buildings data inline");
		{if $buildings_json}  
			bldgs = {$buildings_json};
		{else} Description 
			bldgs = "";
		{/if}
		
		//alert (bldgs);
		var map;
		
		var selectedBuilding;
		
		function initialize() {
	
			var styles = [
			  {
			    stylers: [
			      { hue: "#e3c7b0" },
			      { saturation: -20 }
			    ]
			  },{
			    featureType: "road",
			    elementType: "geometry",
			    stylers: [
			      { lightness: 100 },
			      { visibility: "simplified" }
			    ]
			  },{
			    featureType: "road",
			    elementType: "labels",
			    stylers: [
			      { visibility: "off" }
			    ]
			  }
			];
	
	
	
			var mapOptions = {
				zoom: 8,
				center: new google.maps.LatLng(-34.397, 150.644),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				styles: styles
			};
			map = new google.maps.Map(document.getElementById('map-canvas'),
			mapOptions);
			
			
			// increase bounds to set off center
			// get width
			latHeight 	= Math.abs({$node.lat} - {$node.lat2});
			
			var lat1 = {$node.lat} -  1.8*latHeight;
			
			var lat2 = {$node.lat2 + 5.5*latHeight};
	
			lngWidth 	= Math.abs({$node.lng2} - {$node.lng});
	
			var lng1 = {$node.lng} - 4.6*lngWidth;
			
			
			var lng2 = {$node.lng2} - lngWidth;
			
			var bounds = new google.maps.LatLngBounds(new google.maps.LatLng(lat1, lng1), new google.maps.LatLng(lat2, lng2));
			map.fitBounds(bounds);
			
			
			var len = bldgs.length;
			for (var i = 0; i<len; i++) {
				
			  createMarkerForBuilding(i, bldgs[i]);
			 
			}	
				
			
		}
		
		var createMarkerAt = function(lat, lng, iconUrl, zInd) {
			var latLng, marker;
			 // logit("marker at  " + lat+ " " + lng);
			latLng = new google.maps.LatLng(lat, lng);
			marker = new google.maps.Marker({
				position: latLng,
				map: map,
				zIndex: zInd,
				icon: iconUrl
			});
			return marker;
	  	}
		var createMarkerForBuilding = function (num, bldg) {
		  var marker, info;
		 // logit(bldg.name + " " + bldg.lat+ " " + bldg.lng);
		  //logit("num="+num + " : {$selected}");
		  var zInd = 1;
		  if (num == {$selected}) {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/yellow-dot.png";
		  	zInd = 100;
		  } else {
		  	icon_url = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
		  }
		  marker = createMarkerAt(bldg.lat, bldg.lng, icon_url, zInd);
		  
		  
		  info = new google.maps.InfoWindow({
		    content: '<img src="'+bldg.poster_url+'" />'
		  });
		  google.maps.event.addListener(marker, 'mouseover', function() {
		    info.open(map, marker);
		  });
		  google.maps.event.addListener(marker, 'mouseout', function() {
		    info.close(map, marker);
		  });	
		  google.maps.event.addListener(marker, 'click', function() {
		    info.close(map, marker);
		    selectItem(bldg.id);
		    
		    // scroll to the num item on the monuments list
		    //...
		    $("#items").scrollTop(num*10-10);
		    
		  });
	
		  
		  return marker;
		}
		
		
		function selectItem(id)	{
			// if only one item selected, then
			
			for (var i = 0; i<bldgs.length; i++) {
				window.location = "/archmap_2/Site/Collection?resource={$node.id}&building_id=" + id;
				if (bldgs[i].id == id) {
					selectedBuilding = bldgs[i];
					logit("select id=" + id);
					displayProfiles();
					break;
				}
			}
	
		}
		
		function displayProfiles() {
			// display selected buildings...
			logit("Displaying: " + selectedBuilding.name + " -- " + $("#monograph"));
			//$("#monograph").empty();
			$("#mono_name").html(selectedBuilding.name);
			
		
		}
		
		
		google.maps.event.addDomListener(window, 'load', initialize);
	
	</script>
	
	
	
	
	
	
	
	
	<!-- MAP UNDERLAY -->
	<div id="map-canvas">
	
	</div>
	
	<div id="map-cover"> </div>
	<div id="map-cover-sidebar"> </div>
	
	
	
		
		
	<div id="sidebar">
		<div class="resource-list  item-list">
			Register of {$itemCount} Monuments in 
			<div><b>{$node.name}</b></div>
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<div>
					<button class="addItemToCollectionButton" data-from_entity="Essay" data-from_id="{$site.id}" data-to_entity="Building">Add a Building</button>
				</div>
			</div>

			
			<dl class="items scrollable">
				{section name=ii loop=$alpha_buildings}
				
					{assign var=city value=", "|explode:$alpha_buildings[ii].name}
					<dt class="item_name"><a href="?resource={$node.id}&building_id={$alpha_buildings[ii].id}">{$city[0]}, {$city[1]}</a></dt>
					
				{/section}	
			</dl>
			<hr>
		</div>
	</div>	
		
		
		
		
	<div id="main-content">
	
		
		
		
		<div class style="width:100%; text-align:right;">
			<span class="download-buttonBuildings">Download as Document</span>
		</div>
		<h1 style="margin-bottom: 10;padding-bottom:0;">{$pageTitle}</h1>
		<div id="closeContent">
			<img src ="/archmap_2/media/ui/close.png" width="25" height="25" />
		</div>

		<div id="wysiwyg-text-edit-menu">
			<button  id="addFootnoteButton" class="footnoteButton edit-show" hidden>Add Footnote</button>
			<button  id="addFigureButton" class="citationButton edit-show addFigureButton" hidden>Add Figure</button>
			<button  id="addCitationButton" class="citationButton edit-show" hidden>Add Citation</button>
		</div>
		
				
		






























<div>	
<h1>Figures</h1>
	{section name=ii loop=$buildings}
		{assign var=rubrics value=$buildings[ii].rubrics}
		{foreach from=$rubrics key=k item=passages}		
					
					{section name=pp loop=$passages}
						
								
															
									<!-- BEG - IMAGE GALLERY FOR THIS PASSAGE -->
									
										{assign var=imageViews value=$passages[pp].imageViews}
										
											{if $imageViews}
											<!-- EACH THUMBNAIL -->
											{assign var=size value=175}
											{section name=iv loop=$imageViews}
											{if $imageViews[iv]}
												<div class="image-view-thumbnail300 deletable" style="margin-right: 5;margin-bottom: 5;width:{$size}; min-height:270;" data-entity="ImageView" data-id="{$imageViews[iv].imageview_id}" data-image_id="{$imageViews[iv].image_id}" data-image_type="{$imageViews[iv].image_type}"  data-filesystem="{$imageViews[iv].filesystem}" data-filename="{$imageViews[iv].filename}" data-has_sd_tiles="{$imageViews[iv].has_sd_tiles}" data-pan="{$imageViews[iv].pan}" data-tilt="{$imageViews[iv].tilt}" data-fov="{$imageViews[iv].fov}">
													<img class="thumbnail enlargeFigureButton" title="Rory O'Neill, April, 2012   (AM.IMG  {$imageViews[iv].image_id})" src="{$imageViews[iv].webpath}/{$imageViews[iv].imageview_id}_300.jpg" width="175" height="175" />
													<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
													<div>
														<B>Fig. {$figCount++}</B>
														<div style="font-size: 14">
															<a href="/archmap_2/Site/Collection?resource={$node.id}&building_id={$buildings[ii].id}">{$buildings[ii].name}</a> 
														</div>
														<div style="font-size: 14">
														<div data-entity="ImageView" data-id="{$imageViews[iv].imageview_id}" data-field="name"  style="font-size: 12"   class="editable" contenteditable="false">{if $imageViews[iv].name}{$imageViews[iv].name}{else}caption{/if}</div>
															<!-- {$imageViews[iv].name}- -->
														</div>
														<div style="font-size: 10">
															Rory O'Neill, April, 2012
														</div>
													</div>
												</div> 
											{/if}
											{/section}
										
										{/if}
									
										
										
										
										
										
										
									
									
									
									<!-- END - IMAGE GALLERY FOR THIS PASSAGE -->
									
									
								
					
					{/section}
					
					
		{/foreach}	
{/section}
</div>



<div style="clear: both;">-</div>






























































































		
		
		
		{assign var=figCount value=1}
		{assign var=featureCount value=1}

		
		
		<!-- EACH BUILDING -->	
			
		{section name=ii loop=$buildings}
				
				
				
				
				
				
				
				
				
			{assign var=city value=", "|explode:$buildings[ii].name}
			{assign var=bldg value=$buildings[ii]}

			{assign var=size value=125}
			{assign var=thumbsize value=100}

			<div class="mono-profile entity-profile catalog-item" data-entity="Building" data-id="{$bldg.id}">
				
				
				<!-- HEADER -->
				
				<table width="100%">
					<tr>
						<td valign="bottom">
						
							<div>
							AM.{$bldg.id}
							</div>
							
							
							<div class="catalog-item-title">
							{$bldg.name}, ca.  <span data-entity="Building" data-id="{$bldg.id}" data-field="date" class="editable" contenteditable="false" >{$bldg.date}</span>
		
							</div>
						</td>
						
						
						
					</tr>
				</table>
							
				<hr>
				
				<div style="text-align:right;">
					<span id="seeAlImages" class="openImageGallery">All Images</span>
					</div>
	
	
	
	
	
	
		
					<!-- BUILDING CONTENT -->
									
					<table width="100%">
					<tr>	
			
						
						
						<td valign="top">
						
						
							
					
																	
												
								<!-- BUILDING PASSAGES -->
									
									{assign var=rubrics value=$buildings[ii].rubrics}
									{foreach from=$rubrics key=k item=passages}		
																		
											<div class="rubric-block" data-rubric_name="{$k}">
											
												<div class="rubric list-addable"  data-entity="Passage">{$passages[0].name}<hr></div>
												
												{section name=pp loop=$passages}
													
														<div class="passage deletable" style="margin:bottom:20;" data-entity="Passage" data-id="{$passages[pp].id}" {if !$passages[pp].descript}style="display:none;"{/if}>
															
															<!-- TEXT OF PASSAGE -->
															<div data-entity="Passage" data-id="{$passages[pp].id}" data-field="descript" class="editable text-figure-droppable" contenteditable="false">{if $passages[pp].descript}{$passages[pp].descript}{else}edit{/if}</div>
															
															<div class="passage-footer">
															
															
																<div> - <a href="">{$passages[pp].author_name}</a>, {$passages[pp].editdateString}</div>
																
																
																<!-- BEG - IMAGE GALLERY FOR THIS PASSAGE -->
																
																<div class="item-gallery">
																	{assign var=imageViews value=$passages[pp].imageViews}
																	{if $passages[pp].imageViews}
																	Gallery
																	{section name=iv loop=$imageViews}
																		<div class="image-view-thumbnail drag-icon deletable" data-entity="ImageView" data-id="{$imageViews[iv].imageview_id}" data-image_id="{$imageViews[iv].image_id}" data-image_type="{$imageViews[iv].image_type}"  data-name="{$imageViews[iv].name}"  data-filesystem="{$imageViews[iv].filesystem}"  data-filepath="{$imageViews[iv].filepath}" data-filename="{$imageViews[iv].filename}" data-has_sd_tiles="{$imageViews[iv].has_sd_tiles}" data-pan="{$imageViews[iv].pan}" data-tilt="{$imageViews[iv].tilt}" data-fov="{$imageViews[iv].fov}">
																					<img class="thumbnail enlargeFigureButton" src="{$imageViews[iv].webpath}/{$imageViews[iv].imageview_id}_100.jpg" width="100" height="100" />
																					<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
																		</div> 
																	{/section}
																	{/if}
																	
																	<div class="gallery menu edit-mode-only"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>
							
																</div>
																
																
																<!-- END - IMAGE GALLERY FOR THIS PASSAGE -->
																
																
																<div style="clear: left;">-</div>
															</div>
														</div>
												
												{/section}
												</div>
												
												
												
											</div>			
									{/foreach}	
											
													
																
																		
																		
											
											
											
											
								
							<!-- BIBLIOGRAPHY -->
							<div style="margin-bottom: 40;">
								<div class="rubric list-addable"  data-entity="Publication">BIBLIOGRAPHY<hr></div>
								<!--
								<div class="rubric list-addable"  data-entity="Publication">Bibliography<hr></div>
								-->
							
							
						
								<div class="edit-mode-only" style="margin-bottom:10;">
									<div>
										<button class="addItemToCollectionButton" data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication">Add a Publication</button>
										<button class="addItemFromZoteroButton" data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication">Import from Zotero</button>
									</div>
								</div>
					
								
								<div class="biblio-import-widget edit-mode-only"></div>
							
								
								<div>
									{assign var=publications value=$buildings[ii].publications}
									
									{section name=p loop=$publications}
									
										{assign var=pub value=$publications[p]}
									
										<li class="entity-profile deletable biblio-record"    data-id="{$pub.id}">
											
											<span class="biblio-link">{include file="PubStyle_ArtHistory.tpl"}</span>{if $pub.pages},{/if} <span data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication" data-to_id="{$pub.id}" data-fieldname="pages" class="editable" contenteditable="false" >{$pub.pages}</span>
											
										</li>
									
									{/section}
								</div>	
									
							</div>

												
											
											
										
										
										
										
				
							</td>
										
					
					
					
					
					
					
							<!-- BULDING POSTERS -->
								
						
						<!-- BUILDING DEPICTIONS -->
						
						<td width="100">
									
								<!-- POSTER -->
								<div class="monograph-thumb"> 
									<div class="picture link " data-building_id="{$bldg.id}" data-image_type="{$bldg.poster.image_type}"  data-filename="{$bldg.poster.filename}" data-id="{$bldg.poster.id}">
											<div class="poster-view fieldname-poster_id ">
												<div class="imageAreaGrid">				
														<img src="{$buildings[ii].poster_url300}" width="{$size}" height="{$size}"  />
														
														<!--	
														<img src="{$buildings[ii].latsec_url}" width="{$bldg.plan.width/10}" height="{$bldg.plan.height/10}" />
														-->
												</div>
											</div>	
									</div>	
								</div>
								
						</td>
						
						<td width="100">
					
					
								
								<!-- PLAN -->
								{assign var=image value=$buildings[ii].planImage}
								{if $image}
							
								<div style="border: solid 2 gray;width: {$size}; height: {$size}; position: relative">
									
								
									{if $image.width>$image.height}
										{assign var=w value=$size}
										{assign var=h value=$w*($image.height/$image.width)}
									{else}
										{assign var=h value=$size}
										{assign var=w value=$h*($image.width/$image.height)}
									{/if}
									
									<div  class=" enlargeFigureButton" data-entity="Image" data-image_type="{$image.image_type}" data-id="{$image.id}" data-filesystem="{$image.filesystem}"  data-filename="{$image.filename}" data-has_sd_tiles="{$image.has_sd_tiles}" data-pan="{$image.pan}" data-tilt="{$image.tilt}" data-fov="{$image.fov}">	
										<div style="position:absolute;left: {($size-$w)/2};top: {($size-$h)/2};z-index:10;"><img src="{$buildings[ii].plan_url300}" width="{$w}" height="{$h}" />
									</div>
									
									{assign var=plots value=$buildings[ii].planPlots}
									{if $plots}
									{section name=pp loop=$plots}
										<div style="position:absolute;left: {$plots[pp].pos_x*$size+($size-$w)/2-15};top: {$plots[pp].pos_y*$size+($size-$h)/2-15};z-index:15;">
											<img class="drag-icon icon32" 			src="/archmap_2/media/ui/FeatureIcon.png" 		width="25" height="25" data-entity="Feature" data-id="{$features[ff].id}" data-name="{$features[ff].name}" />
										</div>
									{/section}
									{/if}
										
								</div>	
								
								{/if}				
							
								
						
						
						
						
						</td>
				
					
	
						
						
					</tr>
					</table>
					
					</div>
					{/section}
						
						
						
					



	{include file="footer.tpl"}
	
		
	

	