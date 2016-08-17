<?php

		header("Content-Type: text/html; charset=utf-8");


		// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');



		$filename = $_SERVER["DOCUMENT_ROOT"] . '/archmap_2/phpPages/SerdarCatalog.txt';
		
		
		$lines = file($filename);
		
		// add features to essay 255
		$site = new Essay(255);
		
		print('<h2>'.$site->get('name').'</h2>');
		
		$counter = 0;
		echo '<table border=1 cellpadding=3>';
		foreach ($lines as $line)
		{
			if ($counter++ <= 20)
				continue;
		
			$line = iconv(mb_detect_encoding($line), 'UTF-8', $line);
			
			$chunks = explode("%", $line);
			
			echo '<tr>';
			
			
			
			$gender = trim(str_replace('"', "", $chunks[9]));
			$prof 	= str_replace('"', "", $chunks[10]);
			$prov   = str_replace('"', "", $chunks[14]);
			$refnum = "serdar_seals_" . str_replace('"', "", $chunks[26]);
			
			
			
			
			$length = "";
			$width = "";
			$size = str_replace("cm", "", str_replace('"', "", $chunks[19]));
			
			
			if ($size != ""){
				$sizeParts = explode("x", $size);
				
				// if : seal - height, diam
				// else if : tablet length - height
				$length = trim($sizeParts[0]);
				$width = trim($sizeParts[1]);
			} 
			
			
			
			// archmap fields
			$descript			 	= str_replace('"', "", $chunks[6]);
			$publication 			= str_replace('"', "", $chunks[2]);
			$current_location 		= str_replace('"', "", $chunks[3]);
			$cat_id 				= str_replace('"', "", $chunks[15]);
			
			$subtype				= str_replace('"', "", $chunks[4]);
			$material				= str_replace('"', "", $chunks[5]);
			
			
			// PASSAGES 
			$notes 					=  str_replace('"', "", $chunks[13]);
			$contents 				=  str_replace('"', "", $chunks[7]);
			$inscription			=  str_replace('"', "", $chunks[27]);
			
			
			
			
			
			
			//$name = str_replace('"', "", $chunks[22]).' ' .str_replace('"', "", $chunks[4]).', ' .str_replace('"', "", $chunks[5]).', '.str_replace('"', "", $chunks[10]);
			
			//$name = $obj.', ' .$mat.', '. $prof . '('.$prov.')' ;
			
			
			$proftext ="";
			if (trim($prof) == "Unknown" || $prof == "not known") {
				
				if ($gender == "Female") {
					$proftext .= " of a female";
				}
				
				$proftext .= ", profession unknown";
				
			} else {
				$proftext = " of a ";
				if ($gender == "Female")
					$proftext = $proftext . "female ";
				$proftext = $proftext . $prof;
				
			}
			
			$name = ucfirst(trim(strtolower($material . ' ' .$subtype . $proftext)));
			
			$name = str_replace("royalty-", "", $name);
			$name = str_replace("royalty", "royal personage", $name);
			
			
			if ($prov == "")
			{
				$provtext = "";
			}
			else {
				$provtext = " from ". $prov;
			}
			
			
			 $name =  $name . $provtext ;
			 
			 
			 
			 
			 $f = new Feature();
			 
			 $f->set("name", 					$name);
			 $f->set("refnum", 					$refnum);
			 $f->set("descript",				addslashes( $descript ));
			 $f->set("subtype", 				$subtype);
			 $f->set("material", 				$material);
			 $f->set("current_location", 		$current_location);
			 $f->set("current_location_catid", $cat_id);
			 $f->set("publication", $publication);
			 
			 if ($subtype == "Seal") {
			 	$f->set("height", $length/10);
			 	$f->set("diameter", $width/10);
				 
			 }
			 else {
			 	$f->set("height", $length/10);
			 	$f->set("width", $width/10);
				 
			 }
			 
	 
			$f->saveChanges();
			
			
			$site->addRelation($f);

			if ($notes != "") {
				$p = new Passage();
				$p->set("name", "Notes");
				$p->set("descript", $notes);
				$p->saveChanges();
				$f->addRelation($p);
			}
			if ($contents != "") {
				$p = new Passage();
				$p->set("name", "Contents");
				$p->set("descript", $contents);
				$p->saveChanges();
				$f->addRelation($p);
			}
			if ($inscription != "") {
				$p = new Passage();
				$p->set("name", "Inscription");
				$p->set("descript", $inscription);
				$p->saveChanges();
				$f->addRelation($p);
			}
			
			
			
			
			
			// mapped fields
			
			print('<td valign="top"><b>'.$refnum.'</b></td>');
			print('<td valign="top"><b>'.$name.'</b></td>');
			print('<td valign="top"><i>'.$length . ' x ' . $width.'</i></td>');
			print('<td valign="top"><i>'.$descript.'</i></td>');
			print('<td valign="top"><i>'.$subtype.'</i></td>');
			print('<td valign="top"><i>'.$material.'</i></td>');
			print('<td valign="top"><i>'.$current_location.'</i></td>');
			
			print('<td valign="top"><i>'.$notes.'</i></td>');
			print('<td valign="top"><i>'.$contents.'</i></td>');
			print('<td valign="top"><i>'.$inscription.'</i></td>');
			
			print('<td valign="top"><nobr>-----</nobr></td>');
			
			// raw fields
			foreach ($chunks as $chunk)
			{
				print('<td valign="top">'.str_replace('"', "",$chunk).'</td>');
				
			}
			
			
			
			
			
			
			
			
			echo '</tr>';
			
		
			
		}
		echo '</table>';

		echo 'done';

?>
