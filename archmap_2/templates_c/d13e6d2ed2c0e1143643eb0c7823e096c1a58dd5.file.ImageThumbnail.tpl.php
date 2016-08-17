<?php /* Smarty version Smarty-3.1.14, created on 2014-01-28 13:41:25
         compiled from "Site/templates/ImageThumbnail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:92967378452e7f97922da95-68949456%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd13e6d2ed2c0e1143643eb0c7823e096c1a58dd5' => 
    array (
      0 => 'Site/templates/ImageThumbnail.tpl',
      1 => 1390934477,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '92967378452e7f97922da95-68949456',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52e7f97947bae2_18080665',
  'variables' => 
  array (
    'image' => 1,
    'size' => 1,
    'w' => 1,
    'h' => 1,
    'poster_url100' => 1,
    'buildings' => 1,
    'plots' => 1,
    'features' => 1,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52e7f97947bae2_18080665')) {function content_52e7f97947bae2_18080665($_smarty_tpl) {?>								eee
								<?php if ($_smarty_tpl->tpl_vars['image']->value){?>
							
								<div style="border: solid 2 gray;width: <?php echo $_smarty_tpl->tpl_vars['size']->value;?>
; height: <?php echo $_smarty_tpl->tpl_vars['size']->value;?>
; position: relative">
									
								
									<?php if ($_smarty_tpl->tpl_vars['image']->value['width']>$_smarty_tpl->tpl_vars['image']->value['height']){?>
										<?php $_smarty_tpl->tpl_vars['w'] = new Smarty_variable($_smarty_tpl->tpl_vars['size']->value, true, 0);?>
										<?php $_smarty_tpl->tpl_vars['h'] = new Smarty_variable($_smarty_tpl->tpl_vars['w']->value*($_smarty_tpl->tpl_vars['image']->value['height']/$_smarty_tpl->tpl_vars['image']->value['width']), true, 0);?>
									<?php }else{ ?>
										<?php $_smarty_tpl->tpl_vars['h'] = new Smarty_variable($_smarty_tpl->tpl_vars['size']->value, true, 0);?>
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
										<div style="position:absolute;left: <?php echo ($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['w']->value)/2;?>
;top: <?php echo ($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['h']->value)/2;?>
;z-index:10;"><img src="<?php echo $_smarty_tpl->tpl_vars['poster_url100']->value;?>
" width="<?php echo $_smarty_tpl->tpl_vars['w']->value;?>
" height="<?php echo $_smarty_tpl->tpl_vars['h']->value;?>
" />
									</div>
									
									
									<!-- PLOTS -->
									<?php $_smarty_tpl->tpl_vars['plots'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['planPlots'], true, 0);?>
									<?php if ($_smarty_tpl->tpl_vars['plots']->value){?>
									<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['name'] = 'pp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['plots']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['total']);
?>
										<div style="position:absolute;left: <?php echo $_smarty_tpl->tpl_vars['plots']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['pos_x']*$_smarty_tpl->tpl_vars['size']->value+($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['w']->value)/2-15;?>
;top: <?php echo $_smarty_tpl->tpl_vars['plots']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['pos_y']*$_smarty_tpl->tpl_vars['size']->value+($_smarty_tpl->tpl_vars['size']->value-$_smarty_tpl->tpl_vars['h']->value)/2-15;?>
;z-index:15;">
											<img class="drag-icon icon32" 			src="/archmap_2/media/ui/FeatureIcon.png" 		width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
										</div>
									<?php endfor; endif; ?>
									<?php }?>
										
								</div>	
								
								<?php }?>				
<?php }} ?>