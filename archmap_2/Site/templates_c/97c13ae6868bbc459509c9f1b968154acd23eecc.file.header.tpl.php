<?php /* Smarty version Smarty-3.1.14, created on 2015-06-22 13:56:11
         compiled from "./templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1101735942523cfedae52650-54976650%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97c13ae6868bbc459509c9f1b968154acd23eecc' => 
    array (
      0 => './templates/header.tpl',
      1 => 1434995768,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1101735942523cfedae52650-54976650',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523cfedae65ec8_92523829',
  'variables' => 
  array (
    'pageTitle' => 0,
    'site' => 1,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523cfedae65ec8_92523829')) {function content_523cfedae65ec8_92523829($_smarty_tpl) {?><html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
		
		<link rel="stylesheet" type="text/css" href="/archmap_2/css/dropzone.css"/>
		<link type="text/css" href="/archmap_2/css/ui-lightness/jquery-ui-1.8.12.custom.css" rel="Stylesheet" />	
		<link rel="stylesheet" type="text/css" href="/archmap_2/css/archmap3.css"/>

		
        
	</head>
	<body>
	
	
	
	<script type="text/javascript" src="/archmap_2/js/jquery-1.10.2.min.js"></script> 
	<script type="text/javascript" src="/archmap_2/js/jquery-ui-1.10.2.min.js"></script>

	<script type="text/javascript" src="/archmap_2/js/seadragon-min.js"></script>
	
	<!-- LOCAL STORAGE -->
	<script type="text/javascript" src="/archmap_2/js/jsper.js"></script>
	

	<!-- MAPS -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	
	
	 <!-- UNITY -->
	 
	 <script src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject2.js"></script>
	 
	 
	 <!-- ARCHMAP -->
	<script type="text/javascript" src="/archmap_2/js/AM_Utilities.js"></script>
	<script type="text/javascript" src="/archmap_2/js/archmap.3.1.js"></script>
	<script type="text/javascript" src="/archmap_2/js/archmapPubs-1.0.js"></script>
	<script type="text/javascript" src="/archmap_2/js/AM_Maps.js"></script>
	


	<!-- DROPZONE fileupload -->
	<script type="text/javascript"  src="/archmap_2/js/dropzone.js">
	</script>
	
	
	<!-- vector graphics -->
	
	

	<!-- PANO_2_VR_PLAYER -->
	<script type="text/javascript"  src="/archmap_2/js/pano2vr_player_beautifued.js">
	</script>
	
	<script>
		if ($_GET("login_email") != "") {
			raiseLogin($_GET("login_email"));
		}
	</script>
	
	<div id="header">
	
		<table width="100%">
		<tr>
		<td>
			<div style="color: white;" id="site-name"><a href="/<?php echo $_smarty_tpl->tpl_vars['site']->value['urlalias'];?>
" style="color:white;font-size:32;"><?php echo stripslashes(mb_strtoupper($_smarty_tpl->tpl_vars['site']->value['name'], 'UTF-8'));?>
</a></div>
			
			<div id="main-search-field">
				
				<input class="search-field" data-collection="<?php echo $_smarty_tpl->tpl_vars['site']->value['id'];?>
" name="q" type="text" />
				
			</div>

		</td>
		
		<td valign="top">
			<div class="archmap-title" style="margin-top:15;margin-right:20;text-align: right;color:white; ">
		
		<a href="/<?php echo $_smarty_tpl->tpl_vars['site']->value['urlalias'];?>
" style="color:white;font-size:32;">Home</a> &nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="/<?php echo $_smarty_tpl->tpl_vars['site']->value['urlalias'];?>
/map" style="color:white;font-size:32;">Map&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			<a href="http://archmap.org" style="color:white;font-size: 32;">Archmap</a>
			</div>
			<div id="loginbox" >
						   		<button  id="headerEditButton" class="editButton edit-show" hidden>Edit</button>
		   		<button  id="headerUserButton" class="userButton">Guest</button>
		   		<button  id="loginButton"  onClick="javascript:loginButtonClicked();">Login</button>
		   		
		   		
		   		<button  id="registerButton"  onClick="javascript:registerButtonClicked();">Register</button>
		   		
		   </div>
		</td>
		</table>


		
		
		
		
	</div>

<div id="jquery-live-search" data-action"location" style="display:none;z-index: 90000"></div>


<?php }} ?>