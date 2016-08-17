<?php

ini_set('display_errors', 1);

error_reporting(E_ERROR);

// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

$db = Utilities::getSharedDBConnection();	



$debug = false;




// 1. -- GET DB DATA //

$resource = $_REQUEST['resource'];
$building_id = $_REQUEST['building_id'];

$catalog_type= $_REQUEST['type'];
if (! isset($catalog_type) || $catalog_type == "")
	$catalog_type = "lintel";
	
if (! $resource || $resource == "") {
	
	$resource = 151; // istanbul
	$resource = 212; // unesco
	$resource = 163; // GOTE
	$resource = 242; // famagusta
	$resource = 138; // famagusta
}
$model = new Essay($resource); 


// for dom rendering inphp and smarty
$building_rows = $model->getRelatedItems("Building", false);

//print_r($building_rows);
//println("YUBBA");
//print_r($building_rows);
//printline(" ");

// for passing to javascript as a json string
$building_json = $model->getRelatedItems("Building", true);
//print_r($building_json); exit;

$sql = 'SELECT * from essay where isSite=1 order by name';
$site_rows = $db->queryAssoc($sql);




// FEATURE CATEGORIES
$feature_types = array();
$feature_types[] = "portal";
$feature_types[] = "lintel";
$feature_types[] = "pier";
$feature_types[] = "capital";
$feature_types[] = "arches";
$feature_typesSortvals = array_flip($feature_types);

// SORTING RUBRICS
$rubrics_key = array();
$rubrics_key[] = "description";
$rubrics_key[] = "plan";
$rubrics_key[] = "elevation";
$rubrics_key[] = "chronology";
$rubrics_key[] = "significance";
$rubrics_key[] = "sculpture";
$rubrics_key[] = "paintings";
$rubrics_key[] = "mosaics";
$rubrics_key[] = "frescos";
$rubrics_key[] = "portals";
$rubrics_key[] = "lintels";
$rubrics_key[] = "accretion of structure";
$rubrics_key[] = "seismic notes";


$rubric_sortvals = array_flip($rubrics_key);





$buildings = array();

$i = 0;
for($i=0; $i<sizeof($building_rows); $i++) {
		
	//println($building_rows[i].name);
	
	$tmp_building = new Building($building_rows[$i]);
	
	$building_rows[$i]["name"] = $tmp_building->get("name");
	

	// PUBLICATIONS
	$publications = $tmp_building->getRelatedItems("Publication", false);
	$building_rows[$i]['publications'] = $publications;
	
	
	// ! PASSAGES
	$passages = $tmp_building->getRelatedItems('Passage', false);
	
	if (isset($passages)) {
	
		// assign a sortval to each rubric, then sort passages by sortval, editdate

		$ii = 0;
		 
		foreach ($passages as $passage) 
		{
			$passages[$ii]["sortval"] = $rubric_sortvals[strtolower($passages[$ii]["name"])];
						
			$p = new Passage($passage);
			$imageViews = $p->getRelatedItems('ImageView', false);			
			
			if ($imageViews) 
				$passages[$ii]["imageViews"] = $imageViews;
			
			$ii++;
		}
	
		$passages = record_sort($passages, array("sortval","public-status","editdate"));
		
		$rubrics = array();
		$lastName= "";
	
		foreach ($passages as $passage) {
			//$name = $passage["relationship"];
			$name = $passage["name"];
			
			if ( strtolower($name) != strtolower($lastName) ) 
				$rubrics[strtolower($name)] = array();
			
			$rubrics[strtolower($name)][] = $passage;
			
			$lastName = strtolower($name);
		
		}
		
		$rubricsSorted = array();
		foreach($rubrics_key as $rubric_key) {
			if ($rubrics[$rubric_key])
				$rubricsSorted[] = $rubrics[$rubric_key];						
		}

		logit("DONE WITH RUBRICS");
		$building_rows[$i]['rubrics'] = $rubricsSorted;

	} // /passages

}
	
	// HAVE ALL THE DATA WE NEED!
	$building_rows = record_sort($building_rows, "name");
	

//echo "hallo";
//print_r($building_rows);









require_once $_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Site/PHPRtfLite-1.3.1/lib/PHPRtfLite.php';
// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

// rtf document
$rtf = new PHPRtfLite();
$rtf->setMarginTop(2);

//paragraph formats
$parFormat = new PHPRtfLite_ParFormat();

$paragFormat = new PHPRtfLite_ParFormat();
$paragFormat->setSpaceBetweenLines(2);

$captionFormat = new PHPRtfLite_ParFormat();
$captionFormat->setSpaceBetweenLines(1);
$fontCaption = new PHPRtfLite_Font(10, 'Arial');

$featureCount = 1;

