<?php

	//ini_set('display_errors',1);
	//error_reporting(E_NOTICE);

require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/models/Publication.php');


//$lines = file('./fromArtIndex.txt');
//$lines = file('./fromArtAbstracts.txt');
//$lines = file('./AnthropologicalIndex.txt');
$lines = file('./AveryIndex.txt');


///////////////////////////////////////
// CLICK HANDLERS
//////////////////////////////////////


// SAVE THE LINE RECORD TO THE DB
$saveline = $_GET['saveline'];
if ( isset($saveline) && is_numeric($saveline).'<br /' ) {
	
	$flields = explode(";", $lines[$saveline]);	
	$issn 		= str_replace('"', "",  $flields[1]);
	$name 		= str_replace('"', "",  $flields[0]);
	$metaphone	= metaphone($name);
	
	
	$savePub = new Publication();
	$savePub->set('ISBN_ISSN', $issn);
	$savePub->set('name', $name);
	$savePub->set('metaphone', $metaphone);
	$savePub->takeValueForKey("pubtype", 1000);
	
	
	$savePub->saveChanges();
	header('Location:importPeriodicals_fromOCLC.php');	
	die();
	exit;
}

// SAVE A PUB BASED ON ID
$editid 	= $_GET['editid'];
if (is_numeric($editid)) {
	$savepub 	= new Publication($_GET['editid']);
	if (isset($issn)) 	$savepub->set('ISBN_ISSN', 	$_GET['issn']);
	if (isset($name)) 	$savepub->set('name', 		$_GET['name']);
	
	$savepub->saveChanges();
	header('Location:importPeriodicals_fromOCLC.php');	
	die();
	exit;
}


$db = new Database();

print("<h2>Import Periodicals</h2>");




print('<a href="importPeriodicals_fromOCLC.php">Refresh</a>');

print('<table style="font-family:Helvetica" border="1">');

