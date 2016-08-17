<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Image.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Setup.php');

	/*
	 * Image Type
	 *
	 */
	
	class ImageType extends Model {
	
		var $letter = "0";
	
		function ImageType($arg1=0, $arg2=0) {
		
			$this->table = "image_types";
			
			if ($arg1 == "LOOKUP" && is_string($arg2)) {
				$this->db 	= new Database();
				$query 	= 'SELECT * FROM '.$this->tableName().' WHERE name="'.strtolower($arg2).'"';
				$result = $this->db->queryAssoc($query);
				if (isset($result)){
					$this->initFromAssocRow($result[0]);
					return;
				}
				return;
			}
			parent::GenericRecord($arg1, $arg2);
		}
		
		function getSearchKey() {
			return $this->get("name");
		}
		
		function howManyPhotos() {
			$query = 'SELECT COUNT(*) FROM image_image_type_values WHERE image_type_id='.$this->get('id');
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
	}



?>