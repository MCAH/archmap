<?php /* Smarty version Smarty-3.1.14, created on 2014-11-14 14:06:12
         compiled from "./templates/Collection.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9597113735246dc9e2fc975-63783479%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb88ca1efd8186d4b347dbb32b412a90af04eb52' => 
    array (
      0 => './templates/Collection.tpl',
      1 => 1415991967,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9597113735246dc9e2fc975-63783479',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5246dc9e53f058_48064491',
  'variables' => 
  array (
    'site' => 1,
    'unityfile' => 1,
    'site_json' => 0,
    'buildings_json' => 0,
    'selectedBuilding_json' => 0,
    'urlalias' => 0,
    'itemCount' => 0,
    'alpha_buildings' => 0,
    'bldg' => 0,
    'iconURL' => 0,
    'cc' => 0,
    'city' => 0,
    'monograph' => 0,
    'collections' => 0,
    'collection' => 0,
    'selectedBuilding' => 0,
    'buildings' => 0,
    'hgt' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5246dc9e53f058_48064491')) {function content_5246dc9e53f058_48064491($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/mgf/archmap_2/Smarty/libs/plugins/modifier.replace.php';
?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	
		<script type="text/javascript">
		<!--
		
			<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==242){?>
				<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Famagusta", true, 0);?>
				<?php $_smarty_tpl->tpl_vars['uhgt'] = new Smarty_variable("275", true, 0);?>
				<?php $_smarty_tpl->tpl_vars['uwid'] = new Smarty_variable("275", true, 0);?>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['site']->value['id']==152){?>
				<?php $_smarty_tpl->tpl_vars['unityfile'] = new Smarty_variable("Amiens", true, 0);?>
				<?php $_smarty_tpl->tpl_vars['uhgt'] = new Smarty_variable("500", true, 0);?>
				<?php $_smarty_tpl->tpl_vars['uwid'] = new Smarty_variable("500", true, 0);?>
			<?php }?>
		
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
				u.initPlugin(jQuery("#unityPlayer")[0], "/archmap_2/unity/<?php echo $_smarty_tpl->tpl_vars['unityfile']->value;?>
.unity3d");
			});
		-->
		</script>	
	
	
	

	<script>
		var site;
		
		<?php if ($_smarty_tpl->tpl_vars['site_json']->value){?>
			site = <?php echo $_smarty_tpl->tpl_vars['site_json']->value;?>
;
		<?php }?>
		
		var bldgs;
		
		logit("buildings data inline");
		<?php if ($_smarty_tpl->tpl_vars['buildings_json']->value){?>  
			bldgs = <?php echo $_smarty_tpl->tpl_vars['buildings_json']->value;?>
;
		<?php }else{ ?> Description 
			bldgs = "";
		<?php }?>
		
		//alert (bldgs);
		var map;
		
		
		var selectedBuilding;
		
		<?php if ($_smarty_tpl->tpl_vars['selectedBuilding_json']->value){?>
			
			selectedBuilding = <?php echo $_smarty_tpl->tpl_vars['selectedBuilding_json']->value;?>
;
			logit("HAVE SELECTED BUILDING JSAON *********************** "+selectedBuilding.name);
		<?php }?> 
		
			
				if (  ("<?php echo $_smarty_tpl->tpl_vars['urlalias']->value;?>
" == "mesopotamia"  || "<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" == "233")  && ! thisUser.isLoggedIn)
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
			Register of <?php echo $_smarty_tpl->tpl_vars['itemCount']->value;?>
 Monuments in 
			<div><b><?php echo $_smarty_tpl->tpl_vars['site']->value['name'];?>
</b></div>
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<div>
					<button class="addItemToCollectionButton" data-from_entity="Essay" data-from_id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-to_entity="Building">Add a Building</button>
				</div>
			</div>
			
			
			<dl  class="items monument-list scrollable">
				<?php $_smarty_tpl->tpl_vars['cc'] = new Smarty_variable(1, null, 0);?>
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['alpha_buildings']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total']);
?>
					<?php $_smarty_tpl->tpl_vars['bldg'] = new Smarty_variable($_smarty_tpl->tpl_vars['alpha_buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']], null, 0);?>
					
					<?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable(explode(", ",$_smarty_tpl->tpl_vars['alpha_buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['name']), null, 0);?>
					<dt class="list-item droppable-listitem" data-site="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
"  data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-relationship="depiction" data-from_entity="Essay" data-from_id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-to_entity="Building" data-to_id="<?php echo $_smarty_tpl->tpl_vars['alpha_buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['id'];?>
">
						<div class=".list-item-tip" title="click me">
						<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>
						
						<?php $_smarty_tpl->tpl_vars['iconURL'] = new Smarty_variable("/archmap_2/media/ui/CircleIcon.png", null, 0);?>
						<?php if ($_smarty_tpl->tpl_vars['alpha_buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['lat']!=''){?>
						  <?php $_smarty_tpl->tpl_vars['iconURL'] = new Smarty_variable("http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png", null, 0);?>
						<?php }?>
						
						 <img class="drag-icon" style="opacity: .7;" 	src="<?php echo $_smarty_tpl->tpl_vars['iconURL']->value;?>
" 		width="16" height="16"  data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
" />
						 <?php echo $_smarty_tpl->tpl_vars['cc']->value++;?>
.
						<a class="item_name monument-link" href=""><?php echo $_smarty_tpl->tpl_vars['city']->value[0];?>
, <?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</a>
						<div>
					</dt>
					
				<?php endfor; endif; ?>	
			</dl>
			<hr>

		</div>
		
		
		<div class="item-list">
			Other Collections this Monument is Included In 
			
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<button class="addItemToCollectionButton" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['monograph']->value['id'];?>
" data-to_entity="Essay">Add to a Collection</button>
			</div>

			<dl id="items" class="scrollable">
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['cc'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['name'] = 'cc';
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['collections']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['cc']['total']);
?>
					<?php $_smarty_tpl->tpl_vars['collection'] = new Smarty_variable($_smarty_tpl->tpl_vars['collections']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cc']['index']], null, 0);?>
					
					<dt class="list-item" data-entity="Essay" data-id="<?php echo $_smarty_tpl->tpl_vars['collection']->value['id'];?>
" data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['monograph']->value['id'];?>
">
						<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>

						<a href="?site=<?php echo $_smarty_tpl->tpl_vars['collections']->value[$_smarty_tpl->getVariable('smarty')->value['section']['cc']['index']]['id'];?>
&building_id=<?php echo $_smarty_tpl->tpl_vars['monograph']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['collection']->value['name'];?>
</a>
					</dt>
					
				<?php endfor; endif; ?>	
			</dl>
			<hr>
		</div>
		
		
		
		
		
		
		
		
		<?php if ($_smarty_tpl->tpl_vars['site']->value['id']=='242_33'){?>
		
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
		
		
	</div>	
		
		
		
	<div id="main-content-bg" style="background-image: url('<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['selectedBuilding']->value['poster_url300'],'300','700');?>
');">--</div>
	<div id="main-content" >
	
		<div id="closeContent" data-urlalias="<?php echo $_smarty_tpl->tpl_vars['site']->value['urlalias'];?>
">
			<img    src="/archmap_2/media/ui/close.png" width="25" height="25" />
		</div>

		<div id="wysiwyg-text-edit-menu">
			<button  id="addFootnoteButton" class="addFootnoteButton 	edit-show" hidden>Add Footnote</button>
			<button  id="addFigureButton" 	class="addFigureButton 	edit-show " hidden>Add Figure</button>
			<button  id="addCitationButton" class="citationButton 	edit-show" hidden>Add Citation</button>
		</div>
		
	

	
		<!-- MONOGRAPH -->
		<?php if (isset($_smarty_tpl->tpl_vars['monograph']->value)){?>
		
				
						<?php $_smarty_tpl->tpl_vars['bldg'] = new Smarty_variable($_smarty_tpl->tpl_vars['monograph']->value, null, 0);?>
						<?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable(explode(", ",$_smarty_tpl->tpl_vars['bldg']->value['name']), null, 0);?>
						
						
						<?php echo $_smarty_tpl->getSubTemplate ("BuildingMonograph.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

						
			
			
			
		<!-- NODE CONTENT -->
		<?php }else{ ?>
	  
						<div class="monograph_text">
								<div class="mono-info">
									<h3 id="mono_name" data-entity="Essay" data-id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-field="name" class="editable" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['site']->value['name'];?>
</h3>
									
									<hr>
									
									<div id="thedescript" data-entity="Essay" data-id="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" data-field="descript" class="editable" contenteditable="false">
										<?php echo $_smarty_tpl->tpl_vars['site']->value['descript'];?>

									</div>
								
											
								</div>
						</div>
	
	
	
						<!-- pinterest cards -->
						
						<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['name'] = 'ii';
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['buildings']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['ii']['total']);
?>
							<?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable(explode(", ",$_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['name']), null, 0);?>
							<?php $_smarty_tpl->tpl_vars['bldg'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']], null, 0);?>
							<div class="monograph-thumb grid"> 
								
								<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['height'];?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['width'];?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['hgt'] = new Smarty_variable((250*$_tmp1/$_tmp2), null, 0);?>
								<?php $_smarty_tpl->tpl_vars['hgt'] = new Smarty_variable(250, null, 0);?>
								
								<div class="picture link " data-building_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-image_type="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['image_type'];?>
"  data-filename="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['filename'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster']['id'];?>
">
										<div class="poster-view fieldname-poster_id ">
											<div class="picture-frame" >
													<div class="imageAreaGrid">				
															<img src="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['poster_url300'];?>
" width="250" height="<?php echo $_smarty_tpl->tpl_vars['hgt']->value;?>
"  />
															
															<!--	
															<img src="<?php echo $_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['latsec_url'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['width']/10;?>
" height="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['plan']['height']/10;?>
" />
															-->
													</div>
												
												
													<div class="picture-title"><?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</div>
													<div class="picture-city"><?php echo $_smarty_tpl->tpl_vars['city']->value[0];?>
</div>
											</div>
											<div class="picture-frame-shadow" style="width:240px;"></div>
										</div>	
								</div>	
								
							</div>
							
						<?php endfor; endif; ?>	
						
				
			<?php }?>
	
					
	
	</div>				


	<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
		
	


	<?php }} ?>