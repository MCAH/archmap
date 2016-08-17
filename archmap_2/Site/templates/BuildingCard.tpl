
<div class="building-card">
	<h2><a href="/archmap_2/Site/Collection?collection={$collection}&building_id={$building.id}">{$building.name}</a></h2>
	

		<table>
			<tr>
				<td width=200 style="background-color:#ddd">
{if $building.lat}
	<img src="http://maps.googleapis.com/maps/api/staticmap?center={$building.lat},{$building.lng}&zoom=3&size=210x100&maptype=terrain
&markers=color:red%7Clabel:S%7C{$building.lat},{$building.lng}&sensor=false&key=AIzaSyDzJ5COaHF8BYgs-CNi-Jr1r49nysl385I" />
				{/if}
				</td>

				<td width=100>
					{if $building.lat}
	<img src="http://maps.googleapis.com/maps/api/staticmap?center={$building.lat},{$building.lng}&zoom=16&size=100x100&maptype=satellite
&markers=color:red%7Clabel:S%7C{$building.lat},{$building.lng}&sensor=false&key=AIzaSyDzJ5COaHF8BYgs-CNi-Jr1r49nysl385I" />
				
				{/if}
				</td>

				<td>
	
							{if isset($image)}
								{assign var=isize value=100}
								
								
								<div style="border: solid 1 #ddd;width: {$isize}; height: {$isize}; position: relative;">
									
									{if $image.image_type != "cubic" && $image.image_type != "node"}
										<img src="{$posterUrl100}" class="image-bg" style="opacity: .3;" width=100 height=100 />
									
										{if $image.width>$image.height}
											{assign var=w value=$isize}
											{assign var=h value=$w*($image.height/$image.width)}
										{else}
											{assign var=h value=$isize}
											{assign var=w value=$h*($image.width/$image.height)}
										{/if}
										<!-- OVERLAY -->
										<div  class=" enlargeFigureButton" data-entity="Image" data-image_type="{$image.image_type}" data-id="{$image.id}" data-filesystem="{$image.filesystem}"  data-filename="{$image.filename}" data-has_sd_tiles="{$image.has_sd_tiles}" data-pan="{$image.pan}" data-tilt="{$image.tilt}" data-fov="{$image.fov}">	
											<div style="position:absolute;left: {($isize-$w)/2};top: {($isize-$h)/2};z-index:10;">
												<img src="{$posterUrl100}" width="{$w}" height="{$h}" />
											</div>
										</div>
	
									{else}
										<img src="{$posterUrl100}" width=100 height=100 />
									
									{/if}
									
									
									
										
								</div>	
								
							{else}
							
								<img src="{$posterUrl100}"  width=100 height=100 />
						
								
							{/if}				
				</td>
								
			</tr>
		</table>
		
</div>	
								
	
	
	
	
	
	
	
