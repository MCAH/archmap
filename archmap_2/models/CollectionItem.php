<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	/*
	 * A collection item
	 *
	 */
	 
	// TODO -- add a author id for each collection item?
	
	class CollectionItem extends Model {
	
		var $table = "collection_item";
		var $item = null;
		var $primaryKey = "id";
	
		function CollectionItem($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
		
		function delete() {
			$confirmedID = $this->get("id");
			if($confirmedID && is_numeric($confirmedID) && $confirmedID > 0) {
				$item_entity_id = $this->get("item_entity_id");
				$item_id = $this->get("item_id");
				$command = 'DELETE FROM collection_item WHERE id='.$confirmedID;
				$this->db->submit($command);
				// now delete its inverse counterpart if it exists
				$parentlist = new Collection("ID",$this->get("collection_id"));
				$inverse_name = $parentlist->get("inverse");
				if($inverse_name) {
				   $model = $this->db->getModelFromNumbers($item_entity_id,$item_id);
				   $collection = $model->get($inverse_name);
				   $collection->clearDuplicateItems(
				      $parentlist->get("parent_item_id"),$parentlist->get("parent_entity_id")
				   );
				}
				return true;
			}
			else return false;
		}
		
		function getObject() {
			if($this->item == null) {
				$classname = Database::getReference($this->get("item_entity_id"));
				$this->item = new $classname($this->get("item_id"));
			}
			return $this->item;
		}
		
		function getLink() {
			return $this->getObject()->getLink();
		}
		
		// inspired by the javascript
		// make the collectionitem transparent to the child
		
		function get($key) {
			$attempt = parent::get($key);
			if($attempt) { // if the collectionitem has that specific field, get it
				return $attempt;
			}
			else { // if not, get it from the kid
				return $this->getObject()->get($key);
			}
		}
		
		function uri() {
			return $this->getObject()->uri();
		}
		
		// deprecated
		/*
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"id" => $this->get("id"),
				"color" => $this->get("color"),
				"icon_shape" => $this->get("icon_shape"),
				"beg_year" => $this->get("beg_year"),
				"end_year" => $this->get("end_year")
			);
			$classname = Database::getReference($this->get("item_entity_id"));
			$item = new $classname($this->get("item_id"));
			$summary["item"] = $item->summarize();
			return array(get_class($this)=>$summary);
		}
		*/
		
		function extend_shortlist() {
			return array("item" => $this->getObject());
		}
	
	} // end of the class

?>