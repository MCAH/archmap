<?php
	
	 
	class Collection extends Model {
	
		var $buildings;
		var $members = null;
	
		function Collection($arg1=0, $arg2=0) {
			$this->table = "collection";
			parent::GenericRecord($arg1, $arg2);
		}
		
		// huh?
		
		function getBuildings() {
			if (! isset($this->buildings)) {
				$query = "	SELECT * 
					FROM collection_item ci, building b 
					WHERE ci.collection_id=".$this->get("id") .' 
					and ci.item_entity_id=40 
					and ci.item_id=b.id
					ORDER BY b.name;';
				$db = new Database();
				$rows = $db->queryAssoc($query);
				$this->buildings = array();
				foreach($rows as $row) {
					$this->buildings[] = new Building($row);
				}
			}
			return $this->buildings;
		}
		
		function getFirstBuilding() {
			$this->getBuildings();
			return $this->buildings[0];
		}
		
		// deprecated?
		
		function getCollectionItems() {
			$query = "SELECT * FROM collection_item WHERE collection_id = ".$this->get("id");
			$results = $this->db->queryAssoc($query);
			foreach($results as $key=>$item) {
				$results[$key]['reference'] = $this->db->getTypeReference($item['item_entity_id']);
				$ind_query = "SELECT id,name,descript,lat,lng,beg_year,end_year FROM ".$results[$key]['reference']."
					 WHERE id = ".$item['item_id'];
				$records = $this->db->queryAssoc($ind_query);
				$results[$key]['info'] = $records[0];
			}
			return $results;
		}
		
		// deprecated
		
		function getCollectionObjects() {
			$query = "SELECT * FROM collection_item WHERE collection_id = ".$this->get("id");
			$results = $this->db->queryAssoc($query);
			foreach($results as $key=>$item) {
				$model = Database::getReference($item["item_entity_id"]);
				$object = new $model($item['item_id']);
				$results[$key] = $object->summarize();
			}
			return $results;
		}
		
		// deprecated
		
		function getCollectionObjectsAsItems() {
			$query = "SELECT * FROM collection_item WHERE collection_id = ".$this->get("id")." ORDER BY sortval";
			$results = $this->db->queryAssoc($query);
			foreach($results as $key=>$item) {
				$citem = new CollectionItem($item["id"]);
				$results[$key] = $citem->summarize();
			}
			return $results;
		}
		
		// this is the good one right here
		
		function getVanillaCollectionItems() {
			if($this->members == null) {
				// we calculated and cache the members
				$query = "SELECT * FROM collection_item WHERE collection_id = ".$this->get("id")." ORDER BY sortval";
				$results = $this->db->queryAssoc($query);
				foreach($results as $key=>$item) {
					$results[$key] = new CollectionItem($item["id"]);
				}
				$this->members = $results;
			}
			return $this->members;
		}
		
		function members() {
			return $this->getVanillaCollectionItems();
		}
		
		
		
		/* RORY */
		
		function getSubCollectionsByStaticType($staticType, $asJSON = false) {
			// for example, if you want all of the Bibliographies in this collection use $staticType = "Publication"
			$query = 'SELECT c.* FROM collection_item ci, collection c WHERE ci.collection_id = '.$this->get("id").' AND ci.item_entity_id=70 AND ci.item_id=c.id AND statictype="'.$staticType.'" ORDER BY sortval';
			$rows = $this->db->queryAssoc($query);
			
			if ($asJSON) {
				return json_encode($rows);
			} else {
				foreach($rows as $row) {
					$collections[] = new Collection($row);
				}
				return $collections;
			}
			
		
		}
		
		
		/* RORY */
		
		
		
		// I think Rory wrote this?
		/*
		function getAuthor() {
			$author_id = $this->get("author_id");
			if($author_id) {
				$db = new Database();
				$query = "SELECT id,name FROM person WHERE id = $author_id";
				$result = $db->queryAssoc($query);
				return $result[0];
			}
			else {
				return false;
			}
		}
		*/
		
		/* alias to the single-serving add function */
		
		function addModel($model) {
		  return $this->add($model->get("id"),get_class($model));
		}
		
		/* single-serving add function */
		
		function add($item_id,$item_entity_id,$checkInverse = true) {
		   // TODO enforce static type
			if(!is_numeric($item_entity_id)) {
				$item_entity_id = Database::getNumForHuman($item_entity_id);
			}
			$this->clearDuplicateItems($item_id,$item_entity_id);
			$item = new CollectionItem();
			$item->set("collection_id",$this->get("id"));
			$item->set("item_id",$item_id);
			$item->set("item_entity_id",$item_entity_id);
			$item->saveChanges();
			// now the item is saved to its collection -- but we want some many-to-many action here
			if($checkInverse === true && $this->get("statictype") && $this->get("inverse")) {
			   $obj = $item->getObject(); // the object itself
			   $parent = $this->db->getModelFromNumbers(
			      $this->get("parent_entity_id"), $this->get("parent_item_id")
			   );
			   $inverseColl = $obj->get($this->get("inverse"));
			   $inverseColl->add($parent->get("id"),get_class($parent),false); // don't hit me back
			}
			// anyway, just return the darn thing!
			return $item;
		}
		
		function clearDuplicateItems($item_id,$item_entity_id) {
			$c_id = $this->get("id");
			$query = "SELECT * FROM collection_item
				WHERE collection_id = $c_id AND item_id = $item_id
				AND item_entity_id = $item_entity_id";
			$rows = $this->db->queryAssoc($query);
			foreach($rows as $row) {
				$item = new CollectionItem("ROW",$row);
				$item->delete();
			}
			return $rows; // foreach, delete
		}
		
		// deprecated
		
		function summarize() {
			// start and end should be calculated... should I do that now?
			$items = $this->getCollectionObjectsAsItems();
			$summary = array();
			$summary["attributes"] = array(
				"id"=>$this->get("id"),
				"name"=>$this->get("name"),
				"beg_year"=>$this->get("beg_year"),
				"end_year"=>$this->get("end_year"),
				"parent"=>$this->db->getTypeReference(
					$this->get("parent_entity_id"))."/".$this->get("parent_item_id")
			);
			$summary["descript"] = $this->get("descript");
			$summary["members"] = $items;
			return array(get_class($this)=>$summary);
		}
		
		function extend_shortlist() {
			return array(
				"parent" => $this->db->getTypeReference(
					$this->get("parent_entity_id"))."/".$this->get("parent_item_id"),
				"members" => $this->get("members")
			);
		}
		
		function uri() {
			return strtolower($this->get("type"))."/".$this->get("id");
		}
		
		function get($field) {
			if($field == "members") {
				return $this->getVanillaCollectionItems();
			}
			return parent::get($field);
		}
		
		function addItems_ByClassAndId($items_ListedByClassAndId) {
			$items = explode( ";", $items_ListedByClassAndId);
			$db = new Database();
			if ($items) {
				foreach($items as $item) {
					$item_parts = explode(",", $item);
					$item_class = $item_parts[0];
					$item_id 	= $item_parts[1];
					
					$item_entity_id = $this->getEntity_id_ByClassname($item_class);
					
					if (! $item_entity_id  || ! is_numeric($item_entity_id) ) {
						print("Collection::addItems_ByClassAndId - NO ENTITY ID");
						return;
					}
					
					if ($item_id && is_numeric($item_id)) {
						$q = 'select * from collection_item where collection_id='.$this->get("id").' and item_entity_id='.$item_entity_id.' and item_id='.$item_id;
						$rows = $db->queryAssoc($q);
						if (! $rows || $rows == "") {
							$item_entity_id = $this->getEntity_id_ByClassname($item_class);
							if (isset($item_entity_id)) {
								$q = 'INSERT INTO collection_item (collection_id, item_entity_id, item_id) VALUES ('.$this->get("id").', '.$item_entity_id.', '.$item_id.')';
								$db->submit($q);
							}
						}
					}		
				}
			}
			$q = 'SELECT count(*) FROM collection_item where collection_id='.$this->get("id");
			return $db->count($q);
		}
		
		function deleteItems_ByClassAndId($itemsToDelete_ListedByClassAndId) {
			$items = explode( ";", $itemsToDelete_ListedByClassAndId);
			$db = new Database();
			if ($items) {
				foreach($items as $item) {
					$item_parts = explode(",", $item);
					$item_class = $item_parts[0];
					$item_id 	= $item_parts[1];
					$item_entity_id = $this->getEntity_id_ByClassname($item_class);
					if (! $item_entity_id  || ! is_numeric($item_entity_id) ) {
						print("Collection::deleteItems_ByClassAndId - NO ENTITY ID");
						return;
					}
					if ($item_id && is_numeric($item_id)) {
						if ($toDeleteClause != "") 
							$toDeleteClause .= " OR ";
						$toDeleteClause .= ' (item_entity_id="'.$item_entity_id .'" AND item_id="'.$item_id.'") ';
					}
				}
			}
			if ($toDeleteClause && $toDeleteClause != "") {
				if ($this->get("id") && is_numeric($this->get("id"))) {
					$q = 'DELETE FROM collection_item where collection_id='.$this->get("id").' and ('.$toDeleteClause.')';
					$db->submit($q);
				}
			}
			$q = 'SELECT count(*) FROM collection_item where collection_id='.$this->get("id");
			return $db->count($q);	
		}
	
	} // end of the class



?>