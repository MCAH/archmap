<head>
	<title>Archmap 2: One-off import of Buildings from Pringle</title>
</head>


<body >
	
<form method="post">
	
<?php
	error_reporting(E_ERROR | E_PARSE);
	//error_reporting(E_ALL);


	$reallySave = false;
	

	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');


	$reallySave = true;
	$publication = new Publication(3317);

	print('<h2> ** '.$publication->get('name').'</h2>');
    $relatedBuildings = $publication->getRelatedItems('Building', false);
	
	foreach ($relatedBuildings as $relatedBuilding) {
		$buidlingsFromDB[$relatedBuilding['catnum']] = $relatedBuilding;
	}
	
	
	
	print('Buildings so far: ' . sizeof( $relatedBuildings ) );


	print('<div><b>Import Buildings from Pringle\'s Catalog</b> </div>');
	
	$db = new Database("vincent.mcah.columbia.edu",   "arch_map", "mgf", "mgfmgfmgf");
	
	
	/*
	// GET BUILDING NAME SUGGESTIONS FROM THE TEXT FIELD
	if ($_REQUEST['building_data']) {

		$lines = explode("\n", $_REQUEST['building_data']);
		
		foreach($lines as $line) {
			if (preg_match("/[^(X|I|V)\s].*(?=\s\()/", stripslashes($line), $matches)) {
  				$name = $matches[0];
			}			
			if (preg_match("/(\d)+/",  str_replace(" ", "", stripslashes($line)), $matches)) {
  				$catnum = $matches[0];
			}	
			
			if (! $buildings[$catnum]) {
				$buildings[$catnum] = $name;
			}
		}
	}
	*/

	print('<hr />');
	

	if ($_REQUEST['place_data']) {
				
		$lines = explode("\n", $_REQUEST['place_data']);
		
		foreach($lines as $line) {
			
			
			
					
			// place
			$place_name = null;
			$catnum = null;

			if (preg_match("/.*(?=\()/", $line, $matches)) {
   				$place_name = trim(stripslashes($matches[0]));
			} else {
  				$place_name = trim(stripslashes($line));
  			}		
					
			if (preg_match("/(((?<=\d)\-)|\d)+/",  str_replace(" ", "", $line), $matches)) {
  				$catnum = $matches[0];
			}	
								
			// CREATE PLACE AND LINK TO PUB
			// …
			$sql = 'SELECT * from place WHERE name="'.$place_name.'"';
			$rows = $db->queryAssoc($sql);
			
			if (! $rows || $rows == "") {
				$place = new Place();
				$place->set('name', $place_name);
				$place->set('createdate', rightNow());
				$place->set('author_id', 363);
				if ($reallySave) $place->saveChanges();
			} else {
				// assume only one place like this….
				$place = new Place('ROW', $rows[0]);
			}
			if ($reallySave) $publication->addRelation($place, null, $catnum);
								
				
				
			echo '<b>'.$place_name.'</b>';
			
			if (! $catnum) {
				echo '<br />';
			} else  {
				echo ', ('.$catnum.')<br />';
				
				// CREATE BUILDING ROWS FOR THIS PLACE
				$nums = explode("-", $catnum);
				
				$cat = $nums[0];
				$end = $nums[1];
				
				if (! $end) {
					$c = 0;
				} else {
					$endlen = strlen($end);
					$less = substr($cat, -$endlen);
					$c = $end-$less;
				}
				
								
				
				for ($i=0; $i<=$c; $i++) {
					
					if ($i > 150) break;
					
					if (! $buidlingsFromDB[$cat]) {
						$bname = stripslashes($bnames[$cat]); // 1st choice
						if ( ($bname == "" || $bname == $place_name.', ') && $buildings[$cat] != "") {
							$bname = $buildings[$cat]; // 2nd
						} 
						if ( $bname == "") {
							$bname = stripslashes($place_name).', '; // 3rd
						}
						print('<div style="border: solid 1 gray;margin:5;padding:5;">['.$cat.'] - <input type="text"  name="bnames['.$cat.']" value="'.$bname.'" style="width:370;" /> <br /></div>');
						// create building
						
						
						$sql = 'SELECT * from building WHERE name="'.$bname.'"';
						$rows = $db->queryAssoc($sql);
						if ($rows) {
							$build = new Building('ROW',  $rows[0]);
						} else {
							$build = new Building();
							$build->set('name', $bname);
							$build->set('createdate', rightNow());
							$build->set('author_id', 363);
							if ($reallySave) $build->saveChanges();
						}
						
					
					} else {
						print('<div style="border: solid 1 gray;margin:5;padding:5;">['.$cat.'] - ' . $buidlingsFromDB[$cat]['name'] . ' <br /></div>');
						$build = new Building('ROW',  $buidlingsFromDB[$cat]);
					}
					
					if ($reallySave) {
						$place->addRelation($build, 'parent');
						$publication->addRelation($build, null, $cat);
					}
					
					$cat++;
				}
			}
			echo '<br />';	
		
	

		}
	
	}



?>



	<input type="hidden" name="test[144]" value="Bently" />
	<input type="hidden" name="test[145]" value="Fently" />
	<textarea name="place_data" method="POST" rows=30 cols=70><?php print(stripslashes($_REQUEST['place_data'])); ?></textarea>
	<input type="submit" />
</form>

</body>
</html>