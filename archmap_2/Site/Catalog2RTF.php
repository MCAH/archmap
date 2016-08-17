<?php

ini_set('display_errors', 1);

error_reporting(E_ERROR);

// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

$db = Utilities::getSharedDBConnection();	






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

$buildings = array();

$i = 0;
for($i=0; $i<sizeof($building_rows); $i++) {
		
	//println($building_rows[i].name);
	
	$tmp_building = new Building($building_rows[$i]);
	
	$building_rows[$i]["name"] = $tmp_building->get("name");
	
	
	// GET FEATURE PLOTS FOR PLANIMAGE
	//print_r($tmp_building->attrs);

	if ( "".$tmp_building->get("plan_image_id") != "" ) {
		$building_rows[$i]["planPlots"] = $tmp_building->getImagePlots( $tmp_building->get("plan_image_id") );
	}		
	
	
	
	$features = $tmp_building->getFeatures($catalog_type, false, false);
		
		for( $ii=0; $ii<sizeof($features); $ii++) {
			
			$f = new Feature($features[$ii]);
	
			$imageViews = $f->getRelatedItems('ImageView', false);
			if ($imageViews) {
				$features[$ii]["imageViews"] = $imageViews;
			}
			
			$attributes = $f->getAttributes(false);
			if ($attributes) {
				$features[$ii]["attributes"] = $attributes;
			}
		}
		
	$building_rows[$i]['features'] = $features;
	
	//print_r($building_rows[$i]['features']);
	//println('<hr>');
	

}


	
// HAVE ALL THE DATA WE NEED!
	$building_rows = record_sort($building_rows, "name");
	














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

$featureCount = 1;

// header
$header = $rtf->addHeader();
$header->writeText('Appendix A: Catalog of Lintels', new PHPRtfLite_Font(), new PHPRtfLite_ParFormat());


$sect = $rtf->addSection();
$sect->writeText('<b>Catalog of '.ucfirst($catalog_type).'s</b><br /><br />', new PHPRtfLite_Font(18), new PHPRtfLite_ParFormat('center'));
$figureCount = 1;
foreach ($building_rows as $row)
{
	if(! isset($row['features']))
		continue;
		
	$sect->writeText('<b>'.$row['name'] . '</b><br>', new PHPRtfLite_Font(14), new PHPRtfLite_ParFormat('left'));
	
	
	foreach($row['features'] as $feature) {
		
		
		// list figures
		if ($feature['imageViews']){
			$tmp = "(";
			$first = true;
			foreach($feature['imageViews'] as $imageView) {
				if ($first) {
					$first = false;
				} else {
					$tmp .= ', ';
					
				}
				$tmp .= 'Fig. '.$figureCount++;
			
			}
			$tmp .= ')';
			
			//$sect->writeText($tmp, new PHPRtfLite_Font(10), new PHPRtfLite_ParFormat('left'));
			
		}
		
		
		$sect->writeText('<br>LIN.'.$featureCount++ . '  <b>' . $feature['name'] . '</b> '.$tmp, new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat('left'));
		
		// parse for footnotes
		$text = $feature['descript'];

		$DOM = new DOMDocument;
		$DOM->loadHTML($text);
		$items = $DOM->getElementsByTagName('li');
		//for ($i = 0; $i < $items->length; $i++)
        //	echo $items->item($i)->nodeValue . "<br/>";
        
		$text = preg_replace('#<a id="fnref.*?>.*?</a>#', "**", $text);
		$text = preg_replace('#<ol.*?>.*?</ol>#', "", $text);
		
		$fn_count = substr_count($text, '**');
		if ($fn_count > 0) {
			$textParts = explode("**", $text);
			
			$ii = 0;
			foreach ($textParts as $frag) {
				$sect->writeText($frag, new PHPRtfLite_Font(12), $paragFormat);
				
				if ($fn_count-- < 1) break; 
				$sect->addFootnote($items->item($ii++)->nodeValue);
	
				
			}
		} else {
			$sect->writeText($text . '<br><br>', new PHPRtfLite_Font(12), $paragFormat);
			
		}
		
	}
	
}

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