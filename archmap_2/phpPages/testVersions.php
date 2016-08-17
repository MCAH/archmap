Test Versions<hr />

<?php


	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Place.php');


	$place = new Place(1181);
	
	
	
	if ( isset( $_GET["submit"] ) ) {
		
		$place->set('descript', addslashes($_GET['descript']) );
		
		$place->set('edit_author_id', 363 );
		//print(":::::::". $_GET['descript') . ":::::::");
		$place->saveChanges();
		header('Location: http://www.learn.columbia.edu/archmap/phpPages/testVersions.php');

	}
	
	
	print("<h2>".$place->get('name')."</h2>");
	print("<br />");
	
	if (isset($_GET["edit"])) {
		print('	
				<form action="?submit">
					<textarea name="descript" cols="120" rows="20">'.stripslashes($place->get('descript')).'</textarea>
					<input type="hidden" name="submit" value="true" />
					<br />
					<input type="submit" />
				</form>
				');
	}  else {
		print($place->get('descript'));
		print('<br /> [<a href="?edit=yes">edit</a>]');
	}
	
	
		
	
	$count = $place->versionCt();
	
	print('
	
		<br />
		<br />
		<br />
		<h4 style="margin-bottom:0;"><span style="color:red;">'.$count.'</span> Previous Versions</h4>
		<i style="font-size:10;">most recent on top</i>
		
		<br />
		<br />
		
		
	');
	
	$versionRows = $place->versionsHeaderRows();
	
	
	print('<table style="font-size:10;">');
	foreach ($versionRows as $row) {
	
		print('<tr> 
					<td width="100" valign="top">
						'.$row['editdate'].'
					</td>
					<td width="100" valign="top">
						'.$row['name'].'
					</td>
					<td valign="top">
						'.substr($row['descript'], 0, 255).'...
					</td>
				</tr>');
	}
	print("<table>");

?>