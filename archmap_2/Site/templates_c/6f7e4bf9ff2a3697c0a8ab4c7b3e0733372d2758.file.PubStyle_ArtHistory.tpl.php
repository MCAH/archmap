<?php /* Smarty version Smarty-3.1.14, created on 2014-05-09 20:32:51
         compiled from "./templates/PubStyle_ArtHistory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12947737385315fcfbe0a8a6-02058112%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f7e4bf9ff2a3697c0a8ab4c7b3e0733372d2758' => 
    array (
      0 => './templates/PubStyle_ArtHistory.tpl',
      1 => 1399681968,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12947737385315fcfbe0a8a6-02058112',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5315fcfbe13f54_74182260',
  'variables' => 
  array (
    'pub' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5315fcfbe13f54_74182260')) {function content_5315fcfbe13f54_74182260($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/home/mgf/archmap_2/Smarty/libs/plugins/modifier.replace.php';
?><?php if ($_smarty_tpl->tpl_vars['pub']->value['type']=="book"){?>
<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['pub']->value['authors'],';',', ');?>
, <span class="book biblio-title" ><?php echo $_smarty_tpl->tpl_vars['pub']->value['name'];?>
</span>, <?php echo $_smarty_tpl->tpl_vars['pub']->value['location'];?>
, (<span class="pub-date"><?php echo $_smarty_tpl->tpl_vars['pub']->value['date'];?>
</span>)<?php }elseif($_smarty_tpl->tpl_vars['pub']->value['type']=="thesis"){?>
<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['pub']->value['authors'],';',', ');?>
, <span class="book biblio-title" ><?php echo $_smarty_tpl->tpl_vars['pub']->value['name'];?>
</span>, <?php echo $_smarty_tpl->tpl_vars['pub']->value['location'];?>
, (<span class="pub-date"><?php echo $_smarty_tpl->tpl_vars['pub']->value['date'];?>
</span>)
<?php }elseif($_smarty_tpl->tpl_vars['pub']->value['type']=="chapter"||$_smarty_tpl->tpl_vars['pub']->value['type']=="paper-conference"){?>
<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['pub']->value['authors'],';',', ');?>
, "<span class="article biblio-title"><?php echo $_smarty_tpl->tpl_vars['pub']->value['name'];?>
</span>" in <span class="book biblio-title" ><?php echo $_smarty_tpl->tpl_vars['pub']->value['container_title'];?>
</span>, (<span class="pub-date"><?php echo $_smarty_tpl->tpl_vars['pub']->value['date'];?>
</span>), <?php echo $_smarty_tpl->tpl_vars['pub']->value['jpages'];?>

<?php }elseif($_smarty_tpl->tpl_vars['pub']->value['type']=="article-journal"){?>
<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['pub']->value['authors'],';',', ');?>
, "<span class="article biblio-title"><?php echo $_smarty_tpl->tpl_vars['pub']->value['name'];?>
</span>",  <span class="book biblio-title" ><?php echo $_smarty_tpl->tpl_vars['pub']->value['container_title'];?>
</span>, (<span class="pub-date"><?php echo $_smarty_tpl->tpl_vars['pub']->value['date'];?>
</span>), <?php echo $_smarty_tpl->tpl_vars['pub']->value['jpages'];?>

<?php if (strpos($_smarty_tpl->tpl_vars['pub']->value['url'],"jstor")){?><a href="<?php echo $_smarty_tpl->tpl_vars['pub']->value['url'];?>
" target="_blank">[@jstor]</a><?php }?>
<?php if (strpos($_smarty_tpl->tpl_vars['pub']->value['url'],"sciencedirect")){?><a href="<?php echo $_smarty_tpl->tpl_vars['pub']->value['url'];?>
" target="_blank">[@sciencedirect]</a><?php }?>
<?php }?><?php }} ?>