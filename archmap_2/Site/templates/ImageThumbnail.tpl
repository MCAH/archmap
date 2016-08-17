								eee
								{if $image}
							
								<div style="border: solid 2 gray;width: {$size}; height: {$size}; position: relative">
									
								
									{if $image.width>$image.height}
										{assign var=w value=$size}
										{assign var=h value=$w*($image.height/$image.width)}
									{else}
										{assign var=h value=$size}
										{assign var=w value=$h*($image.width/$image.height)}
									{/if}
									
									
									<!-- OVERLAY -->
									<div  class=" enlargeFigureButton" data-entity="Image" data-image_type="{$image.image_type}" data-id="{$image.id}" data-filesystem="{$image.filesystem}"  data-filename="{$image.filename}" data-has_sd_tiles="{$image.has_sd_tiles}" data-pan="{$image.pan}" data-tilt="{$image.tilt}" data-fov="{$image.fov}">	
										<div style="position:absolute;left: {($size-$w)/2};top: {($size-$h)/2};z-index:10;"><img src="{$poster_url100}" width="{$w}" height="{$h}" />
									</div>
									
									
									<!-- PLOTS -->
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
