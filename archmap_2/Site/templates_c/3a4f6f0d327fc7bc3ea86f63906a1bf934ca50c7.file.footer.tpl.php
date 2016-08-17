<?php /* Smarty version Smarty-3.1.14, created on 2015-06-22 13:54:06
         compiled from "./templates/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:53144776523cfedaea7b61-87499279%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a4f6f0d327fc7bc3ea86f63906a1bf934ca50c7' => 
    array (
      0 => './templates/footer.tpl',
      1 => 1434995643,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '53144776523cfedaea7b61-87499279',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523cfedaea9e82_57029830',
  'variables' => 
  array (
    'urlalias' => 0,
    'site' => 1,
    'author' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523cfedaea9e82_57029830')) {function content_523cfedaea9e82_57029830($_smarty_tpl) {?>			
			<div id="footer" class="footer">
            
				<center>
					
					"<a href="/<?php echo $_smarty_tpl->tpl_vars['urlalias']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['site']->value['name'];?>
</a>", developed by <a href="/author/<?php echo $_smarty_tpl->tpl_vars['author']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['author']->value['honorific'];?>
 <?php echo $_smarty_tpl->tpl_vars['author']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['author']->value['lastname'];?>
</a>, is a node of 
					 <a href="http://archmap.org"><b>The Archmap Project</b></a>, a communal knowledge system for the humanities created with the generous support of the <a href="http://www.mellon.org">Andrew W. Mellon Foundation</a> and in collaboration with <a href="http://learn.columbia.edu" ">The Media Center for Art History</a>, <a href="http://columbia.edu" ">Columbia University</a>
					
				
				</center>
			</div>
			
				

	</body>
	
		
	
</html>
<?php }} ?>