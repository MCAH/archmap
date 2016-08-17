{include file="header.tpl"}

	
		<script type="text/javascript">
		<!--
		
			{if $site.id eq 242}
				{assign var=unityfile value="Famagusta"}
				{assign var=uhgt value="275"}
				{assign var=uwid value="275"}
			{/if}
			{if $site.id eq 152}
				{assign var=unityfile value="Amiens"}
				{assign var=uhgt value="500"}
				{assign var=uwid value="500"}
			{/if}
		
			var params = {
				disableContextMenu: false,
				disableExternalCall: false,
				disableFullscreen: false,
				enableDebugging:"0"
			};
			var config = {
				width: 275, 
				height: 275,
				params: params
				
			};
			var u = new UnityObject2(config);


			
			
			jQuery(function() {
			
	

				var $missingScreen = jQuery("#unityPlayer").find(".missing");
				var $brokenScreen = jQuery("#unityPlayer").find(".broken");
				$missingScreen.hide();
				$brokenScreen.hide();
				
				u.observeProgress(function (progress) {
					switch(progress.pluginStatus) {
						case "broken":
							$brokenScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$brokenScreen.show();
						break;
						case "missing":
							$missingScreen.find("a").click(function (e) {
								e.stopPropagation();
								e.preventDefault();
								u.installPlugin();
								return false;
							});
							$missingScreen.show();
						break;
						case "installed":
							$missingScreen.remove();
						break;
						case "first":
						break;
					}
				});
				u.initPlugin(jQuery("#unityPlayer")[0], "/archmap_2/unity/{$unityfile}.unity3d");
			});
		-->
		</script>	
	
	
	

	<script>
		var site;
		
		{if $site_json}
			site = {$site_json};
		{/if}
		
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
		
		{if $selectedBuilding_json}
			
			selectedBuilding = {$selectedBuilding_json};
			logit("HAVE SELECTED BUILDING JSAON *********************** "+selectedBuilding.name);
		{/if} 
		
			
				if (  ("{$urlalias}" == "mesopotamia"  || "{$site.id}" == "233")  && ! thisUser.isLoggedIn)
				{
					window.location = "http://archmap.org?note=mesopotamia";
				}
				if ($_GET("note") == "mesopotamia") {
					alert("Please login to access Mapping Mesopotamian Monuments");
					raiseLogin();
				}
		
		
		
		
		
	
	</script>
	
	<!-- MAP UNDERLAY -->
	<div id="map-canvas">
	
	</div>
	
	<div id="map-cover"> </div>
	<div id="map-cover-sidebar"> </div>
	
	
	
		
		
	<div id="sidebar">
	
		
		
	
		<div class="resource-list item-list" >
			Register of {$itemCount} Monuments in 
			<div><b>{$site.name}</b></div>
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<div>
					<button class="addItemToCollectionButton" data-from_entity="Essay" data-from_id="{$site.id}" data-to_entity="Building">Add a Building</button>
				</div>
			</div>
			
			
			<dl  class="items monument-list scrollable">
				{assign var=cc value=1}
				{section name=ii loop=$alpha_buildings}
					{assign var=bldg value=$alpha_buildings[ii]}
					
					{assign var=city value=", "|explode:$alpha_buildings[ii].name}
					<dt class="list-item droppable-listitem" data-site="{$site.id}"  data-entity="Building" data-id="{$bldg.id}" data-relationship="depiction" data-from_entity="Essay" data-from_id="{$site.id}" data-to_entity="Building" data-to_id="{$alpha_buildings[ii].id}">
						<div class=".list-item-tip" title="click me">
						<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>
						
						{assign var=iconURL value="/archmap_2/media/ui/CircleIcon.png"}
						{if $alpha_buildings[ii].lat != ""}
						  {assign var=iconURL value="http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png"}
						{/if}
						
						 <img class="drag-icon" style="opacity: .7;" 	src="{$iconURL}" 		width="16" height="16"  data-entity="Building" data-id="{$bldg.id}" data-name="{$bldg.name}" />
						 {$cc++}.
						<a class="item_name monument-link" href="">{$city[0]}, {$city[1]}</a>
						<div>
					</dt>
					
				{/section}	
			</dl>
			<hr>

		</div>
		
		
		<div class="item-list">
			Other Collections this Monument is Included In 
			
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<button class="addItemToCollectionButton" data-from_entity="Building" data-from_id="{$monograph.id}" data-to_entity="Essay">Add to a Collection</button>
			</div>

			<dl id="items" class="scrollable">
				{section name=cc loop=$collections}
					{assign var=collection value=$collections[cc]}
					
					<dt class="list-item" data-entity="Essay" data-id="{$collection.id}" data-from_entity="Building" data-from_id="{$monograph.id}">
						<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>

						<a href="?site={$collections[cc].id}&building_id={$monograph.id}">{$collection.name}</a>
					</dt>
					
				{/section}	
			</dl>
			<hr>
		</div>
		
		
		
		
		
		
		
		
		{if $site.id == 242_33}
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
		
		
	</div>	
		
		
		
	<div id="main-content-bg" style="background-image: url('{$selectedBuilding.poster_url300|replace:'300':'700'}');">--</div>
	<div id="main-content" >
	
		<div id="closeContent" data-urlalias="{$site.urlalias}">
			<img    src="/archmap_2/media/ui/close.png" width="25" height="25" />
		</div>

		<div id="wysiwyg-text-edit-menu">
			<button  id="addFootnoteButton" class="addFootnoteButton 	edit-show" hidden>Add Footnote</button>
			<button  id="addFigureButton" 	class="addFigureButton 	edit-show " hidden>Add Figure</button>
			<button  id="addCitationButton" class="citationButton 	edit-show" hidden>Add Citation</button>
		</div>
		
	

	
		<!-- MONOGRAPH -->
		{if  isset($monograph)}
		
				
						{assign var=bldg value=$monograph}
						{assign var=city value=", "|explode:$bldg.name}
						
						
						{include file="BuildingMonograph.tpl"}
						
			
			
			
		<!-- NODE CONTENT -->
		{else}
	  
						<div class="monograph_text">
								<div class="mono-info">
									<h3 id="mono_name" data-entity="Essay" data-id="{$site.id}" data-field="name" class="editable" contenteditable="false">{$site.name}</h3>
									
									<hr>
									
									<div id="thedescript" data-entity="Essay" data-id="{$site.id}" data-field="descript" class="editable" contenteditable="false">
										{$site.descript}
									</div>
								
											
								</div>
						</div>
	
	
	
						<!-- pinterest cards -->
						
						{section name=ii loop=$buildings}
							{assign var=city value=", "|explode:$buildings[ii].name}
							{assign var=bldg value=$buildings[ii]}
							<div class="monograph-thumb grid"> 
								
								{assign var=hgt value=(250*{$bldg.poster.height}/{$bldg.poster.width})}
								{assign var=hgt value=250}
								
								<div class="picture link " data-building_id="{$bldg.id}" data-image_type="{$bldg.poster.image_type}"  data-filename="{$bldg.poster.filename}" data-id="{$bldg.poster.id}">
										<div class="poster-view fieldname-poster_id ">
											<div class="picture-frame" >
													<div class="imageAreaGrid">				
															<img src="{$bldg.poster_url300}" width="250" height="{$hgt}"  />
															
															<!--	
															<img src="{$buildings[ii].latsec_url}" width="{$bldg.plan.width/10}" height="{$bldg.plan.height/10}" />
															-->
													</div>
												
												
													<div class="picture-title">{$city[1]}</div>
													<div class="picture-city">{$city[0]}</div>
											</div>
											<div class="picture-frame-shadow" style="width:240px;"></div>
										</div>	
								</div>	
								
							</div>
							
						{/section}	
						
				
			{/if}
	
					
	
	</div>				


	{include file="footer.tpl"}
	
		
	


	