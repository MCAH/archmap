<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Model.php');

	/*
	 * HISTORICAL_EVENT
	 *
	 */
	 
	class Map extends Model {
	
		function Map($arg1=0, $arg2=0) {
			$this->table = "map";
			parent::GenericRecord($arg1, $arg2);
		}
		
		// deprecated
		function summarize() {
			$summary = array();
			$summary["id"] = $this->get("id");
			$summary["identifier"] = $this->get("identifier");
			$summary["name"] = $this->get("name");
			$summary["beg_year"] = $this->get("beg_year");
			$summary["end_year"] = $this->get("end_year");
			$summary["descript"] = $this->get("descript");
			$summary["xml"] = "/archmap/media/maps/".$this->get("identifier")."/tilemapresource.xml";
			$summary["shapes"] = $this->getShapeCollection();
			return array(get_class($this)=>$summary);
		}
		
		function getShapeCollection() {
			$query = "SELECT * FROM collection
				WHERE canonical = 1 AND parent_entity_id = 100 
				AND parent_item_id = ".$this->get("id");
			$rows = $this->db->queryAssoc($query);
			if($rows) {
				$collection = new Collection("ROW",$rows[0]);
			}
			else {
				$collection = new Collection();
				$collection->set("parent_entity_id",100);
				$collection->set("parent_item_id",$this->get("id"));
				$collection->set("canonical",1);
				$mapname = $this->get("name");
				$collection->set("name","Shapes in $mapname");
				$collection->saveChanges();
			}
			//return $collection->summarize();
			return $collection;
		}
		
		function shape_collection() {
			return $this->getShapeCollection();
		}
		
	}

?>