<?php
	
	// so model classes are autoloaded rather than explicitly-loaded
	
	function __autoload($class) {
		//require_once($_SERVER['DOCUMENT_ROOT']."/archmap_codebase/models/$class.php");
	}
	
	class Database {
		
		var $host;
		var $db;
		var $user;
		var $dbaseLink;
	
		function Database($domain="127.0.0.1", $db="archmap", $user="", $pass="") {
			if ( $_SERVER['HTTP_HOST'] == '127.0.0.1') {
				//$domain = '127.0.0.1';
			}
			$this->host = $domain;
			$this->db = $db;
			$this->user = $user;
			$this->dbaseLink = mysql_connect($this->host, $this->user, $pass, true);

			mysql_query("SET character_set_results=utf8", $this->dbaseLink);
			mb_language('uni'); 
			mb_internal_encoding('UTF-8');			

			mysql_query("SET NAMES 'utf8'", $this->dbaseLink);
			
			mysql_select_db($this->db, $this->dbaseLink);
		}
	
		function queryAssoc ($query) {
			mysql_select_db($this->db, $this->dbaseLink);
			$result = mysql_query($query, $this->dbaseLink) or die ('invalid query: ++' . $query . '++<BR>');;
		
			if ($result) {
				$i = 0;
				while ($tmp_row = mysql_fetch_assoc($result)) {
					$rows[$i++] = $tmp_row;
				}		
				mysql_free_result($result); 		
			}
			return $rows;
		}
		
		// DB_QUERY
		function query ($query, $db_name = 0) {
		
			mysql_select_db($this->db, $this->dbaseLink);
			
			$result = mysql_query($query, $this->dbaseLink) or die ('invalid query: ++' . $query . '++<BR>');;
			if ($result) {
				$i = 0;
				while ($tmp_row = mysql_fetch_row($result)) {
					$rows[$i++] = $tmp_row;
				}		
				mysql_free_result($result); 		
			}
			return $rows;
		}
		
		// DB_QUERY
		function count ($query, $db_name = 0) {
			mysql_select_db($this->db, $this->dbaseLink);	
			$count = mysql_result( mysql_query($query, $this->dbaseLink), 0 );	
			return $count;
		}
		
		// DB_SUBMIT -- AlIAS
		function submit ($query, $db_name = 0) {
			mysql_select_db($this->db, $this->dbaseLink);		
			mysql_query($query, $this->dbaseLink) or die ('invalid query: ++' . $query . '++<BR>');;
		}
		
		function close() {
			mysql_close($this->dbaseLink);
		}
		
		function getModelFromNumbers($item_entity_id,$item_id) {
		   $class = $this->getReference($item_entity_id);
		   return new $class("ID",$item_id);
		}
		
		function getModelFromKey($key) {
			$foreaft = explode("/",$key);
			$id = $foreaft[1];
			$class = $this->getReference($this->getNumForHuman($foreaft[0]));
			return new $class("ID",$id);
		}
		
		/*
		function getReference($type) {
			if(!$type) {
			  return false;
			}
			if($this->db != "archmap") {
			  $db = $this->db;
			}
			else {
			  $db = $this;
			}
			$rows = $db->queryAssoc("SELECT * FROM entity_ids WHERE id = $type");
			return $rows[0]["classname"];
		}
		
		function getTypeReference($type) {
			if(!$type) {
			  return false;
			}
			if($this->db != "archmap") {
			  $db = $this->db;
			}
			else {
			  $db = $this;
			}
			$rows = $db->queryAssoc("SELECT * FROM entity_ids WHERE id = $type");
			return $rows[0]["table_name"];
		}
		
		function getNumForHuman($name) {
			if(!$name) {
			  return false;
			}
			if($this->db != "archmap") {
			  $db = $this->db;
			}
			else {
			  $db = $this;
			}
			$rows = $db->queryAssoc("SELECT * FROM entity_ids WHERE classname LIKE '$name'");
			return $rows[0]["id"];
		}
		*/
		
		function getReference($type) {
			$references = array(
				20=>"HistoricalEvent",
				30=>"Place",
				40=>"Building",
				50=>"Person",
				60=>"Publication",
				70=>"Collection",
				80=>"LexiconEntry",
				90=>"SocialEntity",
				100=>"Map",
				110=>"Image",
				130=>"Note",
			);
			return $references[$type];
		}
		
		function getTypeReference($type_number) {
			$type_reference = array(20=>"historicalevent",30=>"place",100=>"map",110=>"image",
				130=>"note",
				40=>"building", 50=>"person",60=>"publication",70=>"collection",80=>"lexicon_entry");
			return $type_reference[$type_number];
		}
		
		function getNumForHuman($name) {
			$references = array(
				"historicalevent"=>20,
				"place"=>30,
				"building"=>40,
				"person"=>50,
				"publication"=>60,
				"collection"=>70,
				"lexiconentry"=>80,
				"socialentity"=>90,
				"map"=>100,
				"image"=>110,
				"note"=>130
			);
			return $references[strtolower($name)];
		}
		
		/* returns an array id=>name of anyone who can login */
		
		function listAvailableUsers() {
			$users = array(); // where we will put their names
			foreach($this->queryAssoc("select * from person where isUser > 1") as $row) {
				$users[$row["id"]] = $row["name"];
			}
			return $users;
		}
	}
	
?>