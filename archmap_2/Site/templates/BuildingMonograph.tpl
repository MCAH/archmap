<div class="mono-profile entity-profile" data-entity="{$monograph_entity}" data-id="{$bldg.id}">

	<table width="100%">
	<tr>
	<td width="30%" valign="top">
	<div id="main-content-left"  style="position: relative">
		

		<!-- MAIN POSTER -->
		{assign var=image value=$bldg.poster}
			
		{if $bldg.poster_url300 == "/archmap_2/media/ui/NoImage.jpg"}
			<div class="picture immediate image-droppable" data-fieldname="poster_id" style="position: relative"	>
				
				<div class="poster-view fieldname-poster_id">
					<div class="picture-frame" style="width: 300; height: 300;">
						<div id="image-viewer-tmp" class="imageArea imageViewer" style="width: 300;height: 300;">
							<img class="choose-poster" src="/archmap_2/media/ui/NoImage.jpg" width="300" height="300"  />
						</div>
					</div>
					<div class="picture-frame-shadow" style="width:340px;"></div>
				</div>	
				
				
			</div>	
		{else}
			{assign var=hgt value=(300*{$image.height}/{$image.width})}
			{assign var=hgt value=300}
			<div class="picture immediate image-droppable" style="position: relative"	data-fieldname="poster_id"	data-entity="Image" 	data-id="{$image.id}" 	data-image_type="{$image.image_type}" 		data-filesystem="{$image.filesystem}" data-filepath="{$image.filepath}" data-filename="{$image.filename}"  data-image_id="{$image.id}" data-has_sd_tiles="{$image.has_sd_tiles}"  	data-pan="{$image.pan}"  data-tilt="{$image.tilt}"  data-fov="{$image.fov}">
				
				<div class="poster-view fieldname-poster_id">
					<div class="picture-frame  " style="width: 300; height: {$hgt};">
						<div id="image-viewer-{$image.id}" class="imageArea imageViewer" style="width: 300;height: {$hgt};">
							<img src="{$bldg.poster_url300}" width="300" height="{$hgt}"  />
						</div>
						<div class="picture-title editable" data-entity="Image" data-id="{$image.id}" data-field="name" contenteditable="false">{$image.title}</div>
					</div>
					<div class="picture-frame-shadow" style="width:340px;"></div>
				</div>	
				
				
				
				<div class="edit-mode-only"  style="position: absolute; left:25; top:3">
					<button class="set-view">Set View</button>
				</div>

			</div>	
		{/if}


		<!-- PLAN -->
		{assign var=image value=$bldg.planImage}
		<div class="picture immediate image-droppable" style="position: relative"	data-fieldname="plan_image_id"	data-entity="Image" 	data-id="{$image.id}" 	data-image_type="{$image.image_type}" 		data-filesystem="{$image.filesystem}" data-filepath="{$image.filepath}"  data-filename="{$image.filename}"  data-image_id="{$image.id}" data-has_sd_tiles="{$image.has_sd_tiles}"  	data-pan="{$image.pan}"  data-tilt="{$image.tilt}"  data-fov="{$image.fov}">
			<div class="poster-view fieldname-poster_id">
				<div class="picture-frame  " style="width: 300; height: 300;">
					<div id="image-viewer-{$image.id}" class="imageArea imageViewer" style="width: 300;height: 300;">
						<img src="{$bldg.plan_url300}" width="300" height="300"  />
					</div>
					<div class="picture-title editable" data-entity="Image" data-id="{$image.id}" data-field="name" contenteditable="false">{$image.name}</div>
				</div>
				<div class="picture-frame-shadow" style="width:340px;"></div>
			</div>
			
						
			<div class="edit-mode-only"  style="position: absolute; left:25; top:3">
				<button class="set-view">Set View</button>
			</div>
	
		</div>	

		


		<!-- SECTION -->
		{assign var=image value=$bldg.latsecImage}
		<div class="picture immediate image-droppable" style="position: relative"	data-fieldname="lat_section_image_id"	data-entity="Image" 	data-id="{$image.id}" 	data-image_type="{$image.image_type}" 		data-filesystem="{$image.filesystem}" data-filepath="{$image.filepath}"  data-filename="{$image.filename}"  data-image_id="{$image.id}" data-has_sd_tiles="{$image.has_sd_tiles}"  	data-pan="{$image.pan}"  data-tilt="{$image.tilt}"  data-fov="{$image.fov}">
			<div class="poster-view fieldname-poster_id">
				<div class="picture-frame  " style="width: 300; height: 300;">
					<div id="image-viewer-{$image.id}" class="imageArea imageViewer" style="width: 300;height: 300;">
						<img src="{$bldg.latsec_url300}" width="300" height="300"  />
					</div>
					<div class="picture-title editable" data-entity="Image" data-id="{$image.id}" data-field="name" contenteditable="false">{$image.name}</div>
				</div>
				<div class="picture-frame-shadow" style="width:340px;"></div>
			</div>
			
						
			<div class="edit-mode-only"  style="position: absolute; left:25; top:3">
				<button class="set-view">Set View</button>
			</div>
	
		</div>	

		








		<!-- FEATURES "incorporates" -->
		<div id="feature-list" data-relationship="incorporates">
			
			<div class="menu edit-mode-only">
				<button class="add-feature button">Add a Feature</button>
				
				
			</div>
			<div id="feature-list-items">
			
			{foreach from=$featuresets key=k item=features}
				<div class="feature-block list-block" data-entity="Feature" data-subtype="{$features[0].subtype}">
					{assign var=subtype value=$features[0].subtype}

					
					<div class="list-block-label"><b><a href="Catalog?site={$site.id}&type={$subtype}">{$k}</a></b><hr></div>
					
					
					<img class="addButton new button" title="Add an item to this list" src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 />
					
					
					{section name=ff loop=$features}
						
							<div class="entity-profile feature deletable" data-entity="Feature"  data-subtype="{$features[ff].subtype}" data-id="{$features[ff].id}">
								
								<table width="100%">
									<tr>
										<td valign="top" width="110px" class="item-gallery" data-entity="ImageView">
											
											
											<!-- GALLERY -->
											{assign var=imageViews value=$features[ff].imageViews}
											
											{if $imageViews}
												<!-- image thumbnails -->
												{section name=iv loop=$imageViews}
													<div class="image-view-thumbnail deletable" data-entity="ImageView" data-id="{$imageViews[iv].imageview_id}" data-image_id="{$imageViews[iv].image_id}" data-image_type="{$imageViews[iv].image_type}"  data-filesystem="{$imageViews[iv].filesystem}"  data-filepath="{$imageViews[iv].filepath}" data-filename="{$imageViews[iv].filename}" data-has_sd_tiles="{$imageViews[iv].has_sd_tiles}" data-pan="{$imageViews[iv].pan}" data-tilt="{$imageViews[iv].tilt}" data-fov="{$imageViews[iv].fov}">
														<img class="thumbnail enlargeFigureButton" src="{$imageViews[iv].webpath}/{$imageViews[iv].imageview_id}_100.jpg" width="100" height="100" />
														<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
													</div> 
													
												{/section}
												<div class="gallery menu edit-mode-only"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>

											{else}
												<!-- no image icon -->
												<div class="image-view-thumbnail no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="100" height="100" /></div>
												
											{/if}
												
										</td>
										<td valign="top">
											<img class="drag-icon icon32" 			src="/archmap_2/media/ui/FeatureIcon.png" 		width="25" height="25" data-entity="Feature" data-id="{$features[ff].id}" data-name="{$features[ff].name}" />
											AM.{$bldg.id}.{$features[ff].id}
											<div data-entity="Feature" data-id="{$features[ff].id}" data-field="name"     class="editable" contenteditable="false">{if $features[ff].name}{$features[ff].name}{else}name{/if}</div>
											
											
											<div>
												<img class="attributes-icon icon32 tooltip-default"  title="Show Attributes"	src="/archmap_2/media/ui/AttributesIcon.png" 	width="25" height="25" data-entity="Feature" data-id="{$features[ff].id}" data-name="{$features[ff].name}" />
										
												<div class="attributes-sheet">
													Attributes
													<hr>
													{assign var=attibutes value=$features[ff].attributes}
													
													{if $attibutes}
													
														<ul>
														{section name=aa loop=$attibutes}
														
															<li><input data-attr_id="{$attibutes[aa].attr_id}" type=checkbox {if $attibutes[aa].val == 1}checked{/if}><label>{$attibutes[aa].name}</label></li>
														{/section}
														</ul>
														{else}
													No attributes currently.
													{/if}
												</div>
											</div>
											
											<div data-entity="Feature" data-id="{$features[ff].id}" data-field="descript" class="editable" contenteditable="false">{if $features[ff].descript}{$features[ff].descript}{else} {/if}</div>
											
											<div class="item-footer">
												<!-- TAGS -->
												{assign var=tagItems value=$features[ff].tagItems}
												<div class="tag-items">Tags: 
													{section name=itag loop=$tagItems}
														<span class="tag-item">{$tagItems[itag]}</span>
													{/section}
													<span><img class="addTag new button edit-mode-only tooltip-default"  src="/media/ui/buttons/ButtonPlusNormal.png" title="Add a Tag" width=16 height=16 /></span>
												</div>
												<div class="menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
												<div> - <a href="">{$features[ff].author_name}</a>, {$features[ff].editdateString}</div>
											</div>
								
										</td>
									</tr>
								</table>
								
							</div>
						
					
					{/section}
					
				</div>
		
			{/foreach}

			</div>
			
			<div class="menu edit-mode-only">
					<button class="add-feature button">Add a Feature</button>
			</div>
		</div>
		
		

	
	</div>
	</td>
	
	<td  valign="top">
	
	<div id="main-content-right">
		<div style="min-height: 75px;">
		</div>
		
		<!--
		<img src="/archmap_2/media/samples/HagiaSophiaModel300x225.png" width="150" height="112" />
		-->

		<div style="color: gray; opacity:.6;">
		{$bldg.refnum|replace:'serdar_seals_':'no. '}
		</div>
		<div class="city-title">{$city[0]}</div>
		<div class="title">{$city[1]}</div> 
		
		
			
	<div  data-entity="{$monograph_entity}" data-id="{$bldg.id}" data-field="name" class="editable edit-mode-only" contenteditable="false" style="font-size: 32;opacity:.8">{$bldg.name}</div>
		
		
		<!--
		<div data-entity="{$monograph_entity}" data-id="{$bldg.id}" data-field="name" class="editable" contenteditable="false">
			{$bldg.name}
		</div>
		-->
		<div>
		
		
			{if $bldg.date}
				{assign var=date value=$bldg.date}
			{elseif $bldg.beg_year}
				{assign var=date value=$bldg.beg_year}
			{else}
				{assign var=date value="year"}
			{/if}
	
		ca.  <span data-entity="{$monograph_entity}" data-id="{$bldg.id}" data-field="date" class="editable" contenteditable="false" >{$date}</span>
		
		
		 
		</div>
		
			<div style="text-align:right;">
			<span id="seeAlImages" class="openImageGallery" data-entity="{$monograph_entity}" data-id="{$bldg.id}">All Images</span>
			</div>
			
			
			<!-- SLIDESHOW GALLERY -->
			{if $slideImages}
			<div class="rubric">TOUR<hr></div>
			
			
			<div class="horizontalGallery">
			
			
			{section name=sl loop=$slideImages}
			<div class="image-thumb100 enlargeFigureButton image-draggable ui-draggable" data-entity="Image" title="AM.IMG.{$slideImages[sl].id}, Rory O'Neill" data-image_type="0" data-id="{$slideImages[sl].id}" data-filesystem="{$slideImages[sl].filesystem}" data-filepath="{$slideImages[sl].filepath}" data-filename="{$slideImages[sl].filename}" data-has_sd_tiles="1" data-pan="0" data-tilt="0" data-fov="70">	
				<div class="image-bg">									
					<img src="{$slideImages[sl].url}" width="100" height="100"></div> <div style="position:absolute;left: {(100-$slideImages[sl].thumb_w)/2};top: {(100-$slideImages[sl].thumb_h)/2};z-index:10;">
					<img src="{$slideImages[sl].url}">
				</div>
			</div>
			{/section}
			
			
			
			
			</div>
			<hr>
			{/if}
			
			
					
		<!-- ALL IMAGES -->
		
		<div id="imageTray">
		
				<div class="imageuploderWidget edit-mode-only"  data-from_entity="{$monograph_entity}" data-from_id="{$bldg.id}"  >
					<span class="uploadImagesButton" >[+ Upload Images ]</span>
				</div>
		

			<div id="allImages" style="display:none;"  data-entity="{$monograph_entity}" data-id="{$bldg.id}">
	   
			</div>
			
		</div>	

		<div>
		
		
		
		
		
		
		
		
		
		
		<!-- RUBRICS -->
		<div id="rubric-list" style="margin-bottom: 35;">
			{foreach from=$rubrics key=k item=passages}
				
				{assign  var=lexicon_entry value=$passages[0].lexicon_entry}
				
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
										
										<div class="gallery menu edit-mode-only" data-entity="ImageView"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>

									</div>
									
									
									<!-- END - IMAGE GALLERY FOR THIS PASSAGE -->
									
									
									<div style="clear: left;">-</div>
								</div>
								<div class="menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
							</div>
					
					{/section}
					</div>
					
					
					
					
					
					
					
					<!-- FEATURES ASSOCIATED WITH THIS RUBRIC (if Rubric is allso a subtype of feature such as capital or lintel -->
					{if false}
					{if $featureTypes[$passages[0].lexicon_entry]}
					<div style="margin-bottom: 25;">
					Catalog of {$passages[0].name} 
					</div>
					{/if}
					<div>
					
						{section name=ff loop=$featureTypes[$passages[0].lexicon_entry]}
							{assign var=feat value=$featureTypes[ $passages[0].lexicon_entry][ff]}
							<div style="margin-bottom: 25;">
							
							<div style="font-size:10;">
							AM.{$bldg.id}.{$feat.id}
							</div>
							
							<div data-entity="Feature" data-id="{$feat.id}" data-field="name"     class="editable" contenteditable="false">{if $feat.name}{$feat.name}{else}name{/if}</div>
																
							<div data-entity="Feature" data-id="{$feat.id}" data-field="descript" class="editable" contenteditable="false">{if $feat.descript}{$feat.descript}{else} {/if}</div>
																



											{if false}
											<div class="gallery-row" >
												<hr>
											
												<!-- GALLERY -->
												{assign var=imageViews value=$feat.imageViews}
												
												{if $imageViews}
													<!-- image thumbnails -->
													{section name=iv loop=$imageViews}
														<div class="image-view-thumbnail300x deletable" data-entity="ImageView" data-id="{$imageViews[iv].imageview_id}" data-image_id="{$imageViews[iv].image_id}" data-image_type="{$imageViews[iv].image_type}"  data-name="{$imageViews[iv].name}"  data-filesystem="{$imageViews[iv].filesystem}" data-filename="{$imageViews[iv].filename}" data-has_sd_tiles="{$imageViews[iv].has_sd_tiles}" data-pan="{$imageViews[iv].pan}" data-tilt="{$imageViews[iv].tilt}" data-fov="{$imageViews[iv].fov}">
															<img class="thumbnail enlargeFigureButton" title="Rory O'Neill, April, 2012   (AM.IMG  {$imageViews[iv].image_id})" src="{$imageViews[iv].webpath}/{$imageViews[iv].imageview_id}_300.jpg" width="175" height="175" />
															<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
															<div>
															<B>Fig. {$figCount++}</B>
															</div>
														</div> 
														
													{/section}
													<div class="gallery menu edit-mode-only"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>
	
												{else}
													<!-- no image icon -->
													<div class="image-view-thumbnailx no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="175" height="175" /></div>
													
												{/if}
												
											</div>
											{/if}
					

					
							</div>
						{/section}
					</div>
					{/if}
					
				</div>
		
			{/foreach}
			<div class="rubric-list-menu edit-mode-only" >
					<button id="add-rubric">Add Rubrics</button>
			</div>
		</div>
		
		
		
		
		
		
		
		<script>
		
			// ADD RUBRIC //
			$("#add-rubric").click(function() {
				
				
				
				
				
				
				
				rubric_dialog_form = $('<div id="rubric-dialog-form" title="Create a New Rubric"><form><div></div></form></div>');
				
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Introduction" />Introduction<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Description" />Description<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Plan" />Plan<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Elevation" />Elevation<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="History" />History<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Chronology" />Chronology<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Seismic Notes" />Seismic Notes<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Lintels" />Lintels<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Windows" />Windows<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Accretion of Structure" />Accretion of Structure<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Collapses" />Collapses<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Mosaics" />Mosaics<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Frescos" />Frescos<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Paintings" />Paintings<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Portals" />Portals<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Artifacts" />Artifacts<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Sculpture" />Sculpture<br />');
				rubric_dialog_form.append('<input type="checkbox" name="rubric_chk_group[]" value="Sculpture" />Hypocaust<br />');
				
				rubric_dialog_form.append('<div> <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" /></div>');
				
				
				
			    rubric_dialog_form.dialog({
			      autoOpen: true,
			      height: 300,
			      width: 350,
			      modal: true,
			      buttons: {
						"Add Rubrics": function() {
						
							var sList = "";
							
							//ar rubric_names = new 
							
							$(this).find('input[type=checkbox]').each(function () {
							   // var sThisVal = (this.checked ? "1" : "0");
							   
							  
							   // console.log(this.checked);
							    if (this.checked) {
							    	var rubric_name = $(this).val();
							    	
							    	// 1. TRY TO FIND AN EXISTING RUBRIC
							    	var rubricBlockEl = $('div[data-rubric_name="'+rubric_name+'"]'); 
							    	
							    	// 2. IF THIS RUBRIC DOES NOT EXIST, ADD ONE								    	
							    	if (! rubricBlockEl || rubricBlockEl.length < 1) {
							    		rubricBlockEl = $('<div class="rubric-block" data-rubric_name="'+rubric_name+'"><div class="rubric  list-addable">'+rubric_name+'<hr></div></div>');
										
										// EVENTUALLY, PLACE THE RUBRIC IN THE CORRECT POSITION IN SORT ORDER,
										// BUT FOR NOW< ADD IT TO THE BOTTOM OF THE RUBRIC LIST
										$('.rubric-list-menu').before(rubricBlockEl);
									}
									
									// 3. CREATE A NEW PASSAGE
							    	var newPassageEl = 	$('<div class="passage"><div data-entity="Passage" data-field="descript" class="editable" contenteditable="true"  style="min-height: 50px;">edit</div></div>');						    	
							    	var newPassageDescript = newPassageEl.find(".editable");
									
									// 4. ADD THE PASSAGE TO THE RUBRIC
									rubricBlockEl.append(newPassageEl);
									
									
									// 5. MEANWHILE - SAVE THE NEW PASSAGE TO TEH DATABASE
									//    ASSUME THE ID WILL ARRIVE AND BE ADDED TO THE ELEMENT BEFORE THE FIRST BLUR/SAVE OCCURS	
									data = {};
									data["name"] 	= rubric_name;
										
									// 6. CHECK UP THE DOM TO SEE IF THERE IS A RELATIONSHIP (IF LIST< THEN PROBABLY)
									//    DEFINE: from_entity, fromid, and possibly, relationship
									var profileEl 	= $('.rubric-list-menu').closest( ".mono-profile" );
									if (profileEl) {
										if (profileEl.data("entity") && profileEl.data("id")) {
											data["from_entity"] = profileEl.data("entity");
											data["from_id"] 	= profileEl.data("id");
										
											var relationshipEl 	= $('.rubric-list-menu').closest( "[data-relationship]" );											
											if (relationshipEl) {
												var relationship = relationshipEl.data("relationship");
												if (relationship) {
													data["relationship"] = relationship;
												}
											}
										}
									} 
									
									// 7. SAVE THE RECORD AND USE RESPONSE TO SET ID IN DOM ELEMENT
									addRecord("Passage", data, function(json_data) {
											// add the id to the passage div data...
											newPassageDescript.attr("data-id", json_data['id']);
											setEditable(newPassageDescript, true);
										});
							    }
							});
							$( this ).dialog( "close" );
						},
						Cancel: function() {
						  $( this ).dialog( "close" );
						}
			       }			
			   });				
				
			});
			
			$( document ).ready(function() 
			{

				//getOldImagePlotsForImageid
				
				
				
					
				
				
				
			});
			
		</script>



		
		{if $site.id == 152 && $bldg.id == 106300}
		{literal}
		<div class="content" style="z-index:20000;">
			<div id="unityPlayer">
				<div class="missing">
					<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!">
						<img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
					</a>
				</div>
				<div class="broken">
					<a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now! Restart your browser after install.">
						<img alt="Unity Web Player. Install now! Restart your browser after install." src="http://webplayer.unity3d.com/installation/getunityrestart.png" width="193" height="63" />
					</a>
				</div>
			</div>
		</div>
		{/literal}
		{/if}
		
	



		<!-- BIBLIOGRAPHY -->
		<div style="margin-bottom: 40;">

			<div class="rubric list-addable"  data-entity="Publication">Bibliography<hr></div>
			
		
			<div class="item-list" data-entity="Publication">
		
				<div class="edit-mode-only" style="margin-bottom:10;">
					<div>
						<button class="addItemToCollectionButton" data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication">Add a Publication</button>
						<button class="addItemFromZoteroButton" data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication">Import from Zotero</button>
					</div>
				</div>
	
				
				<div class="biblio-import-widget edit-mode-only"></div>
			
				
				<dl class="items scrollable">
					{section name=p loop=$publications}
						{assign var=pub value=$publications[p]}
					
						<dt class="list-item entity-profile  deletable biblio-record" data-entity="Publication" data-id="{$pub.id}" data-from_entity="Building" data-from_id="{$bldg.id}"      data-id="{$pub.id}">
							<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>
							
							<span class="biblio-link">{include file="PubStyle_ArtHistory.tpl"}</span>{if $pub.pages},{/if} <span data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication" data-to_id="{$pub.id}" data-fieldname="pages" class="editable" contenteditable="false" >{$pub.pages}</span>
							
						</dt>
					
					{/section}
				</dl>	
				
			</div>
				
		</div>



		<!--
		<div class="image-categories">
			<div class="image-category">
				<h3>FRESCOES</h3>
			</div>
			<div class="image-category">
				<h3>MOSAICS</h3>
			</div>
			<div class="image-category">
				<h3>ARTIFACTS</h3>
			</div>
		</div>
		-->
	
	</div>
	</td>
	</tr>
	</table>
	
	<div id="allImagesDialog" class="scrollable" style="display:none;" data-entity="{$monograph_entity}" data-id="{$bldg.id}">

	</div>
	
</div>	
	
	