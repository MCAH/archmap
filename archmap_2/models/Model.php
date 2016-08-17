<?php
	
	
	/*
	 * MODEL
	 *
	 */
	 
	class Model extends GenericRecord {
	
		var $table 		= "";
		var $primaryKey = "id";
		
		var $author;
		
		function Model($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
		
		// TODO (currently does not work)
		function lookupWithSlug($slug) { }
		
		function get($key) {
            switch($key) {
                case "descriptLinked":
                    return $this->translate(parent::get("descript"));
                case "className":
                    return get_class($this);
                case "uri":
                    return $this->__toString();
                default:
                    $return = parent::get($key);
                    if(!$return) { // falsy
                        $meta = $this->meta_fields("field = '$key'"); // will only be one row
                        $type = $meta[0]["type"];
                        if(strstr($type,"<")) {
                            $parts = explode(":",$meta[0]["type"]);
                            $inverse = $parts[1];
                            preg_match("/\<([A-Z][\w]+)\>/",$parts[0],$match);
                            $return = $this->getDefaultCollectionWithName($key,$match[1],$inverse);
                        }
                        // fetched property (must correpond to method) or plain function
                        else if(strstr($type,"fetch") || $type == "function") {
                            if(method_exists($this,$key)) {
                                return $this->$key();
                            }
                            else {
                                return false;
                            }
                        }
                    }
                    return $return; // no matter what
                }
            }
		
		// is this in use? I think it is...
		
		function relations() {
		   $metas = $this->meta_fields("type LIKE '<%'");
		   $relations = array();
		   foreach($metas as $meta) {
		      array_push($relations,$this->get($meta["field"]));
		   }
		   return $relations;
		}
		
		function getPossibleFields() {
		    $class = get_class($this);
		    $result = $this->db->query("SELECT field FROM meta WHERE model = '$class'");
		    foreach($result as $k=>$v) {
		        $result[$k] = $v[0];
		    }
		    return $result;
		}
		
		function getEntityId() {
		   return $this->db->getNumForHuman(get_class($this));
		}
		
		function mentions() { // all collections that mention this model, but are not many-to-many
		   /*
		   $entity_id = $this->getEntityId();
		   $item_id = $this->get("id");
		   $query = "SELECT * FROM collection_item WHERE item_id = $item_id AND item_entity_id = $entity_id";
		   $rows = $this->db->queryAssoc($query);
		   $collections = array();
		   foreach($rows as $row) {
		      $collection = new Collection("ID",$row["collection_id"]);
		      if($collection->get("name") === "DEFAULT:citations") {
		         array_push();
		      }
		      else if($collection->get("inverse") == false) {
		         array_push($collections,$collection);
		      }
		   }
		   return $collections;
		   */
		   return false;
		}
		
		function getLink() {
			return $this->__toString();
		}
		
		function getAuthor() {
			if ($this->author) return $this->author;
			
			$author_id = $this->get("author_id");
			if($author_id) {
				$this->author = new Person($author_id);
				return $this->author;
			}
			else {
				return false;
			}
		}
		
		// for gets called from the api, authenticated, single-field server
		// unlike the standard get, which has no authentication
		
		function remote_get($field,$user_level) {
			if($this->field_read_authenticate($field,$user_level)) {
				return $this->get($field);
			}
			else return false;
		}
		
		function meta_fields($clause) {
			$model = get_class($this);
			$query = "SELECT id,model,field,type FROM meta WHERE model = '$model' 
				AND $clause ORDER BY sortval";
			//$results = $this->db->queryAssoc($query);
			if (isset($results)) return $results;
		}
		
		function creation_requirements() {
			return $this->meta_fields("required = 1");
		}
		
		function creation_nonrequirements() {
			return $this->meta_fields("required = 0 AND editable = 1");
		}
		
		function objectify($array,$class = null) {
			if($class) {
				foreach($array as $key=>$value) {
					$array[$key] = new $class("KEYS",$value);
				}
			}
			else {
				// unsupported as of now, though also of unknown use
			}
			return $array;
		}

		function versionCt() {
			$db = $this->db;
			$q = "SELECT count(*) 
					FROM vers_".$this->table." 
					WHERE id=".$this->get("id");
			$count = $db->count($q);
			return $count;
		}
		
		function versionsHeaderRows() {
			$db = $this->db;
			//$q = "select c.*, count(ci.id) as count from   collection c LEFT JOIN 
			//collection_item ci ON  c.id=ci.collection_id group by c.id";
			$verTable = "vers_" . $this->table;
			$q = "	SELECT 		v.pid, v.editdate, p.name 
					FROM 		".$verTable." 	v 
					LEFT JOIN 	person 			p 
					ON  		v.edit_author_id=p.id 
					WHERE 		v.id=".$this->get("id") . "  
					ORDER BY v.editdate DESC";
			$rows = $db->queryAssoc($q);
			return $rows;
		}
		
		function versions() {
			$q = "SELECT * FROM vers_".$this->table." WHERE id=".$this->get("id") . " ORDER BY editdate DESC";
			$rows = $this->db->queryAssoc($q);
			return $rows;
		}
		
		function shortlist() {
			$shortlisted = $this->meta_fields("shortlist = 1");
			$fields = array();
			foreach($shortlisted as $short) {
				$fields[$short["field"]] = $this->get($short["field"]);
			}
			$fields["id"] = $this->get("id");
			$fields["uri"] = $this->keyToken();
			if(method_exists($this,"extend_shortlist")) {
				$extension = $this->extend_shortlist();
				if($extension) {
					foreach($extension as $key => $value) {
						$fields[$key] = $value;
					}
				}
			}
			return array(get_class($this)=>$fields);
		}
		
		// simple authentication for model creation
		
		function creation_authenticate($user_level) {
			return $this->field_authenticate("new",$user_level);
		}
		
		// simple authentication on a field (for writing)
		
		function field_authenticate($field,$user_level) {
			$meta = new Meta(get_class($this),$field);
			if(!$meta->get("id")) {
				$field_level = 6; // impossible with any known user authentication
			} // err on the side of unauthenticated
			else {
				$field_level = $meta->get("auth_level");
			} // meta entry exists, get it
			// and now test authentication
			if($user_level < $field_level) return false;
			else return $meta;
		}
		
		// simple authentication on a field (for reading)
		
		function field_read_authenticate($field,$user_level) {
			$meta = new Meta(get_class($this),$field);
			if(!$meta->get("id")) {
				$field_level = 5; // err on side of "it is not readable"
			}
			else {
				$field_level = $meta->get("searchable"); // searchable, which is to say readable
			}
			// test authentication
			if($user_level < $field_level) {
				return false;
			}
			else return true;
		}
		
		function getDefaultCollectionWithName($name,$statictype,$inverse) {
		   $entity_id = $this->db->getNumForHuman(get_class($this));
		   if(!$entity_id) {
			   $entity_id = $this->db->getNumForHuman(get_parent_class($this));
			}
			$item_id = $this->get("id");
			if(!isset($item_id)) return false;
			$query = "SELECT * FROM collection WHERE name = 'DEFAULT:$name'
				AND canonical=1 AND parent_entity_id = $entity_id and parent_item_id = $item_id";
			$rows = $this->db->queryAssoc($query);
			if($rows) { // the collection does exist
				$collection = new Collection("ROW",$rows[0]);
			}
			else { // the collection does not exist, so let's make it!
				$collection = new Collection();
				$collection->set("author_id",1); // system collection, no author
				$collection->set("canonical",1);
				$collection->set("statictype",$statictype);
				$collection->set("inverse",$inverse);
				$collection->set("parent_item_id",$item_id);
				$collection->set("parent_entity_id",$entity_id); // building
				$collection->set("name","DEFAULT:$name");
				$collection->saveChanges();
			}
			return $collection;
		}
		
		// little utilities
		
		function uri() { // is this actually used anywhere
			return strtolower($this->__toString());
		}
		
		function keyToken() {
			return $this->__toString();
		}
		
		function __toString() { // key-generating function
			return strtolower(get_class($this)."/".$this->get("id"));
		}
		

	}// end class

?>