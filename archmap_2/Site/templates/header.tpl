<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>{$pageTitle}</title>
		
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
			<div style="color: white;" id="site-name"><a href="/{$site.urlalias}" style="color:white;font-size:32;">{$site.name|upper|stripslashes}</a></div>
			
			<div id="main-search-field">
				
				<input class="search-field" data-collection="{$site.id}" name="q" type="text" />
				
			</div>

		</td>
		
		<td valign="top">
			<div class="archmap-title" style="margin-top:15;margin-right:20;text-align: right;color:white; ">
		
		<a href="/{$site.urlalias}" style="color:white;font-size:32;">Home</a> &nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="/{$site.urlalias}/map" style="color:white;font-size:32;">Map&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

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


