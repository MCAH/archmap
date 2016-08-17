Test Town<hr />

<?php


	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Place.php');


	$place = new Place(1181);
	
	print($place->get('name'));
?>