// header
$header = $rtf->addHeader();
$header->writeText('Appendix A: Catalog of Buildings', new PHPRtfLite_Font(), new PHPRtfLite_ParFormat());


$sect = $rtf->addSection();
$sect->writeText('<b>Catalog of Buildings</b><br /><br />', new PHPRtfLite_Font(18), new PHPRtfLite_ParFormat('center'));
$figureCount = 1;
$buildingCount = 1;



$figureCount = 1;


//$figureCount = 0;


$allFigures = array();
$figuresNumById = array();
$figureNum = 1;


foreach ($building_rows as $row)
{
	
	$line = '<br><br>'.($buildingCount++).'. <b>'.$row['name'] . '</b> <br>';
	$sect->writeText($line, new PHPRtfLite_Font(14), new PHPRtfLite_ParFormat('left'));
	
	if ($debug) print('<h1>'.$line.'</h1>');
	
	$line = '<i>ca. '.$row['date'] .'</i><br>';
	$sect->writeText($line, new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat('left'));
	
	
	if ($debug) print('<br>'.$line.' ');
	
	
	if(! isset($row['rubrics']))
		continue;
	
	// prepare all figures
	$buildingFigures = array();
	
	
	foreach($row['rubrics'] as $name=>$passages) 
	{
		foreach($passages as $passage) 
		{
			foreach($passage['imageViews'] as $imageView) 
			{
				$buildingFigures[] = $imageView;
				$allFigures[] = $imageView;
				$figuresNumById[$imageView['imageview_id']] = $figureNum;
				
				//print_r($imageView);
				//printline($imageView['id']);
								
				$figureNum++;
			}	
		}
	}

	
	
		
	foreach($row['rubrics'] as $name=>$passages) {
		
		if(! isset($passages))
		continue;
		
		
		$rubricName = "";
		if (isset($passages[0]) && $passages[0]['name'] != "")
			$rubricName = $passages[0]['name'];
		
	

		$line = '<b>' . $rubricName . '</b> ';
	
	
	//$sect->writeText($line, new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat('left'));
		
		if ($debug) print('<li>'.$line.'</li>');
		
		
		foreach($passages as $passage) {
			
			// parse for footnotes
			$text = $passage['descript'];
	
			$text = strip_tags($text, '<p><a><br><ol><h1><h2><h3><li>'); 
	
			if ($debug) print($text.'<br>');
			
			$DOM = new DOMDocument;
			$DOM->loadHTML($text);
			$items = $DOM->getElementsByTagName('li');
			//for ($i = 0; $i < $items->length; $i++)
	        //	echo $items->item($i)->nodeValue . "<br/>";





			// figure references
			$anchors = $DOM->getElementsByTagName('a');
	        for ($i = 0; $i < $anchors->length; $i++)
	        {
	        	$anchorIsAnImageView = false;
		        for ($j = 0; $j < $anchors->item($i)->attributes->length; ++$j) 
		        {
		        	$attribute = $anchors->item($i)->attributes->item($j);
		        	//echo "-- " .$attribute->name . '::'. $attribute->nodeValue.'<br>';
		        	if ($attribute->name == "data-entity" && $attribute->nodeValue == "ImageView")
		        	{
			        	
						$anchorIsAnImageView = true;
		        	
		        	}
		        	if ($attribute->name == "data-id" && $anchorIsAnImageView)
		        	{
			        	//echo "-------> ".$row['name'] ."::".$rubricName." - Fig. " . $figuresNumById[$attribute->nodeValue].'<br>';
			        	
						
						$text = preg_replace('#<a .*?data-entity="ImageView".*?data-id="'.$attribute->nodeValue.'.*?</a>#', " (Fig. ".$figuresNumById[$attribute->nodeValue].") ", $text);
		        	//echo "<hr>".$text;
		        	//echo "<hr>";
		        	}
		        	
		        }
		        
	        }
	        	

			
			//$sect->writeText('<b>'.$rubricName . '</b>: ', new PHPRtfLite_Font(12), $paragFormat);
			
			// footnotes
			$text = preg_replace('#<a id="fnref.*?>.*?</a>#', "**", $text);
			$text = preg_replace('#<ol.*?>.*?</ol>#', "", $text);
			
			$fn_count = substr_count($text, '**');
			if ($fn_count > 0) {
				
				$textParts = explode("**", $text);
				
				$ii = 0;
				foreach ($textParts as $frag) {
					
					if ($ii == 0)
						$sect->writeText('<b>'.$rubricName . '</b>: '.$frag, new PHPRtfLite_Font(12), $paragFormat);
					else
						$sect->writeText($frag, new PHPRtfLite_Font(12), $paragFormat);
					
					if ($fn_count-- < 1) break; 
					$sect->addFootnote($items->item($ii++)->nodeValue);
		
					
				}
			} else {
				$sect->writeText('<b>'.$rubricName . '</b>: '. $text . '', new PHPRtfLite_Font(12), $paragFormat);
				
			}
			
			// PREPARE FIGURES
			
							
		} // each passage
		
	} // each rubric
	
	
	// BIBLIOGRAPHY
	if ($row['publications'])
	{
		$sect->writeText('<br><b>Selected Sources</b> <br>', new PHPRtfLite_Font(12), $paragFormat);
		foreach($row['publications'] as $pub)
		{
			
			if ($pub['type'] == "book")
				$sect->writeText(str_replace(";", ", ", $pub['authors']).', <i>'.  $pub['name'] . '</i>, '.$pub['location'].', '.$pub['date'].'.  p. '.$pub['pages'].'<br>'); 
			else if ($pub['type'] == "article-journal")
				$sect->writeText(str_replace(";", ", ", $pub['authors']).', "'.  $pub['name'] . '", <i>'.  $pub['container_title'] . '</i>, ('.$pub['date'].'), '.$pub['jpages'].'. p. '.$pub['pages'].'<br>'); 
			
		
		}
		$sect->writeText('<br>');
		
	}

	
	
	// FIGURES FOR BUILDING
	$imageSize = 7.25; // cm?
				
	$table = $sect->addTable();
	
	$rowCount = sizeof($buildingFigures)/2;
	$rowHeight = $imageSize+.2;
	
	$columnCount = 2;
	$columnWidth = $imageSize+.2;
	
	$table->addRows($rowCount, $rowHeight);
	$table->addColumnsList(array_fill(0, $columnCount, $columnWidth));


	$image_i = 0;
	foreach($buildingFigures as $imageView) {
		
		$rowIndex = 1 + $image_i/2;
		 
		$columnIndex =  ($image_i % 2) ? 2 : 1;
		
		$cell = $table->getCell($rowIndex, $columnIndex);
					
		if($image_i % 2)
		{
		// I'm in an even row
		$cell->setPaddingLeft(.2);
		}else{
		// I'm in an odd row
		$cell->setPaddingRight(.2);
		}
	
		
		$image = $cell->addImage($_SERVER['DOCUMENT_ROOT'].$imageView['webpath'].'/'.$imageView['imageview_id'].'_full.jpg');
		$image->setWidth($imageSize);
		$image->setHeight($imageSize);
		
		
		$cell->writeText('Fig. C-'.$figureCount++ . '.  <b>' . $row['name']  . '</b>. '.$imageView['name'].'<br>', new PHPRtfLite_Font(10), $captionFormat);
		
		
		$image_i++;
		
	}
	
	
	
	
	
	
	
} // each building




