<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/archmap/codebase/Database.php');

	class Catalog extends Model {
	
		var $db;
		var $term;
		var $members = null;
	
		function Catalog($mode,$model,$params = null) {
			$this->classname = $model;
			$this->db = new Database();
			switch($model) {
				case "building":
					$this->db_query = "SELECT * FROM building WHERE style = 11 ORDER BY name";
					break;
				case "wellknowns":
					$this->db_query = "SELECT b.*
						FROM building b, image i WHERE b.style = 11 AND i.building_id = b.id
						AND b.id != 1197
						GROUP BY b.id HAVING COUNT(*) > 20";
					$this->classname = "Building";
					break;
				case "stereos":
				  $this->classname = "Image";
				  $this->db_query = "SELECT * FROM image WHERE has_stereo = 1";
				  break;
				case "place":
					$this->db_query = "SELECT * FROM place WHERE id > 1000 ORDER BY name";
					break;
				case "lexiconentry":
					$this->db_query = "SELECT * FROM lexicon_entry ORDER BY name";
					break;
				case "keywords":
				    $this->db_query = "SELECT * FROM lexicon_entry WHERE isKeyword=1 ORDER BY name";
				    $this->classname = "LexiconEntry";
				    break;
				case "types":
				    $this->db_query = "SELECT * FROM image_types ORDER BY name";
				    $this->classname = "ImageType";
				    break;
				case "node":
					$this->db_query = "SELECT * FROM image WHERE image_type = 'node'";
					break;
				case "person":
					$this->db_query = "SELECT * FROM person ORDER BY name";
					break;
				case "publication":
					$this->db_query = "SELECT * FROM publication WHERE pubtype != 1000 
						AND pubtype != 255 ORDER BY name";
					break;
				case "users":
					$this->db_query = "SELECT * FROM person WHERE isUser > 1";
					$this->classname = "Person";
					break;
				case "collection":
					$this->db_query = "SELECT * FROM collection";
					break;
				default:
					$this->db_query = "SELECT * FROM $model";
			}
		}
		
		function add_filter($params) {
			$filter = "";
			// do them in order
			if($params["count"]) {
				$filter .= " LIMIT ".$params["count"];
				if($params["start"]) // can only do this if you specify limit as well
					$filter .= " OFFSET ".$params["start"];
			}
			$this->db_query .= $filter;
		}
		
		function just_yours($id) {
			if(strstr($this->db_query,"WHERE")) {
				$this->db_query .= " AND author_id = $id";
			}
			else {
				$this->db_query .= " WHERE author_id = $id";
			}
		}
		
		/* fake the model, but fake it well */
		// generate answers to certain keys
		
		function get($key) {
			switch($key) {
				case "name": return $this->classname;
				case "id": return $this->classname;
				case "count": return $this->total;
				default: return true;
			}
		}
		
		function populate() {
			$members = $this->db->queryAssoc($this->db_query);
			$this->total = 0;
			foreach($members as $i=>$value) {
				$class = $this->classname;
				$obj = new $class("ROW",$value);
				$members[$i] = $obj->summarize();
				$this->total += 1;
			}
			return $members;
		}
		
		function members() {
			if($this->members == null) {
				$members = $this->db->queryAssoc($this->db_query);
				$class = $this->classname;
				foreach($members as $i=>$value) {
					$members[$i] = new $class("ROW",$value);
				}
				$this->members = $members;
			}
			return $this->members;
		}
		
		// deprecated
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"name" => "Catalog of ".$this->classname,
				"count" => $this->total,
				"id" => $this->classname
			);
			$summary["members"] = self::members();
			return array(get_class($this)=>$summary);
		}
		
		function extend_shortlist() {
			return array(
				"members" => self::members()
			);
		}
		
		//function extend_shortlist() {
			//return array("members",self::members());
		//}
		
		function browse($params) {
			$report = array();
			// lighten up the query
			if(isset($params["columns"])) {
				$this->db_query = str_replace("SELECT *","SELECT ".$params["columns"],$this->db_query);
			}
			else {
				$this->db_query = str_replace("SELECT *","SELECT id,name",$this->db_query);
			}
			$report["name"] = "Quick List of ".$this->classname;
			$report["members"] = $this->db->queryAssoc($this->db_query);
			//return array(get_class($this)=>$report);
			return $report;
		}
		
		//function __toString() {
		//	return "Catalog entry for '".$this->classname."'";
		//}
	
	}

?>