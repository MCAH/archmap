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
		
		//var selectedBuilding;

</script>

<style>
	#left-cover {
		float: left;
		min-height: 100;
		margin-right:20;
		margin-bottom:20;
	}
</style>


	
	<!-- MAP UNDERLAY -->
	<div id="map-canvas">
	
	</div>
	
	<div id="map-cover"> </div>
	<div id="map-cover-sidebar"> </div>

	
	<div id="sidebar">
		<div class="resource-list item-list">
			Register of {$itemCount} Monuments in 
			<div><b>{$pub.name}</b></div>
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<button class="addItemToCollectionButton" data-from_entity="Publication" data-from_id="{$pub.id}" data-to_entity="Building">Add a Building</button>
			</div>

			<dl class="items scrollable">
				{section name=ii loop=$buildings}
					{assign var=bldg value=$buildings[ii]}
					{assign var=city value=", "|explode:$bldg.name}
					
					<dt class="list-item item_name droppable-listitem" data-entity="Building" data-id="{$bldg.id}" data-from_entity="Publication" data-from_id="{$pub.id}">
						<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>
						
						{assign var=iconURL value="/archmap_2/media/ui/CircleIcon.png"}
						{if $buildings[ii].lat != ""}
						  {assign var=iconURL value="http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png"}
						{/if}
						
						<img class="drag-icon" style="opacity: .7;" 	src="{$iconURL}" 		width="16" height="16"  data-entity="Building" data-id="{$bldg.id}" data-name="{$bldg.name}" />
						
						
						
						<a href="/archmap_2/Site/Collection.php?building_id={$bldg.id}">{$city[0]}, {$city[1]}</a>
						<div data-from_entity="Building" data-from_id="{$bldg.id}" data-to_entity="Publication" data-to_id="{$pub.id}" data-fieldname="pages" class="editable" contenteditable="false" >{$bldg.pages}</div>
					</dt>
					
				{/section}	
			</dl>
			<hr>
		</div>
	</div>	
	

<div id="main-content">





	<div id="left-cover">
	
		<img src="http://covers.openlibrary.org/b/ISBN/{$pub.ISBN_ISSN}-L.jpg" />
		<br>
		<span style="font-size:8;">Cover art courtesy of <a href="http://openlibrary.org/isbn/{$pub.ISBN_ISSN}" style="font-size:8;">Open Library</a></span>
	
	</div>
	
		<!-- TITLE (NAME) -->
		<div  data-entity="Publication" data-id="{$pub.id}" data-field="name" class="title editable" contenteditable="false" style="font-size: 32;opacity:.8">{$pub.name|stripslashes}</div>

	<div>
		<!-- DATE, CONTRIBUTORS, PUBLISHER, LOCATION -->
		<b>
		<span  data-entity="Publication" data-id="{$pub.id}" data-field="date" class="editable" contenteditable="false">{$pub.date}</span>, 
		<span  data-entity="Publication" data-id="{$pub.id}" data-field="contributors" class="editable" contenteditable="false">{$pub.contributors}</span>
		</b>,  
		<span  data-entity="Publication" data-id="{$pub.id}" data-field="publisher" class="editable" contenteditable="false">{$pub.publisher}</span>,  
		<span  data-entity="Publication" data-id="{$pub.id}" data-field="location" class="editable" contenteditable="false">{$pub.location}</span>
	</div>
	
	<br>
	<br>
	<br>
	
			
		<!-- ALL IMAGES -->
		
		<div id="imageTray" >
		
			Images...
			<div class="imageuploderWidget edit-mode-only"  data-from_entity="Publication" data-from_id="{$pub.id}" data-relationship="source" >
				<span class="uploadImagesButton" >[+ Upload Images ]</span>
			</div>
	
			<div class="allImagesImmediate"  data-entity="Publication" data-id="{$pub.id}" data-relationship="source" style="height: 500;overflow-y:scroll;">
	  
			</div>
	
		
		
		</div>	

	
</div>
