<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

	error_reporting(E_ERROR | E_PARSE);

	// global
	function codebaseDir() { return $_SERVER['DOCUMENT_ROOT'] . "/archmap_2"; }
	
	require_once   (codebaseDir() . '/Setup.php');
	require_once   (codebaseDir() . '/Request.php');

	$request = new Request();
	$response = $request->response();
	//logIt("PRINTING RESPONSE...".$response);
	echo $response;
	



?>