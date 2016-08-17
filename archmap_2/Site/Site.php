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


$project_types[] = "Faculty";
$project_types[] = "Dissertation";
$project_types[] = "Graduate Travel Fellowships";
$project_typesSortvals = array_flip($feature_types);




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



// 1. -- GET DB DATA //

$resource = $_REQUEST['resource'];
if (! $resource) {
	$resource = $_REQUEST['collection'];
}

$building_id = $_REQUEST['building_id'];


$data = $_REQUEST["data"];
//printline($data);

$dataparts = explode("/", $data);


$urlalias 	= $dataparts[0];
$page 		= $dataparts[1];

if ($page == "") $page = "landing";

if ($data && $data != "")
{
	
	$site = new Essay('URLALIAS', $urlalias); 

} else {
	
	// site is archmap homepage
	$site = new Essay(1); 

}





if($page == "map")
{

	
	// for dom rendering inphp and smarty
	$building_rows = $site->getRelatedItems("Building", false);
	$feature_rows = $site->getRelatedItems("Feature", false);
	//println("YUBBA");
	//print_r($building_rows);
	//printline(" ");
	
	// for passing to javascript as a json string
	$building_json 	= $site->getRelatedItems("Building", true);
	
	$overlays_json 	= $site->getRelatedItems("Image", true, "map");
	//print_r($overlays_json);
	//exit;
	
	$feature_json 	= $site->getRelatedItems("Feature", true);
	//print_r($feature_json); exit;
	
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

if ($site->get('id') == 1) {
$sql = 'SELECT * from essay where public_status>3 order by name asc';
$site_rows = $db->queryAssoc($sql);
}



$building = new Building($building_id);
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



$smarty->assign("pageTitle", $site->attrs->name);



if ($site->attrs['descript'] == "") {
	$filler = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";	
	$site->attrs['descript'] = $filler;
}


$siteattrs = $site->getEncodedAttrs();

$siteattrs['latc'] = $siteattrs['lat'] + (($siteattrs['lat2']-$siteattrs['lat1'])/2);
$siteattrs['lngc'] = $siteattrs['lng'] + (($siteattrs['lng2']-$siteattrs['lng1'])/2);


$smarty->assign("site", $siteattrs, true);



//print_r($building_rows);
//exit;




$smarty->assign("urlalias", $site->get('urlalias'));



$author = $site->getAuthor();
$smarty->assign("author", $author->getEncodedAttrs());


if ($site->get("mapimage_id")) 
{
	$mapimage = new Image("ID", $site->get("mapimage_id")); //Istanbul map
	$mapimageAttrs = $mapimage->getEncodedAttrs();

	
	$map_buildings =  $mapimage->getRelatedItems('Building', false, "plot");
	$map_buildings = record_sort($map_buildings, "name");
	$mapimageAttrs['buildings'] = $map_buildings;



	$map_features =  $mapimage->getRelatedItems('Feature', false, "plot");
	$map_features = record_sort($map_features, "name");	
	$mapimageAttrs['features'] = $map_features;
	
	//print_r($mapimageAttrs);
	//exit;	
	$smarty->assign("mapimage", $mapimageAttrs);

}


if ($site->get("landingimage_id"))
{
	$landingimage = new Image("ID", $site->get("landingimage_id")); // istanbul pano
	$smarty->assign("image", $landingimage->getEncodedAttrs());
}
 
 
$smarty->assign("page", $page);
if($page == "map") {
	
	if(isset($mapimage))  {
		$smarty->assign("mainimage", $mapimage->getEncodedAttrs());
	}
	

	
} else if (isset($landingimage)) {
	$smarty->assign("mainimage", $landingimage->getEncodedAttrs());
	
}


if ($building_rows)
	$smarty->assign("buildings", $building_rows);

if ($feature_rows)
	$smarty->assign("features", $feature_rows);






if (isset($building) && $building->get('id')) {

	// ASSIGN BUILDING
	$attrs = $building->getEncodedAttrs();
	$attrs['plan_url300'] 	= $building->floorplanURL(300);
	$smarty->assign("selectedBuilding", $attrs);
	



	$features = $building->getRelatedItems('Feature', false);
	
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
	$publications = $building->getRelatedItems('Publication', false);
	foreach ($publications as $publication) {
		$publication['contributors'] = utf8_decode(stripslashes($publication['contributors']));
	}

	$smarty->assign("publications", $publications);






	// PASSAGES
	$passages = $building->getRelatedItems('Passage', false);
	
	
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
	//printline();
		//$passages = record_sort($passages, "relationship");
		$passages = record_sort($passages, array("sortval","public-status","editdate"));
		//$passages = record_sort($passages, "sortval");
		//$passages = record_sort($passages, "name");
		
		$rubrics = array();
		$lastName= "";
		
		// sort group passages by name into rubrics
		foreach ($passages as $passage) {
			//$name = $passage["relationship"];
			$name = $passage["name"];
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
//print_r($rubrics);
//print_r($rubrics);
//exit;

if ($building_rows)
	$smarty->assign("alpha_buildings", record_sort($building_rows, "name"));
//$airports = record_sort($airports, "name");





$smarty->assign("buildings_json", $building_json);
$smarty->assign("features_json", $feature_json);
$smarty->assign("overlays_json", $overlays_json);

// Overlay Image

$smarty->assign("sites", $site_rows);

if($selected > -1) {
	$smarty->assign("selected", $selected);

} else {
	$smarty->assign("selected", -1);
	
	
}


// RENDER
$smarty->display('Site.tpl');


function record_sort($records, $orderby, $reverse=false)
{
    $hash = array();
    
    
   
    foreach($records as $record)
    {
    	//logIt($field . " :: hash key = ". $record[$field]);
    	
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