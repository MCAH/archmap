<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Image.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');

	/*
	 * Lexicon Entry
	 *
	 */
	
	class LexiconEntry extends Model {
	
		var $letter = "0";
		var $link_base = "/archmap/a";
	
		function LexiconEntry($arg1=0, $arg2=0) {
		
			$this->table = "lexicon_entry";
			
			if ($arg1 == "LOOKUP" && is_string($arg2)) {
				$this->db 	= new Database();
				$query 	= 'SELECT * FROM '.$this->tableName().' WHERE name="'.strtolower($arg2).'"';
				$result = $this->db->queryAssoc($query);
				if (isset($result)){
					$this->initFromAssocRow($result[0]);
					return;
				} 
				$query 	= 'SELECT * FROM '.$this->tableName().' WHERE name_plural="'.strtolower($arg2).'"';
				$result = $this->db->queryAssoc($query);
				if (isset($result)){
					$this->initFromAssocRow($result[0]);
					return;
				}
				return;
			}
			parent::GenericRecord($arg1, $arg2);
		}
		
		function setLinkBase($link_base){
			$this->link_base = $link_base;
		}
		
		function getSearchKey() {
			return $this->get("name");
		}
		
		function getImages() {
			$query = "SELECT i.* FROM image_keyword_values v
				LEFT JOIN image i ON v.image_id = i.id 
				WHERE keyword_id = ".$this->get("id");
			$rows = $this->db->queryAssoc($query);
			foreach($rows as $key=>$row) {
				$image = new Image("ROW",$row);
				$rows[$key] = $image->summarize();
			}
			return $rows;
		}
		
		function getFormattedListItem() {
			$class = "plain";
			$url_safe_searchkey = str_replace(" ","+",$this->get('name'));
			if($this->get('isKeyword') == 1)
				$class = "keyword";
			return '
			  <li class="'.$class.' entry" rel="'.$this->get('id').'" count="'.$this->howManyPhotos().'">
			   <div>
			    <a href="'.$url_safe_searchkey.'" class="searchkey">'.$this->get('name').'</a>
			    <small style="display:none">'.$this->get('metaphone').'</small>
			   </div>
			  </li>
			';
		}
		
		function howManyPhotos() {
			$query = 'SELECT COUNT(*) FROM image_keyword_values WHERE keyword_id='.$this->get('id');
			$count = $this->db->count($query);
			return $count;
		}
		
		function getPhotos($count = 5,$size = 700) {
			$query = 'SELECT * FROM image_keyword_values WHERE keyword_id='.$this->get('id');
			$rows = $this->db->queryAssoc($query);
			if(is_integer($count))
				$rows = array_slice($rows,0,$count);
			if(sizeof($rows) > 0) {
				$images = array();
				$i = 0;
				foreach($rows as $row):
					$id = $row['image_id'];
					$image = new Image($id);
					$where = $image->where();
					$url = $image->url($size);
					$images[$i] = array();
					$images[$i]['url'] = $url;
					$images[$i]['id'] = $id;
					$images[$i]['where'] = $where;
					$i++;
				endforeach;
				return $images;
			}
			else if($this->get('isKeyword') == 1)
				return 'No images.';
			else
				return 'Not an image keyword.';
		}
		
		function getPostersUnformatted() {
			$query = '
				SELECT p.image_id, p.type_id, i.filename, i.building_id, b.building_name, pl.name
				FROM poster p, image i, building b, place pl
				WHERE p.type_id = '.$this->get("id").'
				AND b.id = i.building_id
				AND p.image_id = i.id
				AND b.town_id = pl.id
				AND p.isImageType = 1';
			return $this->db->queryAssoc($query);
		}
		
		function getPosters($size) {
			$query = '
				SELECT p.image_id, p.type_id, i.filename, i.building_id, b.building_name, pl.name
				FROM poster p, image i, building b, place pl
				WHERE p.type_id = '.$this->get("id").'
				AND b.id = i.building_id
				AND p.image_id = i.id
				AND b.town_id = pl.id
				AND p.isImageType = 1';
			$results = $this->db->queryAssoc($query);
			$list = '';
			foreach($results as $result) {
				$b_name = utf8_encode($result["building_name"]);
				$p_name = utf8_encode($result["name"]);
				$encoded = str_replace(" ","+",$this->get("name"));
				$list .= '
					<li>
					 <a class="building-link"
					 	 href="'.$this->link_base.'/buildings/'.$result['building_id'].'">
					 	 '.$b_name.', '.$p_name.'</a>
					 <a class="image-link" href="'.$this->link_base.'/buildings/'.$result['building_id'].'/'.$encoded.'">
					  <img src="/archmap/media/buildings/001000/'.$result['building_id'].'/images/'.$size.'/'.$result['filename'].'"/>
					 </a>
					</li>';
			}
			return $list;
		}
		
		function getImagesForBuilding($size,$building_id) {
			if(is_numeric($building_id)) {
				$query = '
					SELECT e.image_id,i.building_id
					FROM image_keyword_values e, image i
					WHERE e.keyword_id = '.$this->get("id").'
					 AND i.building_id = '.$building_id.'
					 AND i.id = e.image_id
					GROUP BY e.image_id
					ORDER BY e.image_id ASC
					';
				$rows = $this->db->queryAssoc($query);
				$images = array();
				foreach($rows as $key=>$row) {
					$id = $row['image_id'];
					$image = new Image($id);
					$url = $image->url($size);
					$images[$key]['url'] = $url;
					$images[$key]['id'] = $id;
				}
				return $images;
			}
			else
				return false;
		}
		
		// this should be taken out at some point, fairly pointless
		function getFirstLetter() {
			$name = $this->get('name');
			return strtolower($name[0]);
		}
		
		function hasPoster($building_id) {
			if(is_numeric($building_id)) {
				$query = 'SELECT image_id
						FROM poster
						WHERE type_id='.$this->get('id').'
						AND building_id='.$building_id;
				$result = $this->db->queryAssoc($query);
				return $result[0]['image_id'];
			}
		}
		
		/* ======= Functions for Aliases ======= */
		
		function makeAlias($lang, $alias, $alias_plural, $author_id) {
			// uses this: http://www.loc.gov/standards/iso639-2/php/code_list.php
			$element_type_id = $this->get("id");
			$metaphone = metaphone($alias);
			$createdate = rightNow();
			$command = "INSERT INTO element_type_alias
				(element_type_id, lang, alias, alias_plural, metaphone, createdate, author_id)
				VALUES ($element_type_id, \"$lang\", \"$alias\", \"$alias_plural\",
					\"$metaphone\", \"$createdate\", $author_id)";
			$this->db->submit($command);
		}
		
		function getAliases() {
			$element_type_id = $this->get("id");
			$query = "SELECT lang,alias,alias_plural FROM element_type_alias WHERE element_type_id = $element_type_id";
			$result = $this->db->queryAssoc($query);
			return $result;
		}
		
		function deleteAlias($lang,$alias) {
			$id = $this->get("id");
			if(isset($id) && isset($lang) && isset($alias)) {
				$command = "
					DELETE FROM element_type_alias
					WHERE lang=\"$lang\" AND alias=\"$alias\"
					AND element_type_id=$id";
				$this->db->submit($command);
				return true;
			}
			else
				return false;
		}
		
		function delete() {
			$confirmedID = $this->get("id");
			if($confirmedID && is_numeric($confirmedID) && $confirmedID > 0) {
				$command = 'DELETE FROM lexicon_entry WHERE id='.$confirmedID;
				$this->db->submit($command);
				return true;
			}
			else
				return false;
		}
		
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"id"=>$this->get("id"),
				"name"=>$this->get("name"),
				"name_plural"=>strtolower($this->get("name_plural")),
				"isKeyword"=>$this->get("isKeyword"),
				"isDetail"=>$this->get("isDetail"),
				"author_id"=>$this->get("author_id")
			);
			$summary["descript"] = $this->get("descript");
			return array(get_class($this)=>$summary);
		}
		
		function wordnikDefinitions() {
			$url = "http://api.wordnik.com/api/word.json/".$this->get("name")."/definitions";
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
			curl_setopt($ch,CURLOPT_HTTPHEADER,array(
				"api_key:d4d9cdf6762d015b2900b0f2a1d000e494c784b33503477ea"
			));
			$result = curl_exec($ch);
			curl_close($ch);
			return array(get_class($this)=>array("wordniks"=>json_decode($result,true)));
		}
		
	}



?>