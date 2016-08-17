<?php /* Smarty version Smarty-3.1.14, created on 2014-02-02 17:28:35
         compiled from "Site/templates/BuildingCard.tpl" */ ?>
<?php /*%%SmartyHeaderCode:79289367452e7efe805cd64-64041171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '745c86e6e56b11468905113d889eaafe8f0d8dfc' => 
    array (
      0 => 'Site/templates/BuildingCard.tpl',
      1 => 1391380059,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '79289367452e7efe805cd64-64041171',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52e7efe80abcd3_36988059',
  'variables' => 
  array (
    'collection' => 1,
    'building' => 1,
    'image' => 1,
    'isize' => 1,
    'posterUrl100' => 1,
    'w' => 1,
    'h' => 1,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52e7efe80abcd3_36988059')) {function content_52e7efe80abcd3_36988059($_smarty_tpl) {?>
<div class="building-card">
	<h2><a href="/archmap_2/Site/Collection?collection=<?php echo $_smarty_tpl->tpl_vars['collection']->value;?>
&building_id=<?php echo $_smarty_tpl->tpl_vars['building']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['building']->value['name'];?>
</a></h2>
	

		<table>
			<tr>
				<td width=200 style="background-color:#ddd">
<?php if ($_smarty_tpl->tpl_vars['building']->value['lat']){?>
	<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $_smarty_tpl->tpl_vars['building']->value['lat'];?>
,<?php echo $_smarty_tpl->tpl_vars['building']->value['lng'];?>
&zoom=3&size=210x100&maptype=terrain
&markers=color:red%7Clabel:S%7C<?php echo $_smarty_tpl->tpl_vars['building']->value['lat'];?>
,<?php echo $_smarty_tpl->tpl_vars['building']->value['lng'];?>
&sensor=false&key=AIzaSyDzJ5COaHF8BYgs-CNi-Jr1r49nysl385I" />
				<?php }?>
				</td>

				<td width=100>
					<?php if ($_smarty_tpl->tpl_vars['building']->value['lat']){?>
	<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $_smarty_tpl->tpl_vars['building']->value['lat'];?>
,<?php echo $_smarty_tpl->tpl_vars['building']->value['lng'];?>
&zoom=16&size=100x100&maptype=satellite
&markers=color:red%7Clabel:S%7C<?php echo $_smarty_tpl->tpl_vars['building']->value['lat'];?>
,<?php echo $_smarty_tpl->tpl_vars['building']->value['lng'];?>
&sensor=false&key=AIzaSyDzJ5COaHF8BYgs-CNi-Jr1r49nysl385I" />
				
				<?php }?>
				</td>

				<td>
	
							<?php if (isset($_smarty_tpl->tpl_vars['image']->value)){?>
								<?php $_smarty_tpl->tpl_vars['isize'] = new Smarty_variable(100, true, 0);?>
								
								
								<div style="border: solid 1 #ddd;width: <?php echo $_smarty_tpl->tpl_vars['isize']->value;?>
; height: <?php echo $_smarty_tpl->tpl_vars['isize']->value;?>
; position: relative;">
									
									<?php if ($_smarty_tpl->tpl_vars['image']->value['image_type']!="cubic"&&$_smarty_tpl->tpl_vars['image']->value['image_type']!="node"){?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['posterUrl100']->value;?>
" class="image-bg" style="opacity: .3;" width=100 height=100 />
									
										<?php if ($_smarty_tpl->tpl_vars['image']->value['width']>$_smarty_tpl->tpl_vars['image']->value['height']){?>
											<?php $_smarty_tpl->tpl_vars['w'] = new Smarty_variable($_smarty_tpl->tpl_vars['isize']->value, true, 0);?>
											<?php $_smarty_tpl->tpl_vars['h'] = new Smarty_variable($_smarty_tpl->tpl_vars['w']->value*($_smarty_tpl->tpl_vars['image']->value['height']/$_smarty_tpl->tpl_vars['image']->value['width']), true, 0);?>
										<?php }else{ ?>
											<?php $_smarty_tpl->tpl_vars['h'] = new Smarty_variable($_smarty_tpl->tpl_vars['isize']->value, true, 0);?>
											<?php $_smarty_tpl->tpl_vars['w'] = new Smarty_variable($_smarty_tpl->tpl_vars['h']->value*($_smarty_tpl->tpl_vars['image']->value['width']/$_smarty_tpl->tpl_vars['image']->value['height']), true, 0);?>
										<?php }?>
										<!-- OVERLAY -->
										<div  class=" enlargeFigureButton" data-entity="Image" data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-filesystem="<?php echo $_smarty_tpl->tpl_vars['image']->value['filesystem'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['image']->value['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['image']->value['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['image']->value['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['image']->value['fov'];?>
">	
											<div style="position:absolute;left: <?php echo ($_smarty_tpl->tpl_vars['isize']->value-$_smarty_tpl->tpl_vars['w']->value)/2;?>
;top: <?php echo ($_smarty_tpl->tpl_vars['isize']->value-$_smarty_tpl->tpl_vars['h']->value)/2;?>
;z-index:10;">
												<img src="<?php echo $_smarty_tpl->tpl_vars['posterUrl100']->value;?>
" width="<?php echo $_smarty_tpl->tpl_vars['w']->value;?>
" height="<?php echo $_smarty_tpl->tpl_vars['h']->value;?>
" />
											</div>
										</div>
	
									<?php }else{ ?>
										<img src="<?php echo $_smarty_tpl->tpl_vars['posterUrl100']->value;?>
" width=100 height=100 />
									
									<?php }?>
									
									
									
										
								</div>	
								
							<?php }else{ ?>
							
								<img src="<?php echo $_smarty_tpl->tpl_vars['posterUrl100']->value;?>
"  width=100 height=100 />
						
								
							<?php }?>				
				</td>
								
			</tr>
		</table>
		
</div>	
								
	
	
	
	
	
	
	
<?php }} ?>