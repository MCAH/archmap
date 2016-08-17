<?php

ini_set('display_errors', 1);

error_reporting(E_ERROR);

// set path to Smarty directory *nix style
define('SMARTY_DIR', $_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Smarty/libs/');

require(SMARTY_DIR . '/Smarty.class.php');


// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

$db = Utilities::getSharedDBConnection();	


//unlink("/home/mgf/archmap_2/logging/logger2.txt");
//unlink("/home/mgf/archmap_2/logs/access.log");
//unlink("/home/mgf/archmap_2/logs/error.log");

// 1. -- GET DB DATA //




$smarty = new Smarty;







// MONOGRAPH  //

	// url items to indicate monograph
	$building_id = $_REQUEST['building_id'];
	$entity = $_GET['entity'];
	$id 	= $_GET['id'];
	
	
	
	
	if (is_numeric($building_id)) {
		$monograph = new Building($building_id);
		$building = $monograph;
		$entity = "Building";
	}
	else if ($entity == "Feature" && is_numeric($id)) 
	{
		$monograph = new Feature($id);
		$smarty->assign("monograph_entity", "Feature");
	}

	
	$smarty->assign("monograph_entity", $entity);








if (isset($monograph) && $monograph->get('id')) {

	// ASSIGN BUILDING
	$attrs = $monograph->getEncodedAttrs();
	
		
	if ($entity == "Building")
	{
		$attrs['plan_url300'] 	= $building->floorplanURL(300);
		$smarty->assign("selectedBuilding", $attrs);
		
	}
	$smarty->assign("monograph", $attrs);
	

	// COLLECTIONS THIS BUILDING IS IN
	
	$collections = $monograph->getRelatedItems('Essay', false);
	$smarty->assign("collections", $collections);


	$features = $monograph->getRelatedItems('Feature', false);
	
	if (isset($features)) {

	
		// assign a sortval to each rubric, then sort passages by sortval, editdate
		$ii = 0;
		foreach ($features as $feature) {
			$features[$ii]["sortval"] = $feature_typesSortvals[strtolower($feature["subtype"])];
			
			
			$f = new Feature($feature);
			
			$tags = $f->get("tags");
			if (isset($tags) && $tags != "") {
				$features[$ii]['tagItems'] = explode(";", $tags);
			}
			
			$imageViews = $f->getRelatedItems('ImageView', false);
			if ($imageViews) {
				$features[$ii]["imageViews"] = $imageViews;
			}
			
			
			$attributes = $f->getAttributes(false);
			if ($attributes) {
				$features[$ii]["attributes"] = $attributes;
			}
			
		
			
			$ii++;
		}
		$features = record_sort($features, "sortval");
		//$passages = record_sort($passages, "name");
		

		$featuresets = array();
		$lastSubtype= "";
		
		// sort group passages by name into rubrics
		foreach ($features as $feature) {
			//$name = $passage["relationship"];
			$subtype = $feature["subtype"];
			
			if ( strtolower($subtype) != strtolower($lastSubtype) ) {
				$lexentry = getLexiconEntry($subtype);
				$lexname = $lexentry['name_plural'];
				$featuresets[$lexname] = array();
			}
			
				
			// add to featureset
			$featuresets[$lexname][] = $feature;
			
			$lastSubtype = $subtype;
		
		}
		//print_r ($featuresets);
		//printline();
		
		$smarty->assign("featuresets", $featuresets);

	}	









	// PUBLICATIONS
	$publications = $monograph->getRelatedItems('Publication', false);
	foreach ($publications as $publication) {
		$publication['contributors'] = utf8_decode(stripslashes($publication['contributors']));
	}

	$smarty->assign("publications", $publications);






	// PASSAGES
	$passages = $monograph->getRelatedItems('Passage', false);
	
	
	//print_r($passages);
	//exit;
	if (isset($passages)) {
	
		// assign a sortval to each rubric, then sort passages by sortval, editdate
		logIt( "------ assign sortvals....");
		$ii = 0;
		foreach ($passages as $passage) {
			
			
			$passages[$ii]["sortval"] = $rubric_sortvals[strtolower($passage["name"])];
			
			
			$p = new Passage($passage);
			$imageViews = $p->getRelatedItems('ImageView', false);
			if ($imageViews) {
				$passages[$ii]["imageViews"] = $imageViews;
			
				//print_r($imageViews);
				
			}
			$ii++;
		}
	//print_r($passages);
	//printline();
		//$passages = record_sort($passages, "relationship");
		$passages = record_sort($passages, array("sortval","public-status","editdate"));
		//$passages = record_sort($passages, "sortval");
		//$passages = record_sort($passages, "name");
		
		$rubrics = array();
		$lastName= "";
		
		// sort group passages by name into rubrics
	//print_r($passages);
	//printline();
	
		
		foreach ($passages as $passage) {
			//$name = $passage["relationship"];
			$name = $passage["name"];
			
			$passage["descript"] = $passage["descript"];
			//println($name);
			if ( strtolower($name) != strtolower($lastName) ) {
				$rubrics[$name] = array();
			}
			$rubrics[$name][] = $passage;
			
			$lastName = $name;
		
		}
	//print_r($rubrics);
	//printline();
	

		
		$smarty->assign("rubrics", $rubrics);
	}

	
}







// ! DEFAULT SITE OR COLLECTION //

$site_id = $_REQUEST['site'];
if (! $site_id) {
	$site_id = $_REQUEST['collection'];
}
if (! $site_id) {
	$site_id = $_REQUEST['resource'];
}

if ($site_id == "")
{
	if (isset($collections))
	{
		$site_id = $collections[0]['id'];
		
	}
	else
	$site_id = 1;
}





if (is_numeric($site_id))
{
	$site = new Essay('ID', $site_id); 
	
	//print_r($site->attrs);
	//exit;	
	$building_rows = $site->getRelatedItems("Building", false);



	// for passing to javascript as a json string
	$building_json = $site->getRelatedItems("Building", true);
	//print_r($building_json); exit;
	
	$sql = 'SELECT * from essay where isSite=1 order by name';
	$site_rows = $db->queryAssoc($sql);
	
	if ($building_id && $building_id != "") {
		$i = 0;
		foreach($building_rows as $row) {
			if ($row['id'] == $building_id) {
				
				$selected = $i;
				
			}
			$i++;
		}
		
		
		
	}
}	



// FEATURE CATEGORIES
$feature_types = array();
$feature_types[] = "portal";
$feature_types[] = "lintel";
$feature_types[] = "pier";
$feature_types[] = "capital";
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

$rubric_sortvals = array_flip($rubrics_key);

/*
$sortval = 0;
$rubric_sortvals = array();
foreach($rubrics_key as $rubric_key) {
	logIt("setting rubric_sortvals for " . $rubric . ' to ' . $sortval);
	$rubric_sortvals[$rubric_key] = "_".$sortval++;
	
}
*/


// 2. -- ASSIGN DATA TO TEMPLATE ENGINE

$smarty->assign("pageTitle", $site->attrs->name);


if ($site->attrs['descript'] == "") {
	$filler = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";	
	$site->attrs['descript'] = $filler;
}

$smarty->assign("site", $site->getEncodedAttrs(), true);
//print_r($building_rows);
//exit;


if ($site->get("mapimage_id")) 
{
	$mapimage = new Image("ID", $site->get("mapimage_id")); //Istanbul map
	$smarty->assign("mapimage", $mapimage->getEncodedAttrs());
}


if ($site->get("landingimage_id"))
{
	$landingimage = new Image("ID", $site->get("landingimage_id")); // istanbul pano
	$smarty->assign("image", $landingimage->getEncodedAttrs());
}



$smarty->assign("buildings", $building_rows);






//print_r($rubrics);
//print_r($rubrics);
//exit;

$smarty->assign("alpha_buildings", record_sort($building_rows, "name"));
//$airports = record_sort($airports, "name");


$smarty->assign("buildings_json", $building_json);

$smarty->assign("sites", $site_rows);
if($selected > -1) {
	$smarty->assign("selected", $selected);

} else {
	$smarty->assign("selected", -1);
	
	
}


// RENDER
$smarty->display('Collection.tpl');


function record_sort($records, $orderby, $reverse=false)
{
    $hash = array();
    
    
   $i = 0;
    foreach($records as $record)
    {
    	logIt($field . " :: hash key = ". $record[$field]);
    	
    	if (is_array($orderby)) {
    		$key = "";
	    	foreach($orderby as $field) {
	    		$key .= $record[$field] . "_";
	    	}
	    	$hash[$key."_".$i++] = $record;
    	} else {
        	$hash[$record[$orderby].'_'.$record['editdate'].'_'.$record['id']."_".$i++] = $record;   	
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