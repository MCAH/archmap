<?php
error_reporting(E_ERROR | E_PARSE);

// set path to Smarty directory *nix style
define('SMARTY_DIR', $_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Smarty/libs/');

require(SMARTY_DIR . '/Smarty.class.php');


// BASED ON THE REDIRECT_URL, FIGURE OUT LANDING PAGE!
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');

$db = Utilities::getSharedDBConnection();	

//println




// 1. -- GET DB DATA //

$node = new Essay(1); 

$id = $_REQUEST['id'];
if (! $id || $id == "") {
	$id = 3287; // Mainstone
}
$pub = new Publication($id); 


// for dom rendering inphp and smarty
$building_rows = $pub->getRelatedItems("Building", false);

// for passing to javascript as a json string
$building_json = $pub->getRelatedItems("Building", true);


// 2. -- ASSIGN DATA TO TEMPLATE ENGINE
$smarty = new Smarty;

$smarty->assign("node", $node->attrs);
$smarty->assign("pub", $pub->attrs);

$smarty->assign("buildings", record_sort($building_rows, "name"));


$smarty->assign("buildings_json", $building_json);


// RENDER
$smarty->display('Publication.tpl');









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