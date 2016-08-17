<?php
header("Content-type: image/jpeg");

$filedata 		= explode("--", $_GET['imagedata']);
	

$filename = $filedata[0];

$fullfile = '/archmap/media/images/'.$filename .'_full.jpg';

$filepath = "/home/mgf/" . $fullfile;

$original = imagecreatefromjpeg($filepath);


list($width, $height, $type, $attr) = getimagesize($filepath);

$cubesize = $height;
 

$size =  $filedata[1];
if (! isset($size)) {
	$size = 512;	
}

$panel =  $filedata[2];
if (! isset($panel)) {
	$panel = 'front';	
}

switch ($panel) {
	
	case "front": 	$posx = 0;	break;
	case "right": 	$posx = $cubesize * 1;	break;
	case "back": 	$posx = $cubesize * 2;	break;
	case "left": 	$posx = $cubesize * 3;	break;
	case "top": 	$posx = $cubesize * 4;	break;
	case "bottom": 	$posx = $cubesize * 5;	break;
	default: 		$posx = 0;
}







$tempImg = imagecreatetruecolor($size, $size) or die("Cant create temp image");

$width=2048;
imagecopyresized($tempImg, $original, 0, 0, $posx, 0, $size, $size, $height, $height) or die("Cant resize copy");
 


imagejpeg($tempImg, null, 85);

imagedestroy($tempImg);



?>