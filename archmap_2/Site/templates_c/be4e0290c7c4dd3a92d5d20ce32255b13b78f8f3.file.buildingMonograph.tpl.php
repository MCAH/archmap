<?php /* Smarty version Smarty-3.1.14, created on 2013-10-01 22:46:29
         compiled from "./templates/buildingMonograph.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12036473875249cdb6a13507-82590371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be4e0290c7c4dd3a92d5d20ce32255b13b78f8f3' => 
    array (
      0 => './templates/buildingMonograph.tpl',
      1 => 1380681986,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12036473875249cdb6a13507-82590371',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5249cdb6a20043_04241061',
  'variables' => 
  array (
    'bldg' => 0,
    'image' => 0,
    'city' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5249cdb6a20043_04241061')) {function content_5249cdb6a20043_04241061($_smarty_tpl) {?>	
	<div id="main-content-left">


		<!-- POSTER -->
		<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['poster'], null, 0);?>
		
		<div class="picture immediate" data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
">
			<div class="poster-view fieldname-poster_id ">
				<div class="picture-frame" style="width: 300; height: 320;">
					<div class="imageArea">
					<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster_url300'];?>
" width="300" height="300"  />
					</div>
					
					<div class="picture-title"><?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>
</div>
					
				</div>
				<div class="picture-frame-shadow" style="width:240px;"></div>
			</div>	
		</div>	


		<!-- PLAN -->
		<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['plan'], null, 0);?>
		
		<div class="picture immediate" data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
">
			<div class="poster-view fieldname-poster_id ">
				<div class="picture-frame" style="width: 300; height: 340;">
					<div class="imageArea">
					<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan_url300'];?>
" width="300" height="300"  />
					</div>
				</div>
				<div class="picture-frame-shadow" style="width:240px;"></div>
			</div>	
		</div>	




	
	</div>
	
	<div id="main-content-right">
	
		<img src="/archmap_2/media/samples/HagiaSophiaModel300x225.png" width="150" height="112" />
		<div class="city-title"><?php echo $_smarty_tpl->tpl_vars['city']->value[0];?>
</div>
		<div class="title"><?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</div>
		
		<div><?php echo $_smarty_tpl->tpl_vars['bldg']->value['descript'];?>
</div>
		
		
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
		
		<div id="imageTray">
			<div id="allImagesButton">All Images</div>
			<hr>
			<div id="allImages" data-building_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">
	   
			</div>
			<hr>
			</div>	
	
	</div>
	
	
	
	
	<?php }} ?>