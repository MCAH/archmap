<?php
	

	/*
	 * PUBLICATION
	 *
	 */
	 
	class Publication extends Model {
	
		var $table 			= "publication";
		var $primaryKey 	= "id";
	
		var $authors;	// array of type Person
		
		
	   function Publication($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}


		function getPubtypeName() {
			
	   		switch($this->get('pubtype')) {
	   			case 5: return "BookSection"; break;
	   			case 6: return "Book"; break;
	   			case 10: return "ConferenceProceedings"; break;
	   			case 12: return "WebPage"; break;
	   			case 13: return "Generic"; break;
	   			case 17: return "JournalArticle"; break;
	   			case 23: return "NewspaperArticle"; break;
	   			case 25: return "Patent"; break;
	   			case 26: return "PersonalCommunication"; break;
	   			case 27: return "Report"; break;
	   			case 28: return "EditedBook"; break;
	   			case 255: return "Periodical"; break;
	   			case 1000: return "Periodical"; break;
	   		
	   		}
	   }
	   
	   function citation() {
	      $authors = $this->get("authors"); // all the authors
	      $editors = $this->get("editors"); // all the editors
	      $parent = $this->get("parent_pub"); // the parent, if there is one
	      $volume = $this->get("volume"); // the volume number
	      $publisher = $this->get("publisher");
	      $where = $this->get("location");
	      $year = $this->get("year");
	      $pages = $this->get("pages");
	      // the authors
	      $author_string = "";
	      foreach($authors->get("members") as $author) {
	         if($author_string == "") {
	            $author_string .= $author->get("name");
	         }
	      }
	      // the title
	      $title = "_".$this->get("name")."_";
	      if(sizeof($parent->get("members")) > 0) {
	         $title = "&ldquo;".str_replace("_","",$title).",&rdquo;";
	         $parent = $parent->get("members");
	         $parent = $parent[0]; // oy!
	         $title .= " _".$parent->get("name")."_";
	         $where = $parent->get("location");
	         $publisher = $parent->get("publisher");
	         $year = $parent->get("year");
	      }
	      $citation = $author_string.". ".$title.". ".$where.": ".$publisher.", ".$year.".";
	      if($pages) {
	         $citation .= " ".$pages.".";
	      }
	      return $citation;
	   }
	   
	   function extend_shortlist() {
	      return array(
	         "mla_citation" => $this->citation()
	      );
	   }
	   
	   function setContributors($contributorsString) {
	   		$this->set('contributors', $contributorsString);
	   		$this->set('contributors_metaphone', metaphone($contributorsString));
	   		
	   		$this->saveChanges();
	   
	   }
	
	   /*
		function getSearchKey() {
			$sk = $this->get("search_key");
			if ($sk && $sk != "") 
				//return $sk;
				
			return makeSearchKey();	
		}
		*/
		/*
		function makeSearchKey() {
			return $this->get("title");
		}
		*/
		/*
		function setAuthorsByDB_NAME($db_names_array) {
			// this is an array of strings like "Wilson, Charles A."
			print("<br />setting authors in pub<br>");
			if ($db_names_array) {
				
				$this->db_clearAuthors();
				
				foreach ($db_names_array as $db_name) {
					print("setting author: " . $db_name. "<br />");
					$keys["db_name"] = $db_name;
					$author = new Person("KEYS", $keys);
					
					if ($author && $author->get("id") > 0) {
						// author exists
						
					} else {
						println("Author does NOT exist");
						$author->set("db_name", $db_name);
						$author->deriveNameFromDB_Name();
						$author->makeAuthor();
						
						$author->saveChanges();
						
					}
					
					
					if ($author && $author->get("id") > 0) {
						$this->addAuthor($author);
					}
				}
			}
		}
		
		function db_clearAuthors() {
			$id = $this->get("id");
			if ($id && is_numeric($id) && $id > 0) {
				$query = "delete from publication_authors where pub_id=" . $id;
				$db 	= new Database();
				$db->submit($query);
			}
		}
		
		function addAuthor($author) {
			$authors[] = $author;
			$db 	= new Database();
			$query = 'insert into publication_authors (pub_id, person_id) values ('.$this->get("id").', '.$author->get("id").');';
			$db->submit($query);
		}
		
		function getAuthors() {
			if (! $this->authors) {
				$db 	= new Database();
				$q 		= 'select pp.* from publication_authors pa, people pp where pa.pub_id='.$this->get('id').' and pa.person_id=pp.id';
				$rows 	= $db->queryAssoc($q);
				if ($rows) {
					foreach ($rows as $row) {
						$this->authors[] = new Person($row);
					}
				}
			}
			return $authors;
		}
		
		function getAuthorListing() {
			$db 	= new Database();
			$q = 'select pp.search_key from publication_authors pa, people pp where pa.pub_id='.$this->get('id').' and pa.person_id=pp.id';
			$arows = $db->queryAssoc($q);
			if ($arows) {
				foreach ($arows as $arow) {
					if ($ret != "") $ret .= '; ';
					$ret .= $arow["search_key"];
				}
			}
			return($ret);
		
		}
		*/
		
		// wwwwwhoa this is deprecated--- yyyyikes
		/*
		function getEditableAttributes() {
			$attributes = array(
				"Contributors" => array("field" => "contributors"),
				"Date" => array("field" => "date"),
				"Year" => array("field" => "year"),
				"Location" => array("field" => "location"),
				"Publisher" => array("field" => "publisher", "regularized" => true),
				"Pages" => array("field" => "pages"),
				"Call#" => array("field" => "callnumber"),
				"Clio ID" => array("field" => "clio"),
				"ISBN" => array("field" => "ISBN_ISSN") );
			parent::setEditableAttributes($attributes);
			return parent::getEditableAttributes();
		}
		*/
		
		/*
		function makeReference($entity_id, $item_id, $author_id, $pages = "", $notes = "") {
			$publication_id = $this->get("id");
			$createdate = rightNow();
			$command = "INSERT INTO bibliographic_entry 
				(entity_id, item_id, publication_id, pages, notes, author_id, createdate)
				VALUES ($entity_id, \"$item_id\", \"$publication_id\", \"$pages\",
					\"$notes\", \"$author_id\", \"$createdate\")";
			$this->db->submit($command);
		}
		
		/// deprecated (redoing this with default collections)
		function getReferences() {
			$publication_id = $this->get("id");
			$query = "SELECT * FROM bibliographic_entry WHERE publication_id = $publication_id";
			$result = $this->db->queryAssoc($query);
			foreach($result as $key=>$value) {
				$result[$key]['entity_type'] = Database::getTypeReference($value['entity_id']);
				$name_query = "SELECT name FROM ".$result[$key]['entity_type']." WHERE id = ".$value['item_id'];
				$res = $this->db->queryAssoc($name_query);
				$result[$key]['name'] = $res[0]['name'];
				$res = $this->db->queryAssoc("SELECT name FROM person WHERE id = ".$value['author_id']);
				$result[$key]['author'] = $res[0]['name'];
			}
			return $result;
		}
		*/
		
		// deprecated
		/*
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"id"=>$this->get("id"),
				"name"=>$this->get("name"),
				"contributors"=>$this->get("contributors"),
				"date"=>$this->get("date"),
				"year"=>$this->get("year"),
				"location"=>$this->get("location"),
				"publisher"=>$this->get("publisher"),
				"isbn"=>$this->get("ISBN")
			);
			$summary["notes"] = $this->get("notes");
			$summary["abstract"] = $this->get("abstract");
			return array(get_class($this)=>$summary);
		}
		
		// deprecated
		function asXML($incl = null) {
			$row = $this->attrs;
			$incl = array("id", "name", "contributors", "date","publisher",
				"beg_year", "end_year",
				"descript", "lng", "lat");
	
			$xml .= '<'.get_class($this).'>';
					for ($i=0; $i<sizeof($incl); $i++) {
				$xml .= 	'<'.$incl[$i].'>'.utf8_encode($row[$incl[$i]]).'</'.$incl[$i].'>';
			}
			$xml .= '</'.get_class($this).'>';
			
			return $xml;
		}
      */

		
	}

?>