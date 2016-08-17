<?php
	

	/*
	 * PERSON
	 *
	 */
	 
	class Person extends Model {
	
	
		function Person($arg1=0, $arg2=0, $record = true) {
			
			$this->table = "person";
	
			if ($arg1 == "SESSION_ID" && is_string($arg2)) {
				$this->db 	= new Database();				
				$query 	= 'SELECT * FROM '.$this->tableName().' WHERE session_id="'.$arg2.'"';
				$result = $this->db->queryAssoc($query);
				if (isset($result)){
					$this->initFromAssocRow($result[0]);
					return;
				}
			}
			
			parent::GenericRecord($arg1, $arg2, $record);
		}
		
		function tableName() {
			return "person";
		}
		function entityName() {
			return "Person";
		}

	
		function deriveNameFromDB_Name() {
			// of the form:
			//		Frankl, Paul K.
			$db_name = $this->get("db_name");
			
			println("deriving name from ..... ".$db_name);

			if ($db_name != "") {
				$parts = explode(",", $db_name);
				println("lastname: ". $parts[0]);
				$this->set("lastname", $parts[0]);
				println("lastname: ". $this->get("lastname"));
				if ($parts[1] != "") {
					$subparts = explode(" ", trim($parts[1]));
					$this->set("firstname", $subparts[0]);
					$this->set("middlename", $subparts[1]);
				}
			}
		}
		
		function shortAlias() {
			$firstname = strtolower($this->get("firstname"));
			$lastname = strtolower($this->get("lastname"));
			return $firstname.".".$lastname;
		}
		
		function makeFullname() {
			return 	$this->get("honorific")." ".
						$this->get("firstname")." ".
						$this->get("middlename")." ".
						$this->get("lastname")." ".
						$this->get("postname");
		}
		
		function setDefaultValuesForAttrs() 
		{
			parent::setDefaultValuesForAttrs();
			
		}
		
		
		
		
		
		/* RORY */
		
		function getRootItemsByClass($className, $asJSON = true) {
			
			if ($className == "Image") {
				$sql = "SELECT * FROM Image WHERE author_id=" . $this->get("id") . ' ORDER BY createdate DESC LIMIT 0, 50';
			
			} else {
				$sql = 'SELECT * FROM '.$className.' WHERE parent_entity_id=50 AND parent_item_id=' . $this->get("id");

			}
			$rows = $this->db->queryAssoc($sql);
		
			if ($asJSON) {
				return json_encode($rows);
			} else {
				foreach($rows as $row) {
					$items[] = new Essay($row);
				}
				return $items;
			}
		}
		
		
		function getCanonicalCollectionsRoot($canonicalType) {
			if (isset($canonicalType)) {
				
				$KEYS[name] 			= "DEFAULT:".$canonicalType;
				$KEYS[parent_entity_id] = 50;
				$KEYS[parent_item_id] 	= $this->get("id");
				switch ($canonicalType) {
					case "my_collections": 
						$KEYS[statictype] 		= "Collection";
						break;
					case "authored_books": 
					case "edited_books":
						$KEYS[statictype] 		= "Publication";
						break;
					case "images":
						$KEYS[statictype] 		= "Image";
						break;
				
				}
				$KEYS[canonical] 		= 1;
				
				
				$collection = new Collection("KEYS", $KEYS);
				
				// STILL NEED TO TEST IF THIS WORKS...
				$collection->saveChangesIfNew();
				
				return $collection;
			}

		}
		
		function getMyCollectionsByStaticType($staticType, $asJSON = false) {
			$collection = $this->getCanonicalCollectionsRoot("my_collections") ;
						
			$collections = $collection->getSubCollectionsByStaticType("Publication", $asJSON);
			
			return $collections;

		}
		
		
		
		/* RORY */
		
		
		
		
		
		
		
		
		
		/*----- BEG: USER AUTHENTICATION FUNCTIONS -----*/

	
		function login($pword) {
		
		
			if(is_string($pword)) {
				
				$actual_pword = $this->get("pword");
				$attempt_pword = sha1($pword);
								
				if($actual_pword === $attempt_pword) {
					$session_id = generateRandomKey(50);
					$this->set("session_id",$session_id);
					$this->set("lastTickled",rightNow());
					$this->set("isLoggedIn",1);
					$this->saveChanges();
					return $session_id;
				}
				else {
					//$this->logout();
					return null; // no good password
				}
			}
			else {
				return null; // no password provided
			}
		}
		
		function logout() {
			$this->set("isLoggedIn",0);
			$this->saveChanges();
			return true;
		}
		
		function isLoggedIn() {
			// if isLoggedIn && lastTickled is not too old return true
			
			if($this->get("isLoggedIn")) {
			
				$lastTickled = $this->get("lastTickled");
				$age = g_secondsSince( $lastTickled );
				if(is_numeric($age) && $age < 3600) {
					$this->tickle();
					return true;
				}
				else {
					$this->logout();
					return false;
				}
			}
			else {
				
				return false;
			}
		}
		
		function tickle() {
			$this->set("lastTickled",rightNow());
			$this->saveChanges();
		}
		
		function changePassword($old_password,$new_password) {
			if(isset($old_password,$new_password)) {
				if(sha1($old_password) == $this->get("pword")) {
					$this->set("pword",sha1($new_password));
					$this->saveChanges();
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		
		function isAnonymous() {
			if($this->get("id") == Utilities::$anonymous) {
				return true;
			}
			else {
				return false;
			}
		}
		
		function isGoodAt($auth_level) {
		    return $this->get("isUser") >= $auth_level;
		}
	
		/*----- END: USER AUTHENTICATION FUNCTIONS -----*/
		
		// wicked deprecated, but I think the dev site still uses this
		function getEditableAttributes() {
			$attributes = array(
				"Firstname" => array("field" => "firstname"),
				"Middlename" => array("field" => "middlename"),
				"Lastname" => array("field" => "lastname"),
				"Birthyear" => array("field" => "beg_year"),
				"Deathyear" => array("field" => "end_year") );
			parent::setEditableAttributes($attributes);
			return parent::getEditableAttributes();
		}
		
		/* Get the user's default collection (their memory)
			if it doesn't exist, make it! */
		
		function getUserMemory() {
			if($this->get("isUser") >= 2) {
				$pid = $this->get("id");
				$query = "SELECT * FROM collection WHERE canonical = 1 AND author_id = $pid";
				$rows = $this->db->queryAssoc($query);
				if($rows) {
					$collection = new Collection("ROW",$rows[0]);
				}
				else {
					$collection = new Collection();
					$collection->set("author_id",$pid);
					$collection->set("canonical",1);
					$collection->set("private",1);
					$firstname = $this->get("firstname");
					$collection->set("name","$firstname's Memory");
					$collection->saveChanges();
				}
				return $collection->summarize(); // can I break this?
			}
			else {
				return false;
			}
		}
		
		/* ----------------------------- */
		
		// deprecated
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"id"=>$this->get("id"),
				"name"=>$this->get("name"),
				"firstname"=>$this->get("firstname"),
				"lastname"=>$this->get("lastname"),
				"beg_year"=>$this->get("beg_year"),
				"end_year"=>$this->get("end_year"),
				"lat"=>$this->get("lat"),
				"lng"=>$this->get("lng"),
				"isUser"=>$this->get("isUser"),
				"wikipedia"=>$this->get("wikipedia")
			);
			$summary["descript"] = $this->get("descript");
			
			return array(get_class($this)=>$summary);
		}
		
		function getLatLng() {
			$coords = array();
			$coords['lat'] = $this->get('lat');
			$coords['lng'] = $this->get('lng');
			return $coords;
		}
		
		
		function getSearchKey() {
			$sk = $this->get("search_key");
			if ($sk && $sk != "") 
				//return $sk;
				
			return makeSearchKey();	
		}
		
		function tester()
		{
			print("<br />...TESTING...<br />");
		}
		
		function makeSearchKey() {
			$sk = $this->get("lastname");
			if ($sk && $sk != "") {
				if ($this->get("firstname")) {
					$sk .= ', ' . $this->get("firstname");
					
					if ($this->get("middlename")) {
						$sk .= ' ' . $this->get("middlename");
					}
					
				}
				return $sk;	
			}
				
			$sk = $this->get("firstname");
			if ($sk && $sk != "") {
				if ($this->get("postname")) {
					$sk .= ' ' . $this->get("postname");
				}
				return $sk;	
			}
				
			
			$sk = $this->get("postname");
			if ($sk && $sk != "") 
				return $sk;	
						
		}
		
		function makeAuthor() {
			$this->set("isAuthor", true);
		}
	}



?>