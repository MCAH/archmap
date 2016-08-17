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




// 1. -- GET DB DATA //


$site_id = $_REQUEST['site'];
if (! $site_id) {
	$site_id = $_REQUEST['collection'];
}

$building_id = $_REQUEST['building_id'];

$catalog_type= $_REQUEST['type'];
if (! isset($catalog_type) || $catalog_type == "")
	$catalog_type = "lintel";
	
if (! $site_id || $site_id == "") {
	
	$site_id = 1;
}
$model = new Essay($site_id); 


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

	
	
	
	
	$publications = $tmp_building->getRelatedItems("Publication", false);
	$building_rows[$i]['publications'] = $publications;
	
	
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
	
	
	
	
	if ( "".$tmp_building->get("plan_image_id") != "" ) {
		$building_rows[$i]["planPlots"] = $tmp_building->getImagePlots( $tmp_building->get("plan_image_id") );
	}		

	//print_r($building_rows[$i]['features']);
	//println('<hr>');
	
	//print_r($building_rows[$i]);
	//exit;


}


	
// HAVE ALL THE DATA WE NEED!
	$building_rows = record_sort($building_rows, "name");
	
	//print_r($building_rows);
	//println('<hr>');
	//exit;


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
$smarty = new Smarty;


if ($model->attrs['descript'] == "") {
	$filler = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";	
	$model->attrs['descript'] = $filler;
}

$subtype = strtolower($catalog_type);

$smarty->assign("pageTitle", "Catalog of " . $subtype.'s');
$smarty->assign("node", $model->attrs, true);
//print_r($building_rows);
//exit;

$smarty->assign("buildings", $building_rows);

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
$smarty->display('Catalog.tpl');


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