foreach ($lines as $line_num => $line)  {
	


	if ($line_num == 0) {
	
		continue;
	}
	$flields = explode(";", $line);
	
	$status = "new";
	
	
	$issn 		= str_replace('"', "",  $flields[1]);
	$name 		= str_replace('"', "",  $flields[0]);
	$metaphone	= metaphone($name);
	
	
	// ISSN search
	if (isset($issn) && $issn != "") {
		$q = 'select * from publication where ISBN_ISSN="'.$issn.'" && pubtype=1000';
		$rows = $db->queryAssoc($q);
		if ($rows) {
			$pub = new Publication($rows[0]);
			print('
				<tr>
					<td style="color:gray" width="100"><nobr>line: '. $line_num . '</nobr></td>
					<td width="100"><span style="color:gray">Saved</span></td> 
					<td style="color:green" width="100">db['.$pub->get('id') . ']:</td>
					<td style="color:gray" width="100">'. $issn . '</td> 
					<td> <b>'. $name .'</b></td> 
					<td style="color:gray">'. $metaphone . '</td> 
				</tr>');
		
			continue; // next file line
		}
	}
	
	
	
	// name search
	if ($status == "new") {
		
		$q = 'SELECT * from publication where name="'.$name.'" AND pubtype=1000';
		$rows = $db->queryAssoc($q);
		
		if (isset($rows) && sizeof($rows) > 0) {
			// there are other periodicals with the exact same title.

			foreach($rows as $row) {
				$pub = new Publication($row);
				
				if ($issn == ""  && $pub->get('ISBN_ISSN') == "") {
					// consider this line saved
					print('
						<tr>
							<td style="color:gray" width="100"><nobr>line: '. $line_num . '</nobr></td>
							<td width="100"><span style="color:gray">Saved</span></td> 
							<td style="color:green" width="100">db['.$pub->get('id') . ']:</td>
							<td style="color:gray" width="100">'. $issn . '</td> 
							<td> <b>'. $name .'</b></td> 
							<td style="color:gray">'. $metaphone . '</td> 
						</tr>');
					$xml = "";
					break;
				}
				
				// "USE ISSB" LINK
				if($pub->get('ISBN_ISSN') == "" && $issn != "") {
					$issnLink = '<a href="?editid='.$pub->get('id').'&issn='.$issn.'">Use issn</a>';
				} else {
					$issnLink = $pub->get('ISBN_ISSN');
				}
				
				$xml .= '
				<tr>
					<td style="color:gray" width="100"><nobr></nobr></td>
					<td width="100" align="right"><span style="color:gray">like <b>title</b></span></td> 
					<td style="color:green" width="100">db['.$pub->get('id') . ']:</td>
					<td style="color:green" width="100">'. $issnLink . '</td> 
					<td> <b>'. $pub->get('name') .'</b></td> 
					<td style="color:green">'. $pub->get('metaphone') . '</td> 
				</tr>';
			}
			
			
			if ($xml == "") {
				continue; // next line
			}


			if (isset($issn) && $issn != "") {
				$save_link = '<a href="?saveline='.$line_num.'">Save</a>';
			} else {
				$save_link = "";
			}
			
			print('<tr><td height="20" /></tr>');
			print('
				<tr>
					<td style="color:gray" width="100"><nobr>line: '. $line_num . '</nobr></td>
					<td width="100"><span style="color:red">Not Saved</span></td> 
					<td style="color:green" width="100">
						'.$save_link.'
					</td>
					<td style="color:gray" width="100">'. $issn . '</td> 
					<td>
						 <b>'. $name .'</b> 
						
					</td> 
					<td style="color:gray">'. $metaphone . '</td> 
				</tr>' . $xml);
			
			$xml = "";
			
			print('<tr><td height="20" /></tr>');
			
			
			continue;  // next file line
		}
	}
	
	
	
	
	
	// metaphone search
	if ($status == "new") {
		$q = 'SELECT * from publication where  metaphone="'.$metaphone.'"  and pubtype=1000';
		$rows = $db->queryAssoc($q);
		
		if (isset($rows) && sizeof($rows) > 0) {
			// there are other periodicals with the  same metaphone.

			foreach($rows as $row) {
				$pub = new Publication($row);
				
				
				
				$issnLink = $pub->get('ISBN_ISSN');
				
				
					
				$xml .= '
				<tr>
					<td style="color:gray" width="100"><nobr></nobr></td>
					<td width="100" align="right"><span style="color:gray">like <b>metaphone</b></span></td> 
					<td style="color:green" width="100">db['.$pub->get('id') . ']:</td>
					<td style="color:green" width="100">'. $issnLink . '</td> 
					<td> <b>'. $pub->get('name') .'</b></td> 
					<td style="color:green">'. $pub->get('metaphone') . '</td> 
				</tr>';
			}
			
			
			if ($xml == "") {
				continue; // next line
			}

			$status = "Not Saved";
			
			print('<tr><td height="20" /></tr>');
			print('
				<tr>
					<td style="color:gray" width="100"><nobr>line: '. $line_num . '</nobr></td>
					<td width="100">
						<span style="color:red">Not Saved</span>
					</td> 
					
					<td style="color:green" width="100">
						<a href="?saveline='.$line_num.'">Save</a>
					</td>
					<td style="color:gray" width="100">'. $issn . '</td> 
					<td> 
						<b>'. $name .'</b>
						<a href="?editid='.$pub->get('id').'&name='.$name.'">Use title</a>
					</td> 
					<td style="color:gray">'. $metaphone . '</td> 
				</tr>' . $xml);
			
			$xml = "";
			
			print('<tr><td height="20" /></tr>');
			
			continue;  // next file line

		}
	}		
	
	if ($status == "new") {
		$pub = new Publication();
		
		
	
		$pub->takeValueForKey("ISBN_ISSN", $issn);
		$pub->takeValueForKey("name", $name);
		$pub->takeValueForKey("pubtype", 1000);
	
		
		
		//$pub->saveChanges();
	
		
	}
	if ($status == "new") $status = '<span style="color:blue"><b>NEW</b></span>';
	
	print('<tr>	<td style="color:gray" width="100">'. $line_num . '</td>
				<td width="100">'. $status . '</td> 
				<td width="100"></td> 
				
				<td style="color:gray" width="100">'. $issn . '</td> 
				<td> <b>'. $name .'</b>
				</td> <td style="color:gray">'. $metaphone . '</td> 
			</tr>');

}

print('<table>');









?>