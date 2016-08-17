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

$smarty = new Smarty;


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
$rubrics_key[] = "seismic notes";
$rubrics_key[] = "accretion of structure";


$rubric_sortvals = array_flip($rubrics_key);

// CHRONO
//$chronnor = array();

$chronnor["6th century"] 			= 1000;

$chronnor["11th century"] 			= 1050;

$chronnor["Early 11th century"] 	= 1025;
$chronnor["Mid 11th century"] 		= 1050;
$chronnor["Late 11th century"] 		= 1075;

$chronnor["12th century"] 			= 1150;
$chronnor["Early 12th century"] 	= 1125;
$chronnor["Mid 12th century"] 		= 1150;
$chronnor["Late 12th century"] 		= 1175;

$chronnor["13th century"] 			= 1250;
$chronnor["Early 13th century"] 	= 1225;
$chronnor["Mid 13th century"] 		= 1250;
$chronnor["Late 13th century"] 		= 1275;

$chronnor["14th century"] 			= 1350;
$chronnor["Early 14th century"] 	= 1325;
$chronnor["Mid 14th century"] 		= 1350;
$chronnor["Late 14th century"] 		= 1375;

$chronnor["15th century"] 			= 1450;
$chronnor["Early 15th century"] 	= 1425;
$chronnor["Mid 15th century"] 		= 1450;
$chronnor["Late 15th century"] 		= 1475;

$chronnor["16th century"] 			= 1650;






$buildings = array();
/*
$i = 0;
for($i=0; $i<sizeof($building_rows); $i++) {
print(($i+1)  .". ". $building_rows[$i]["name"].'<br>');
}

exit;
*/

$i = 0;


// SORT BY CHRONOS


for($i=0; $i<sizeof($building_rows); $i++) {
	$date_str = $building_rows[$i]["date"];
	
	
 	if ( $chronnor[$date_str] != ""  )
		$building_rows[$i]["chrono"] = $chronnor[$date_str];
	else if (strpos($date_str, "-") > 0)
		$building_rows[$i]["chrono"] = substr($date_str, 0, strpos($date_str, "-"));
	else
		$building_rows[$i]["chrono"] = $date_str;	
		
	
	//print('(' . $building_rows[$i]["chrono"] . ') ' . $building_rows[$i]["name"] . " - " . $building_rows[$i]["date"] . ' -- <br>');

}
$building_rows = record_sort($building_rows, "chrono");

if ($_REQUEST["dates"] != "")
{
	for($i=0; $i<sizeof($building_rows); $i++) {
		print('(' . $building_rows[$i]["chrono"] . ') ' . $building_rows[$i]["name"] . " - " . $building_rows[$i]["date"] . ' -- <br>');
	
	}
	exit;
}

for($i=0; $i<sizeof($building_rows); $i++) {
		
	//println($building_rows[i].name);
	
	$tmp_building = new Building($building_rows[$i]);
	
	$building_rows[$i]["name"] = $tmp_building->get("name");
	
	
	
	// ! PASSAGES
	$passages = $tmp_building->getRelatedItems('Passage', false);
	
	/*
	println("<hr>");
	println('<b>'.$tmp_building->get("name").'</b>');
	foreach($passages as $passage){
		println('<b>'.$passage["name"].'</b>');
		println($passage["descript"]);
		
	}
	//exit;
	*/
	
	if (isset($passages)) {
	
		// assign a sortval to each rubric, then sort passages by sortval, editdate


		$ii = 0;
		// 
		foreach ($passages as $passage) {
			
		
			
			$passages[$ii]["sortval"] = $rubric_sortvals[strtolower($passages[$ii]["name"])];
			
			
			$p = new Passage($passage);
			$imageViews = $p->getRelatedItems('ImageView', false);
			
			
			if ($imageViews) {
				$passages[$ii]["imageViews"] = $imageViews;
			
				//print_r($imageViews);
			
			//printline();
				
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
			
			if ($_REQUEST["feature"] != "")
			{
				if (strtolower($name) != strtolower($_REQUEST["feature"]))
					continue;
			}
			
			
			//$passage["descript"] = $passage["descript"];
			//println($name);
			if ( strtolower($name) != strtolower($lastName) ) {
				$rubrics[strtolower($name)] = array();
			}
			$rubrics[strtolower($name)][] = $passage;
			
			$lastName = strtolower($name);
		
		}
		
	//print_r($rubrics);
	//printline();
	
		// now sort the rubrics....
		
		//$sortval = 0;
		//$rubric_sortvals = array();
		
		$rubricsSorted = array();
		foreach($rubrics_key as $rubric_key) {
			if ($rubrics[$rubric_key])
				$rubricsSorted[] = $rubrics[$rubric_key];
			
			//logIt(" -------------- > > > > > setting rubric_sortvals for " . $rubric_key );
			
			//println($rubric_key);
			//$rubric_sortvals[$rubric_key] = "_".$sortval++;
			
			
			
		}
		
		//print_r($rubrics);
		//printline();
		
		logit("DONE WITH RUBRICS");
		$building_rows[$i]['rubrics'] = $rubricsSorted;
		
	
	
	
	}
	
	
	// PUBLICATIONS
	$publications = $tmp_building->getRelatedItems("Publication", false);
	//$building_rows[$i]['publications'] = $publications;
	
	
	
	
	
	
	
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
	//$building_rows = record_sort($building_rows, "name");
	
	//print_r($building_rows);
	//println('<hr>');
	//exit;




/*
$sortval = 0;
$rubric_sortvals = array();
foreach($rubrics_key as $rubric_key) {
	logIt("setting rubric_sortvals for " . $rubric . ' to ' . $sortval);
	$rubric_sortvals[$rubric_key] = "_".$sortval++;
	
}
*/


// 2. -- ASSIGN DATA TO TEMPLATE ENGINE



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
$smarty->display('CatalogBuildings.tpl');


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