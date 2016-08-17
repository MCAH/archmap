<?php /* Smarty version Smarty-3.1.14, created on 2014-10-01 17:59:17
         compiled from "./templates/Publication.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9960241615254b7d870b583-41747108%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2665bb3366560e575c20108333129afdf6bc5d76' => 
    array (
      0 => './templates/Publication.tpl',
      1 => 1412200753,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9960241615254b7d870b583-41747108',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5254b7d871a142_48258260',
  'variables' => 
  array (
    'buildings_json' => 0,
    'itemCount' => 0,
    'pub' => 0,
    'buildings' => 0,
    'bldg' => 0,
    'iconURL' => 0,
    'city' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5254b7d871a142_48258260')) {function content_5254b7d871a142_48258260($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script>
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
			Register of <?php echo $_smarty_tpl->tpl_vars['itemCount']->value;?>
 Monuments in 
			<div><b><?php echo $_smarty_tpl->tpl_vars['pub']->value['name'];?>
</b></div>
			<hr>
			<div class="edit-mode-only" style="margin-bottom:10;">
				<button class="addItemToCollectionButton" data-from_entity="Publication" data-from_id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-to_entity="Building">Add a Building</button>
			</div>

			<dl class="items scrollable">
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
					<?php $_smarty_tpl->tpl_vars['bldg'] = new Smarty_variable($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']], null, 0);?>
					<?php $_smarty_tpl->tpl_vars['city'] = new Smarty_variable(explode(", ",$_smarty_tpl->tpl_vars['bldg']->value['name']), null, 0);?>
					
					<dt class="list-item item_name droppable-listitem" data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-from_entity="Publication" data-from_id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
">
						<button class="edit-mode-only remove-list-item-button" title="Remove item from this list."><span style="font-size:10;">-</span></button>
						
						<?php $_smarty_tpl->tpl_vars['iconURL'] = new Smarty_variable("/archmap_2/media/ui/CircleIcon.png", null, 0);?>
						<?php if ($_smarty_tpl->tpl_vars['buildings']->value[$_smarty_tpl->getVariable('smarty')->value['section']['ii']['index']]['lat']!=''){?>
						  <?php $_smarty_tpl->tpl_vars['iconURL'] = new Smarty_variable("http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png", null, 0);?>
						<?php }?>
						
						<img class="drag-icon" style="opacity: .7;" 	src="<?php echo $_smarty_tpl->tpl_vars['iconURL']->value;?>
" 		width="16" height="16"  data-entity="Building" data-id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['name'];?>
" />
						
						
						
						<a href="/archmap_2/Site/Collection.php?building_id=<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['city']->value[0];?>
, <?php echo $_smarty_tpl->tpl_vars['city']->value[1];?>
</a>
						<div data-from_entity="Building" data-from_id="<?php echo $_smarty_tpl->tpl_vars['bldg']->value['id'];?>
" data-to_entity="Publication" data-to_id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-fieldname="pages" class="editable" contenteditable="false" ><?php echo $_smarty_tpl->tpl_vars['bldg']->value['pages'];?>
</div>
					</dt>
					
				<?php endfor; endif; ?>	
			</dl>
			<hr>
		</div>
	</div>	
	

<div id="main-content">





	<div id="left-cover">
	
		<img src="http://covers.openlibrary.org/b/ISBN/<?php echo $_smarty_tpl->tpl_vars['pub']->value['ISBN_ISSN'];?>
-L.jpg" />
		<br>
		<span style="font-size:8;">Cover art courtesy of <a href="http://openlibrary.org/isbn/<?php echo $_smarty_tpl->tpl_vars['pub']->value['ISBN_ISSN'];?>
" style="font-size:8;">Open Library</a></span>
	
	</div>
	
		<!-- TITLE (NAME) -->
		<div  data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-field="name" class="title editable" contenteditable="false" style="font-size: 32;opacity:.8"><?php echo stripslashes($_smarty_tpl->tpl_vars['pub']->value['name']);?>
</div>

	<div>
		<!-- DATE, CONTRIBUTORS, PUBLISHER, LOCATION -->
		<b>
		<span  data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-field="date" class="editable" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['pub']->value['date'];?>
</span>, 
		<span  data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-field="contributors" class="editable" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['pub']->value['contributors'];?>
</span>
		</b>,  
		<span  data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-field="publisher" class="editable" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['pub']->value['publisher'];?>
</span>,  
		<span  data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-field="location" class="editable" contenteditable="false"><?php echo $_smarty_tpl->tpl_vars['pub']->value['location'];?>
</span>
	</div>
	
	<br>
	<br>
	<br>
	
			
		<!-- ALL IMAGES -->
		
		<div id="imageTray" >
		
			Images...
			<div class="imageuploderWidget edit-mode-only"  data-from_entity="Publication" data-from_id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-relationship="source" >
				<span class="uploadImagesButton" >[+ Upload Images ]</span>
			</div>
	
			<div class="allImagesImmediate"  data-entity="Publication" data-id="<?php echo $_smarty_tpl->tpl_vars['pub']->value['id'];?>
" data-relationship="source" style="height: 500;overflow-y:scroll;">
	  
			</div>
	
		
		
		</div>	

	
</div>
<?php }} ?>