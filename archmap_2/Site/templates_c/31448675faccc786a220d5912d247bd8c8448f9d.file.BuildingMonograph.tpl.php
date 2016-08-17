<?php /* Smarty version Smarty-3.1.14, created on 2014-12-11 15:55:52
         compiled from "./templates/BuildingMonograph.tpl" */ ?>
<?php /*%%SmartyHeaderCode:826315157524c13ada5e956-80973851%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '31448675faccc786a220d5912d247bd8c8448f9d' => 
    array (
      0 => './templates/BuildingMonograph.tpl',
      1 => 1418331349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '826315157524c13ada5e956-80973851',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_524c13adb04452_42613850',
  'variables' => 
  array (
    'monograph_entity' => 0,
    'bldg' => 0,
    'image' => 0,
    'hgt' => 0,
    'featuresets' => 0,
    'features' => 0,
    'site' => 1,
    'subtype' => 0,
    'k' => 0,
    'imageViews' => 0,
    'attibutes' => 0,
    'tagItems' => 0,
    'city' => 0,
    'date' => 0,
    'slideImages' => 0,
    'rubrics' => 0,
    'passages' => 0,
    'featureTypes' => 0,
    'feat' => 0,
    'figCount' => 0,
    'publications' => 0,
    'pub' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524c13adb04452_42613850')) {function content_524c13adb04452_42613850($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/mgf/archmap_2/Smarty/libs/plugins/modifier.replace.php';
?><div class="mono-profile entity-profile" data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">

	<table width="100%">
	<tr>
	<td width="30%" valign="top">
	<div id="main-content-left"  style="position: relative">
		

		<!-- MAIN POSTER -->
		<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['poster'], null, 0);?>
			
		<?php if ($_smarty_tpl->tpl_vars['bldg']->value['poster_url300']=="/archmap_2/media/ui/NoImage.jpg"){?>
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
		<?php }else{ ?>
			<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['image']->value['height'];?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['image']->value['width'];?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['hgt'] = new Smarty_variable((300*$_tmp1/$_tmp2), null, 0);?>
			<?php $_smarty_tpl->tpl_vars['hgt'] = new Smarty_variable(300, null, 0);?>
			<div class="picture immediate image-droppable" style="position: relative"	data-fieldname="poster_id"	data-entity="Image" 	data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" 	data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
" 		data-filesystem="<?php echo $_smarty_tpl->tpl_vars['image']->value['filesystem'];?>
" data-filepath="<?php echo $_smarty_tpl->tpl_vars['image']->value['filepath'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
"  data-image_id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['image']->value['has_sd_tiles'];?>
"  	data-pan="<?php echo $_smarty_tpl->tpl_vars['image']->value['pan'];?>
"  data-tilt="<?php echo $_smarty_tpl->tpl_vars['image']->value['tilt'];?>
"  data-fov="<?php echo $_smarty_tpl->tpl_vars['image']->value['fov'];?>
">
				
				<div class="poster-view fieldname-poster_id">
					<div class="picture-frame  " style="width: 300; height: <?php echo $_smarty_tpl->tpl_vars['hgt']->value;?>
;">
						<div id="image-viewer-<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" class="imageArea imageViewer" style="width: 300;height: <?php echo $_smarty_tpl->tpl_vars['hgt']->value;?>
;">
							<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster_url300'];?>
" width="300" height="<?php echo $_smarty_tpl->tpl_vars['hgt']->value;?>
"  />
						</div>
						<div class="picture-title editable" data-entity="Image" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-field="name" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['image']->value['title'];?>
</div>
					</div>
					<div class="picture-frame-shadow" style="width:340px;"></div>
				</div>	
				
				
				
				<div class="edit-mode-only"  style="position: absolute; left:25; top:3">
					<button class="set-view">Set View</button>
				</div>

			</div>	
		<?php }?>


		<!-- PLAN -->
		<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['planImage'], null, 0);?>
		<div class="picture immediate image-droppable" style="position: relative"	data-fieldname="plan_image_id"	data-entity="Image" 	data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" 	data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
" 		data-filesystem="<?php echo $_smarty_tpl->tpl_vars['image']->value['filesystem'];?>
" data-filepath="<?php echo $_smarty_tpl->tpl_vars['image']->value['filepath'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
"  data-image_id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['image']->value['has_sd_tiles'];?>
"  	data-pan="<?php echo $_smarty_tpl->tpl_vars['image']->value['pan'];?>
"  data-tilt="<?php echo $_smarty_tpl->tpl_vars['image']->value['tilt'];?>
"  data-fov="<?php echo $_smarty_tpl->tpl_vars['image']->value['fov'];?>
">
			<div class="poster-view fieldname-poster_id">
				<div class="picture-frame  " style="width: 300; height: 300;">
					<div id="image-viewer-<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" class="imageArea imageViewer" style="width: 300;height: 300;">
						<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan_url300'];?>
" width="300" height="300"  />
					</div>
					<div class="picture-title editable" data-entity="Image" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-field="name" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>
</div>
				</div>
				<div class="picture-frame-shadow" style="width:340px;"></div>
			</div>
			
						
			<div class="edit-mode-only"  style="position: absolute; left:25; top:3">
				<button class="set-view">Set View</button>
			</div>
	
		</div>	

		


		<!-- SECTION -->
		<?php $_smarty_tpl->tpl_vars['image'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['latsecImage'], null, 0);?>
		<div class="picture immediate image-droppable" style="position: relative"	data-fieldname="lat_section_image_id"	data-entity="Image" 	data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" 	data-image_type="<?php echo $_smarty_tpl->tpl_vars['image']->value['image_type'];?>
" 		data-filesystem="<?php echo $_smarty_tpl->tpl_vars['image']->value['filesystem'];?>
" data-filepath="<?php echo $_smarty_tpl->tpl_vars['image']->value['filepath'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['image']->value['filename'];?>
"  data-image_id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['image']->value['has_sd_tiles'];?>
"  	data-pan="<?php echo $_smarty_tpl->tpl_vars['image']->value['pan'];?>
"  data-tilt="<?php echo $_smarty_tpl->tpl_vars['image']->value['tilt'];?>
"  data-fov="<?php echo $_smarty_tpl->tpl_vars['image']->value['fov'];?>
">
			<div class="poster-view fieldname-poster_id">
				<div class="picture-frame  " style="width: 300; height: 300;">
					<div id="image-viewer-<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" class="imageArea imageViewer" style="width: 300;height: 300;">
						<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['latsec_url300'];?>
" width="300" height="300"  />
					</div>
					<div class="picture-title editable" data-entity="Image" data-id="<?php echo $_smarty_tpl->tpl_vars['image']->value['id'];?>
" data-field="name" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['image']->value['name'];?>
</div>
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
			
			<?php  $_smarty_tpl->tpl_vars['features'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['features']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['featuresets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['features']->key => $_smarty_tpl->tpl_vars['features']->value){
$_smarty_tpl->tpl_vars['features']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['features']->key;
?>
				<div class="feature-block list-block" data-entity="Feature" data-subtype="<?php echo $_smarty_tpl->tpl_vars['features']->value[0]['subtype'];?>
">
					<?php $_smarty_tpl->tpl_vars['subtype'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[0]['subtype'], null, 0);?>

					
					<div class="list-block-label"><b><a href="Catalog?site=<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
&type=<?php echo $_smarty_tpl->tpl_vars['subtype']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</a></b><hr></div>
					
					
					<img class="addButton new button" title="Add an item to this list" src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 />
					
					
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['name'] = 'ff';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['features']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total']);
?>
						
							<div class="entity-profile feature deletable" data-entity="Feature"  data-subtype="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['subtype'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
">
								
								<table width="100%">
									<tr>
										<td valign="top" width="110px" class="item-gallery" data-entity="ImageView">
											
											
											<!-- GALLERY -->
											<?php $_smarty_tpl->tpl_vars['imageViews'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['imageViews'], null, 0);?>
											
											<?php if ($_smarty_tpl->tpl_vars['imageViews']->value){?>
												<!-- image thumbnails -->
												<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['name'] = 'iv';
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['imageViews']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total']);
?>
													<div class="image-view-thumbnail deletable" data-entity="ImageView" data-id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
" data-image_id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_type'];?>
"  data-filesystem="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filesystem'];?>
"  data-filepath="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filepath'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['fov'];?>
">
														<img class="thumbnail enlargeFigureButton" src="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['webpath'];?>
/<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
_100.jpg" width="100" height="100" />
														<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
													</div> 
													
												<?php endfor; endif; ?>
												<div class="gallery menu edit-mode-only"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>

											<?php }else{ ?>
												<!-- no image icon -->
												<div class="image-view-thumbnail no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="100" height="100" /></div>
												
											<?php }?>
												
										</td>
										<td valign="top">
											<img class="drag-icon icon32" 			src="/archmap_2/media/ui/FeatureIcon.png" 		width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
											AM.<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>

											<div data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-field="name"     class="editable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name']){?><?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
<?php }else{ ?>name<?php }?></div>
											
											
											<div>
												<img class="attributes-icon icon32 tooltip-default"  title="Show Attributes"	src="/archmap_2/media/ui/AttributesIcon.png" 	width="25" height="25" data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['name'];?>
" />
										
												<div class="attributes-sheet">
													Attributes
													<hr>
													<?php $_smarty_tpl->tpl_vars['attibutes'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['attributes'], null, 0);?>
													
													<?php if ($_smarty_tpl->tpl_vars['attibutes']->value){?>
													
														<ul>
														<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['aa'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['name'] = 'aa';
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['attibutes']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['aa']['total']);
?>
														
															<li><input data-attr_id="<?php echo $_smarty_tpl->tpl_vars['attibutes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['aa']['index']]['attr_id'];?>
" type=checkbox <?php if ($_smarty_tpl->tpl_vars['attibutes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['aa']['index']]['val']==1){?>checked<?php }?>><label><?php echo $_smarty_tpl->tpl_vars['attibutes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['aa']['index']]['name'];?>
</label></li>
														<?php endfor; endif; ?>
														</ul>
														<?php }else{ ?>
													No attributes currently.
													<?php }?>
												</div>
											</div>
											
											<div data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['id'];?>
" data-field="descript" class="editable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['descript']){?><?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['descript'];?>
<?php }else{ ?> <?php }?></div>
											
											<div class="item-footer">
												<!-- TAGS -->
												<?php $_smarty_tpl->tpl_vars['tagItems'] = new Smarty_variable($_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['tagItems'], null, 0);?>
												<div class="tag-items">Tags: 
													<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['itag'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['name'] = 'itag';
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['tagItems']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['itag']['total']);
?>
														<span class="tag-item"><?php echo $_smarty_tpl->tpl_vars['tagItems']->value[$_smarty_tpl->getVariable('smarty')->value['section']['itag']['index']];?>
</span>
													<?php endfor; endif; ?>
													<span><img class="addTag new button edit-mode-only tooltip-default"  src="/media/ui/buttons/ButtonPlusNormal.png" title="Add a Tag" width=16 height=16 /></span>
												</div>
												<div class="menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
												<div> - <a href=""><?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['author_name'];?>
</a>, <?php echo $_smarty_tpl->tpl_vars['features']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']]['editdateString'];?>
</div>
											</div>
								
										</td>
									</tr>
								</table>
								
							</div>
						
					
					<?php endfor; endif; ?>
					
				</div>
		
			<?php } ?>

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
		<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['bldg']->value['refnum'],'serdar_seals_','no. ');?>

		</div>
		<div class="city-title"><?php echo $_smarty_tpl->tpl_vars['city']->value[0];?>
</div>
		<div class="title"><?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</div> 
		
		
			
	<div  data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-field="name" class="editable edit-mode-only" contenteditable="false" style="font-size: 32;opacity:.8"><?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
</div>
		
		
		<!--
		<div data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-field="name" class="editable" contenteditable="false">
			<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>

		</div>
		-->
		<div>
		
		
			<?php if ($_smarty_tpl->tpl_vars['bldg']->value['date']){?>
				<?php $_smarty_tpl->tpl_vars['date'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['date'], null, 0);?>
			<?php }elseif($_smarty_tpl->tpl_vars['bldg']->value['beg_year']){?>
				<?php $_smarty_tpl->tpl_vars['date'] = new Smarty_variable($_smarty_tpl->tpl_vars['bldg']->value['beg_year'], null, 0);?>
			<?php }else{ ?>
				<?php $_smarty_tpl->tpl_vars['date'] = new Smarty_variable("year", null, 0);?>
			<?php }?>
	
		ca.  <span data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-field="date" class="editable" contenteditable="false" ><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</span>
		
		
		 
		</div>
		
			<div style="text-align:right;">
			<span id="seeAlImages" class="openImageGallery" data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">All Images</span>
			</div>
			
			
			<!-- SLIDESHOW GALLERY -->
			<?php if ($_smarty_tpl->tpl_vars['slideImages']->value){?>
			<div class="rubric">TOUR<hr></div>
			
			
			<div class="horizontalGallery">
			
			
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['sl'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['name'] = 'sl';
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['slideImages']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['sl']['total']);
?>
			<div class="image-thumb100 enlargeFigureButton image-draggable ui-draggable" data-entity="Image" title="AM.IMG.<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['id'];?>
, Rory O'Neill" data-image_type="0" data-id="<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['id'];?>
" data-filesystem="<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['filesystem'];?>
" data-filepath="<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['filepath'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['filename'];?>
" data-has_sd_tiles="1" data-pan="0" data-tilt="0" data-fov="70">	
				<div class="image-bg">									
					<img src="<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['url'];?>
" width="100" height="100"></div> <div style="position:absolute;left: <?php echo (100-$_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['thumb_w'])/2;?>
;top: <?php echo (100-$_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['thumb_h'])/2;?>
;z-index:10;">
					<img src="<?php echo $_smarty_tpl->tpl_vars['slideImages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['sl']['index']]['url'];?>
">
				</div>
			</div>
			<?php endfor; endif; ?>
			
			
			
			
			</div>
			<hr>
			<?php }?>
			
			
					
		<!-- ALL IMAGES -->
		
		<div id="imageTray">
		
				<div class="imageuploderWidget edit-mode-only"  data-from_entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
"  >
					<span class="uploadImagesButton" >[+ Upload Images ]</span>
				</div>
		

			<div id="allImages" style="display:none;"  data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">
	   
			</div>
			
		</div>	

		<div>
		
		
		
		
		
		
		
		
		
		
		<!-- RUBRICS -->
		<div id="rubric-list" style="margin-bottom: 35;">
			<?php  $_smarty_tpl->tpl_vars['passages'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['passages']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rubrics']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['passages']->key => $_smarty_tpl->tpl_vars['passages']->value){
$_smarty_tpl->tpl_vars['passages']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['passages']->key;
?>
				
				<?php $_smarty_tpl->tpl_vars['lexicon_entry'] = new Smarty_variable($_smarty_tpl->tpl_vars['passages']->value[0]['lexicon_entry'], null, 0);?>
				
				<div class="rubric-block" data-rubric_name="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
				
					<div class="rubric list-addable"  data-entity="Passage"><?php echo $_smarty_tpl->tpl_vars['passages']->value[0]['name'];?>
<hr></div>
					
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pp']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['name'] = 'pp';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pp']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['passages']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
						
							<div class="passage deletable" style="margin:bottom:20;" data-entity="Passage" data-id="<?php echo $_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['id'];?>
" <?php if (!$_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['descript']){?>style="display:none;"<?php }?>>
								
								<!-- TEXT OF PASSAGE -->
								<div data-entity="Passage" data-id="<?php echo $_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['id'];?>
" data-field="descript" class="editable text-figure-droppable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['descript']){?><?php echo $_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['descript'];?>
<?php }else{ ?>edit<?php }?></div>
								
								<div class="passage-footer">
								
								
									<div> - <a href=""><?php echo $_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['author_name'];?>
</a>, <?php echo $_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['editdateString'];?>
</div>
									
									
									<!-- BEG - IMAGE GALLERY FOR THIS PASSAGE -->
									
									<div class="item-gallery">
										<?php $_smarty_tpl->tpl_vars['imageViews'] = new Smarty_variable($_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['imageViews'], null, 0);?>
										<?php if ($_smarty_tpl->tpl_vars['passages']->value[$_smarty_tpl->getVariable('smarty')->value['section']['pp']['index']]['imageViews']){?>
										Gallery
										<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['name'] = 'iv';
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['imageViews']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total']);
?>
											<div class="image-view-thumbnail drag-icon deletable" data-entity="ImageView" data-id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
" data-image_id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_type'];?>
"  data-name="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['name'];?>
"  data-filesystem="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filesystem'];?>
"  data-filepath="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filepath'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['fov'];?>
">
														<img class="thumbnail enlargeFigureButton" src="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['webpath'];?>
/<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
_100.jpg" width="100" height="100" />
														<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
											</div> 
										<?php endfor; endif; ?>
										<?php }?>
										
										<div class="gallery menu edit-mode-only" data-entity="ImageView"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>

									</div>
									
									
									<!-- END - IMAGE GALLERY FOR THIS PASSAGE -->
									
									
									<div style="clear: left;">-</div>
								</div>
								<div class="menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
							</div>
					
					<?php endfor; endif; ?>
					</div>
					
					
					
					
					
					
					
					<!-- FEATURES ASSOCIATED WITH THIS RUBRIC (if Rubric is allso a subtype of feature such as capital or lintel -->
					<?php if (false){?>
					<?php if ($_smarty_tpl->tpl_vars['featureTypes']->value[$_smarty_tpl->tpl_vars['passages']->value[0]['lexicon_entry']]){?>
					<div style="margin-bottom: 25;">
					Catalog of <?php echo $_smarty_tpl->tpl_vars['passages']->value[0]['name'];?>
 
					</div>
					<?php }?>
					<div>
					
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['name'] = 'ff';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['featureTypes']->value[$_smarty_tpl->tpl_vars['passages']->value[0]['lexicon_entry']]) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ff']['total']);
?>
							<?php $_smarty_tpl->tpl_vars['feat'] = new Smarty_variable($_smarty_tpl->tpl_vars['featureTypes']->value[$_smarty_tpl->tpl_vars['passages']->value[0]['lexicon_entry']][$_smarty_tpl->getVariable('smarty')->value['section']['ff']['index']], null, 0);?>
							<div style="margin-bottom: 25;">
							
							<div style="font-size:10;">
							AM.<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['feat']->value['id'];?>

							</div>
							
							<div data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['feat']->value['id'];?>
" data-field="name"     class="editable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['feat']->value['name']){?><?php echo $_smarty_tpl->tpl_vars['feat']->value['name'];?>
<?php }else{ ?>name<?php }?></div>
																
							<div data-entity="Feature" data-id="<?php echo $_smarty_tpl->tpl_vars['feat']->value['id'];?>
" data-field="descript" class="editable" contenteditable="false"><?php if ($_smarty_tpl->tpl_vars['feat']->value['descript']){?><?php echo $_smarty_tpl->tpl_vars['feat']->value['descript'];?>
<?php }else{ ?> <?php }?></div>
																



											<?php if (false){?>
											<div class="gallery-row" >
												<hr>
											
												<!-- GALLERY -->
												<?php $_smarty_tpl->tpl_vars['imageViews'] = new Smarty_variable($_smarty_tpl->tpl_vars['feat']->value['imageViews'], null, 0);?>
												
												<?php if ($_smarty_tpl->tpl_vars['imageViews']->value){?>
													<!-- image thumbnails -->
													<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['name'] = 'iv';
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['imageViews']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['iv']['total']);
?>
														<div class="image-view-thumbnail300x deletable" data-entity="ImageView" data-id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
" data-image_id="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_type'];?>
"  data-name="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['name'];?>
"  data-filesystem="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filesystem'];?>
" data-filename="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['filename'];?>
" data-has_sd_tiles="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['has_sd_tiles'];?>
" data-pan="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['pan'];?>
" data-tilt="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['tilt'];?>
" data-fov="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['fov'];?>
">
															<img class="thumbnail enlargeFigureButton" title="Rory O'Neill, April, 2012   (AM.IMG  <?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['image_id'];?>
)" src="<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['webpath'];?>
/<?php echo $_smarty_tpl->tpl_vars['imageViews']->value[$_smarty_tpl->getVariable('smarty')->value['section']['iv']['index']]['imageview_id'];?>
_300.jpg" width="175" height="175" />
															<div class="image menu edit-mode-only"><img class="minusButton delete button" src="/media/ui/buttons/ButtonMinusNormal.png" width=16 height=16 /></div>
															<div>
															<B>Fig. <?php echo $_smarty_tpl->tpl_vars['figCount']->value++;?>
</B>
															</div>
														</div> 
														
													<?php endfor; endif; ?>
													<div class="gallery menu edit-mode-only"><img class="addFigureButton  new button"  src="/media/ui/buttons/ButtonPlusNormal.png" width=16 height=16 /></div>
	
												<?php }else{ ?>
													<!-- no image icon -->
													<div class="image-view-thumbnailx no-image"><img class="addFigureButton" src="/archmap_2/media/ui/NoImage.jpg" width="175" height="175" /></div>
													
												<?php }?>
												
											</div>
											<?php }?>
					

					
							</div>
						<?php endfor; endif; ?>
					</div>
					<?php }?>
					
				</div>
		
			<?php } ?>
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



		
		<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==152&&$_smarty_tpl->tpl_vars['bldg']->value['id']==106300){?>
		
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
		
		<?php }?>
		
	



		<!-- BIBLIOGRAPHY -->
		<div style="margin-bottom: 40;">

			<div class="rubric list-addable"  data-entity="Publication">Bibliography<hr></div>
			
		
			<div class="item-list" data-entity="Publication">
		
				<div class="edit-mode-only" style="margin-bottom:10;">
					<div>
						<button class="addItemToCollectionButton" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication">Add a Publication</button>
						<button class="addItemFromZoteroButton" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication">Import from Zotero</button>
					</div>
				</div>
	
				
				<div class="biblio-import-widget edit-mode-only"></div>
			
				
				<dl class="items scrollable">
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['p'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['p']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['name'] = 'p';
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['publications']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['p']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['p']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['p']['total']);
?>
						<?php $_smarty_tpl->tpl_vars['pub'] = new Smarty_variable($_smarty_tpl->tpl_vars['publications']->value[$_smarty_tpl->getVariable('smarty')->value['section']['p']['index']], null, 0);?>
					
						<dt class="list-item entity-profile  deletable biblio-record" data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
"      data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
">
							<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>
							
							<span class="biblio-link"><?php echo $_smarty_tpl->getSubTemplate ("PubStyle_ArtHistory.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</span><?php if ($_smarty_tpl->tpl_vars['pub']->value['pages']){?>,<?php }?> <span data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication" data-to_id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-fieldname="pages" class="editable" contenteditable="false" ><?php echo $_smarty_tpl->tpl_vars['pub']->value['pages'];?>
</span>
							
						</dt>
					
					<?php endfor; endif; ?>
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
	
	<div id="allImagesDialog" class="scrollable" style="display:none;" data-entity="<?php echo $_smarty_tpl->tpl_vars['monograph_entity']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
">

	</div>
	
</div>	
	
	<?php }} ?>