foreach($figuresNumById as $key=>$val)
{
	//$sect->writeText("iv_id. ". $key . " is (fig. ".$val.')<br>');
}
	


/*
// FIGURES
$sect->writeText('<b>Figures</b><br /><br />', new PHPRtfLite_Font(16), new PHPRtfLite_ParFormat('left'));
$figureCount = 1;
foreach ($building_rows as $row)
{
	if ($row['features']){
		foreach($row['features'] as $feature) {
			if ($feature['imageViews']){
				foreach($feature['imageViews'] as $imageView) {
					$sect->addImage($_SERVER['DOCUMENT_ROOT'].'/archmap/media/imageviews/000/'.$imageView['imageview_id'].'_300.jpg');
					$sect->writeText('Fig. '.$figureCount++ . '  <b>' . $feature['name'] . '</b><br>'. $row['name'].'<br><br><br>', new PHPRtfLite_Font(10), new PHPRtfLite_ParFormat('left'));
				
				}
			}
		}
	}
}
*/
// save rtf document
//$rtf->save($dir . '/generated/' . basename(__FILE__, '.php') . '.rtf');


$rtf->save($_SERVER['DOCUMENT_ROOT'] . "/archmap_2/Site/downloads/CatalogLintelsDoc.rtf");

$url = '/archmap_2/Site/downloads/download.php';




header('Location: ' . $url, true, $permanent ? 301 : 302);
exit();

echo "HALLO!";




















function record_sort($records, $orderby, $reverse=false)
{
    $hash = array();
    
    
   
    foreach($records as $record)
    {
    	logIt($field . " :: hash key = ". $record[$field]);
    	
    	if (is_array($orderby)) {
    		$key = "";
	    	foreach($orderby as $field) {
	    		$key .= $record[$field] . "_";
	    	}
	    	$hash[$key] = $record;
    	} else {
        	$hash[$record[$orderby].'_'.$record['editdate'].'_'.$record['id']] = $record;   	
    	}
    }
    
    
    ($reverse)? krsort($hash) : ksort($hash);
    
    $records = array();
    
    foreach($hash as $record)
    {
       $records []= $record;
    }
    
    return $records;
}



?>