<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/archmap/codebase/Database.php');

	class Search extends Model {
	
		var $db;
		var $term;
	
		function Search($mode,$term) {
			$this->term = urldecode($term);
			$this->db = new Database();
		}
		
		/* necessary for model-faking */
		function get($field) {
			switch($field) {
				case "name": return $this->term;
				case "id": return strtolower($this->term);
				default: return parent::get($field);
			}
		}
		
		/* provides 15 suggestions for given search for a field */
		
		function fieldSuggest($model,$field,$auth_level = 3) {
			$term = $this->term;
			$clause = "LIKE '%$term%' GROUP BY $field";
			return self::fieldSearch($clause,$model,$field,$auth_level);
		}
		
		function fieldCheck($model,$field,$auth_level = 3) {
			$term = $this->term;
			$clause = " = '$term'";
			return self::fieldSearch($clause,$model,$field,$auth_level);
		}
		
		// private method for use by fieldSuggest and fieldCheck
		
		function fieldSearch($clause,$model,$field,$auth_level) {
			$meta = new Meta($model,$field);
			if($auth_level < $meta->get("searchable")) {
				return false; // authorization check
			}
			else {
				$object = new $model();
				$table = $object->table; // get the table name
				$query = "SELECT id,name,$field FROM $table WHERE $field $clause LIMIT 10";
				$result = $this->db->queryAssoc($query);
				// now convert into nice objects with summaries
				foreach($result as $key=>$value) {
					$result[$key] = new $model($value["id"]);
				}
				return $result;
			}
		}
		
		/* Model Searching */
		
		function quicksearch($count = 10,$range = 0) {
			require_once("search/QuickSearch.php");
			$quicksearch = new QuickSearch($this->db,$this->term,$range,$count);
			$results = $quicksearch->search();
			$good_results = array();
			foreach($results as $key=>$value) {
				$class = $value['type'];
				$obj = new $class($value['item_id']);
				if($class == "Building" && $obj->get("style") != "11") {
				  continue;
				}
				if($obj->get("id")) {
					array_push($good_results,$results[$key] = $obj);
				}
			};
			return $good_results;
		}
		
		/* Smart Model Searching */
		
		function goodsearch() {
			require_once("search/GoodSearch.php");
			$good = new GoodSearch($this->term,$this->db);
			return $good->search();
		}
		
		/* Image Searching */
		
		// callback for mapping query results
		function imageFromId($id) {
		    return new Image($id);
		}
		
		function imageSearch() {
			$parts = $this->understandImageSearch($this->term);
			$mode = $parts[0];
			$ands = $parts[1];
			$query = "
				SELECT i.id
				FROM image i, building b, image_keyword_values k
				WHERE i.id = k.image_id
				AND b.id = i.building_id
				".$ands." AND k.weight >= 4
				GROUP BY b.name
				ORDER BY i.rating DESC
				LIMIT 0,5";
			// if length is less than some number, do a search on k.weight == 5
			$results = $this->db->queryAssoc($query);
			foreach($results as $key=>$result) {
				$results[$key] = new Image($result['id']);
			}
			return $results;
		}
		
		function images() {
		    $term = str_replace("+"," ",$this->term);
		    $query = "SELECT * FROM image WHERE title LIKE '%".$term."%'";
		    return $query;
		}
		
		function _imageCount() {
		    
		}
		
		/*
		    structured image search
		    can accept lots of stuff as GET params
		    (yes, hacky, but just works)
		*/
		function facetedimages() {
		    // keywords (from checklist ui)
		    $keywords = explode(",",$_GET["keywords"]);
		    $types = explode(",",$_GET["types"]);
		    // is a building id specified
		    // should clean these up with regular expressions
		    $bid = $_GET["bid"]; // building_id
		    if(strstr($bid,",")) {
		        $bids = explode(",",$bid);
		        $bid = false;
		    }
		    $aid = $_GET["aid"]; // author_id
		    $e_or_i = $_GET["e_or_i"]; // interior or exterior (default to both)
		    $rating = $_GET["rating"];
		    $d_or_d = $_GET["d_or_d"];
		    // building the single query
		    $query = array("select i.id");
		    $from = array("from image i");
		    if($keywords[0]) {
		        foreach($keywords as $i=>$keyword) {
		            $from[] = "image_keyword_values kv$i";
		        }
		    }
		    if($types[0]) {
		        foreach($types as $i=>$type) {
		            $from[] = "image_image_type_values tv$i";
		        }
		    }
		    if($d_or_d) {
		        $from[] = "image_plot p";
		    }
		    $query[] = implode(",\n",$from);
		    // starting the where clause
		    // keywords
    		if($keywords[0]) {
    		    $length = count($keywords);
    		    $query[] = "where i.id = kv0.image_id";
    		    foreach($keywords as $i=>$keyword) {
    		        if($i+1 < $length) {
    		            $i1 = $i + 1;
    		            $query[] = "and kv$i.image_id = kv$i1.image_id";
    		        }
    		        if(is_numeric($keyword)) {
    		            $query[] = "and kv$i.keyword_id = $keyword";
    		        }
    		        else {
    		            $query[] = "and kv$i.keyword_id =
        		            (select id from lexicon_entry where name = '$keyword' limit 1)";
    		        }
    		    }
    		}
    		// types
    		if($types[0]) {
    		    $length = count($length);
    		    $conj = ($keywords[0]) ? "and" : "where";
    		    $query[] = $conj." i.id = tv0.image_id";
    		    foreach($types as $i=>$type) {
    		        if($i+1 < $length) {
    		            $i1 = $i + 1;
    		            $query[] = "and tv$i.image_id = tv$i1.image_id";
    		        }
    		        if(is_numeric($type)) {
    		            $query[] = "and tv$i.image_type_id = $type";
    		        }
    		        else {
    		            $query[] = "and tv$i.image_type_id =
        		            (select id from image_types where name = '$type' limit 1)";
    		        }
    		    }
    		}
		    // just one building
		    if($bid) {
		        $query[] = "and i.building_id = $bid";
	        }
	        if($bids) {
	            $buildings = array();
	            foreach($bids as $id) {
	                $buildings[] = "i.building_id = $id";
	            }
	            $query[] = "and ( ".implode(" or ",$buildings)." ) ";
	        }
		    if($e_or_i) {
		        $query[] = "and i.ext_int = '$e_or_i'";
		    }
		    if($rating) {
		        if(strstr($rating,",")) {
		            $ratings = explode(",",$rating);
		            $query[] = "and (";
		            $ors = array();
		            foreach($ratings as $r) {
		                $ors[] = "i.rating = $r";
		            }
		            $query[] = implode(" or ",$ors);
		            $query[] = ")";
		        }
		        else {
		            $query[] = "and i.rating = $rating";
		        }
		    }
		    if($d_or_d) {
		        $query[] = "and p.view_type = $d_or_d";
		        $query[] = "and p.media_id = i.id";
		        $query[] = "and p.media_type = 1";
		    }
		    $query[] = "group by i.id";
		    if($bids) {
		        $query[] = "order by i.building_id";
		    }
		    
		    $query = implode("\n",$query);
		    //return $query;
            $results = $this->db->queryAssoc($query);
			foreach($results as $key=>$result) {
				$results[$key] = new Image($result['id']);
			}
			return $results;
		}
		
		// returns an index
		function in_array($needle,$haystack) {
		  for($i = 0; $i < sizeof($haystack); $i++)
		    if($haystack[$i] == $needle) return $i;
		  return false;
		}
		
		function natural() {
		  // the all important word list
		  $words = explode(" ",$_GET["natural"]);
		  $cWords = $words;
		  // remove little words known to be meaningless
		  $riffraff = array("of","and","in","at","by","from","shots","the");
		  foreach($riffraff as $w) {
		    $i = $this->in_array($w,$words);
		    if($i !== false) {
		      array_splice($words,$i,1);
		    }
		  }
		  // look for keywords
		  $allKeywords = new Catalog(null,"keywords");
		  $hasKeywords = array();
		  $allTypes = new Catalog(null,"types");
		  $hasTypes = array();
		  foreach(array($allKeywords,$allTypes) as $dex=>$list) {
		    foreach($list->members() as $v) {
		      $i = $this->in_array($v->get("name"),$words);
  		    if($i !== false) {
  		      $id = $v->get("id");
  		      ($dex === 0)
  		        ? $hasKeywords[] = $id
  		        : $hasTypes[] = $id;
  		      array_splice($words,$i,1); // delete the word now that we have it
  		    }
		    }
		  }
		  // look for interior/exterior
		  $ext_int = null;
		  foreach($words as $i=>$w) {
		    if($w == "interior" || $w == "exterior") {
		      array_splice($words,$i,1);
		      $ext_int = substr($w,0,1);
		    }
		  }
		  // look for detail/general views
		  // perform standard search with words left, looking for buildings
		  $this->term = implode(" ",$words);
		  $potentialBuildings = $this->quicksearch();
		  $buildings = array();
		  foreach($potentialBuildings as $b) {
		    $buildings[] = $b->get("id");
		  }
		  // ya'll ready for a HACK?
		  $_GET = array();
		  if(sizeof($hasKeywords) > 0) $_GET["keywords"] = implode(",",$hasKeywords);
		  if(sizeof($hasTypes) > 0) $_GET["types"] = implode(",",$hasTypes);
		  if(sizeof($buildings) > 0) $_GET["bid"] = implode(",",$buildings);
		  if($ext_int) $_GET["e_or_i"] = $ext_int;
		  
		  $images = $this->facetedimages();
		  $this->term = "null";
		  return $images;
		}
		
		function imageSimple($keywords) {
			if(is_array($keywords)) { // search on multiple keywords
				// build query
			}
			else { // search on a single keyword
				// build query
				$query = "
					SELECT i.id, i.title, i.filename, i.building_id
					FROM image i, image_keyword_values k
					WHERE i.id = k.image_id
					AND k.keyword_id = 9
					AND i.ext_int = 'i'
					ORDER BY k.weight DESC
				";
			}
		}
		
		function understandImageSearch($search_string) {
			
			$tokens = split(" ",$search_string);
			$ands = "";
			$mode = "";
			
			$ext_int_result = 0;
			$ext_int = array(
				"exterior"=>1,"outside"=>1,"outdoors"=>1,"ext."=>1,
				"interior"=>2,"inside"=>2,"within"=>2,"int."=>2
			);
			foreach($tokens as $key => $token) {
				foreach($ext_int as $term => $value) {
					if($token == $term) {
						$ext_int_result = $value;
						unset($tokens[$key]);
						break 2;
					}
				}
			}
			if($ext_int_result == 1) $ands .= "AND i.ext_int = 'e' ";
			elseif($ext_int_result == 2) $ands .= "AND i.ext_int = 'i' ";
			
			foreach($tokens as $key => $token) {
				$results = $this->db->queryAssoc(
					"SELECT id,name FROM lexicon_entry
					WHERE isKeyword = 1 AND name LIKE '%$token%' OR name_plural LIKE '%$token%'");
				if(is_null($results)) {
					
				}
				else {
					$ands .= "AND k.keyword_id = ".$results[0]['id']." ";
					$mode .= "+keyword";
				}
			}
			// if it has one of these, remove it from the string
			// and add a WHERE clause to our query
			//foreach($tokens as $token) {
			//	$query = "SELECT name FROM lexicon_entry WHERE isKeyword = 1 AND name LIKE '%".$token."%'";
			//}
			// get everything from lexicon_entry
			// run loop against query looking both ways for full matches
			// words 
			// also looking for places, i.e. only "building"
			// western frontispieces inside Amiens
			return array($mode,$ands);
		}
	
	}
	
?>