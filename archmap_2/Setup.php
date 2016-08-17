<?php
	
	
	require_once  ('Database.php');

	require_once  ('Component.php');
	
	require_once  ('models/GenericRecord.php');


	require_once  ('models/Model.php');
	require_once  ('models/Building.php');
	require_once  ('models/BuildingModel.php');
	require_once  ('models/Person.php');
	require_once  ('models/HistoricalEvent.php');
	require_once  ('models/HistoricalObject.php');
	require_once  ('models/Publication.php');
	require_once  ('models/Collection.php');
	require_once  ('models/Essay.php');
	require_once  ('models/NoteCard.php');
	require_once  ('models/Passage.php');
	require_once  ('models/Image.php');
	require_once  ('models/ImageView.php');
	require_once  ('models/Place.php');
	require_once  ('models/Feature.php');
	




	//require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Model.php');	
	//require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Collection.php');	

	//ini_set('display_errors',1);
	//error_reporting(E_NOTICE);
	// UTILITIES
	
	// deprecated, but harmless, just an alias to Utilities::getSharedDBConnection


	
	function getEntity($entity_id) {
		switch ($entity_id) {
			case 10: return "Model"; break;	
			case 20: return "HistoricalEvent"; break;	
			case 25: return "HistoricalObject"; break;	
			case 30: return "Place"; break;	
			case 40: return "Building"; break;	
			case 50: return "Person"; break;	
			case 60: return "Publication"; break;	
			case 70: return "Collection"; break;	
			case 80: return "SocialEntity"; break;	
			case 90: return "LexiconEntry"; break;	
			case 100: return "Map"; break;	
			case 110: return "Image"; break;	
			case 120: return "ImageView"; break;	
			case 130: return "Note"; break;	
			case 140: return "NoteCard"; break;	
			case 150: return "Essay"; break;	
			case 160: return "Passage"; break;	
			case 170: return "Feature"; break;	
		
		
		}
	
	}
	function getEntityID($entity_id) {
		switch ($entity_id) {
			case "Model": 				return 10; break;	
			case "HistoricalEvent": 	return 20; break;	
			case "HistoricalObject": 	return 25; break;	
			case "Place": 				return 30; break;	
			case "Building": 			return 40; break;	
			case "Person": 				return 50; break;	
			case "Publication": 		return 60; break;	
			case "Collection": 			return 70; break;	
			case "SocialEntity": 		return 80; break;	
			case "LexiconEntry": 		return 90; break;	
			case "Map": 				return 100; break;	
			case "Image": 				return 110; break;	
			case "ImageView": 			return 120; break;	
			case "Note": 				return 130; break;	
			case "NoteCard": 			return 140; break;	
			case "Essay": 				return 150; break;	
			case "Passage": 			return 160; break;	
			case "Feature": 			return 170; break;	

		
		}
	
	}
	
	function getLexiconEntry($key) {
		
		// later get from db
		$db = Utilities::getSharedDBConnection();
		$sql = 'SELECT * FROM lexicon_entry WHERE name="'.$key.'"';
		$rows =  $db->queryAssoc($sql);
		return $rows[0];
		
	}

	
	function rightNow() {	
		date_default_timezone_set('America/New_York');
		return date("Y-m-d H:i:s");
	}
	function println ($line = 'Check ') {
		print '- ' . $line . ' <br />
		';
	}
	function printline ($line = 'OK') {
		print '# ' . $line . ' <br />
		';
		exit;
	}

	function getPost($key, $default = 0) {
		$keyvalue = $_GET[$key];
		if (! $keyvalue) 	$keyvalue = $_POST[$key];
		if (! $keyvalue) 	$keyvalue = $default;
		return $keyvalue;
	}
	
	function g_getmicrotime() {
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	} 
	
	function g_starttime() {
		global $bugBullet;
		$bugBullet .= ' _____ . ';
		return g_getmicrotime();
	}
	
	function g_endtime($starttime) {
		global $bugBullet;
		$bugBullet =  substr($bugBullet, 9);
		$time = g_getmicrotime();
		return substr($time-$starttime, 0,7);
	}
	
	function g_secondsSince($aDateTime) {
		if ($aDateTime) {
			return ( time() - strtotime($aDateTime) );
		} else {
			return 0;
		}
	}

	function generateRandomKey($length = 8) {
		// start with a blank password
		$randkey = "";
		// define possible characters
		$possible = "0123456789bcdfghjkmnpqrstvwxyzABCEDEFGHIJKLMNOPQRSTUVWXYZ"; 
		// set up a counter
		$i = 0;
		// add random characters to $randkey until $length is reached
		while ($i < $length) { 
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);   
			// we don't want this character if it's already in the password
			if (!strstr($randkey, $char)) { 
				$randkey .= $char;
				$i++;
			}
		}
		// done!
		return $randkey;
	}
	
	
	function guid(){
	    if (function_exists('com_create_guid')){
	        return com_create_guid();
	    } else {
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = substr($charid, 0, 8).$hyphen
	                .substr($charid, 8, 4).$hyphen
	                .substr($charid,12, 4).$hyphen
	                .substr($charid,16, 4).$hyphen
	                .substr($charid,20,12);
	        return $uuid;
	    }
	}
	
	function logIt($query, $duration = 0) {
						
			$filename = $_SERVER['DOCUMENT_ROOT'] . "/archmap_2/logging/logger8.txt";
			
			$logfile = fopen($filename,"a");
			
			if ($duration == 0) {
				$fp = fwrite($logfile, "       " . ' -- ' . $query . "\n");
			} else {
				$fp = fwrite($logfile, $duration . ' -- ' . $query . "\n");
			}			
			
			fclose($logfile);
	}


	//		static class with a bunch of nice static functions
	//	that won't gunk up the global namespace
	

	class Utilities {
		
		public static $sharedDB = null;
		public static $currentUser = null;
		public static $lastKnownUser = null;
		public static $allUsers = null;
		public static $anonymous = 428; // magic number
		
		//			a shared database connection, obviating the need
		//	to instantiate many many database connections 
		
		public static function getSharedDBConnection() {
			if(self::$sharedDB == null) {
				self::$sharedDB = new Database();
			}
			return self::$sharedDB;
		}
		
		
			// who is currently logged into the system?
			// If no one, the anonymous user will be logged in
		
		
		public static function getCurrentUser() {
			if(self::$currentUser == null) { // if we haven't yet defined the current user
				$sessionId = $_COOKIE["session_id"]; // grab the session cookie
				if($sessionId) {
					$person = new Person('SESSION_ID',$sessionId,false);
					if($person->isLoggedIn()) {
						self::$currentUser = $person; // yes, you are logged in
					}
					else { // you were logged in previously
						self::$currentUser = new Person(self::$anonymous,"",false); // anonymous
						self::$lastKnownUser = $person;
					}
				}
				else {
					self::$currentUser = new Person(self::$anonymous,"",false); // anonymous
				}
			}
			return self::$currentUser; // return whatever the result was
		}
		
		
		//	a list of anyone who is allowed to log into the system
		
		
		public static function listAvailableUsers() {
			if(self::$allUsers == null) {
				$db = self::getSharedDBConnection();
				self::$allUsers = $db->listAvailableUsers();
			}
			return self::$allUsers;
		}
		
	
		//	an expired session_id will record the user who last logged in here
		//	only works correctly in the currentUser is anonymous and someone
		//	has logged in before, otherwise returns null
		
		
		public static function getLastKnownUser() {
			if(self::$lastKnownUser == null) {
				return null;
			}
			return self::$lastKnownUser->get("id");
		}
		
		public static function sanitizeString($string) {
   	   if(strstr($string,"delete") || strstr($string,"insert")) {
   	      echo "bad input string!";
   	      exit();
   	   }
   	   return addslashes($string);
   	}
		
	}
	
	
?>