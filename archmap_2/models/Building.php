<?php

	/*
	 * BUILDING
	 *
	 */
	 
	class Building extends Model {
	
		var $table = "building";
		var $primaryKey = "id";
		var $walkabout = null;
		var $town;
		var $model;
		
		function Building($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
		
		function entityName() {
			return "Building";
		}
		
		function getSearchKey() {
			return $this->get("building_name");
		}
		function makeSearchKey() {
			return $this->get("building_name");
		}

		function getImagesCt() {
			$q = "select count(*) from image
			    where building_id=".$this->get($this->primaryKey)." and image_type != 'node'";
			$image_ct = $this->db->count($q);
			$this->set('image_ct', $image_ct);
			return ($this->get('image_ct'));
		}
		
		function getLightImages() {
			$query = 'SELECT * FROM image WHERE building_id='.$this->get("id").' ORDER BY id ASC limit 12';
			$images = $this->db->queryAssoc($query);
			$image_links = array();
			foreach($images as $image)
				$image_links[$image['id']] = $image['filename'];
			return $image_links;
		}
		
		function getAllImageUrls($size) {
			$query = '
				SELECT id,filename
				FROM image
				WHERE building_id='.$this->get("id").'
				ORDER BY id ASC';
			$images = $this->db->queryAssoc($query);
			$image_links = array();
			foreach($images as $image) {
				$filename = $image['filename'];
				$building_id = $this->get("id");
				$image_links[$image['id']] = "/archmap/media/buildings/001000/$building_id/images/$size/$filename";
			}
			return $image_links;
		}
		
		
		function getMainPoster($size) {
			// type_id=9 is Western Frontispiece
			$sql = '
				SELECT i.*
				FROM poster p, image i, image_types t
				WHERE p.image_id = i.id 
				AND i.building_id = '.$this->get('id').'
				AND p.type_id = 9 
				AND p.isImageType = 1';
				
			$result = $this->db->query($sql);
			$result->setFetchMode(PDO::FETCH_ASSOC);
			$poster = new Image($result->fetch());
			
			return $poster;
			
		
		}
		
		function getAllPosters($size) {
			$building_id = $this->get("id");
			
			$query1 = '
				SELECT e.name, e.id, p.image_id, i.filename
				FROM poster p, image i, lexicon_entry e
				WHERE p.image_id = i.id AND i.building_id = '.$building_id.'
				AND p.type_id = e.id AND p.isImageType = 1
				GROUP BY e.name ORDER BY e.name ASC';
			$query2 = '
				SELECT it.name, it.id, p.image_id, i.filename
				FROM poster p, image i, image_types it
				WHERE p.image_id = i.id AND i.building_id = '.$building_id.'
				AND p.type_id = it.id AND p.isImageType = 2
				GROUP BY it.name ORDER BY it.name ASC';
			
			$element_results = $this->db->queryAssoc($query1);
			$image_results = $this->db->queryAssoc($query2);
			
			
			$element_posters = array();
			foreach($element_results as $result) {
				$filename = $result['filename'];
				$element_posters[$result['name']] = array(
					"url"=>"/archmap/media/buildings/001000/$building_id/images/$size/$filename",
					"id"=>$result['image_id'],
					"element_id"=>$result['id']);
			}
			
			$image_posters = array();
			foreach($image_results as $result) {
				$filename = $result['filename'];
				$image_posters[$result['name']] = array(
					"url"=>"/archmap/media/buildings/001000/$building_id/images/$size/$filename",
					"id"=>$result['image_id'],
					"element_id"=>$result['id']);
			}
			
			return array($element_posters,$image_posters);
		}
		
		function getAllPostersWithKeys($size) {
			$posters = $this->getAllPosters($size);
			return array("lexicon_entries"=>$posters[0],"image_types"=>$posters[1]);
		}
		
		/*
			Returns a list of all the keywords that apply to this building
			also counts the number of images of the building that use the keyword
		*/
		function whatKeywords() {
			$query = '
				SELECT e.id, e.name, COUNT(*) as count
				FROM lexicon_entry e, image_keyword_values ie, image i
				WHERE i.building_id = '.$this->get("id").'
				AND ie.keyword_id = e.id
				AND i.id = ie.image_id
				GROUP BY e.id
				ORDER BY e.name';
			$results = $this->db->queryAssoc($query);
			return $results;
		}
		
		function whatImageTypes() {
			$query = '
				SELECT ii.id, ii.name, COUNT(*) as count
				FROM image_types ii, image_image_type_values it, image i
				WHERE i.building_id = '.$this->get("id").'
				AND it.image_type_id = ii.id
				AND i.id = it.image_id
				GROUP BY ii.id
				ORDER BY ii.name';
			$results = $this->db->queryAssoc($query);
			return $results;
		}
		
		function whichIsPoster($type_id,$isImageType) {
			if(is_numeric($type_id)) {
				$query = '
					SELECT image_id
					FROM poster
					WHERE building_id='.$this->get("id").'
					AND type_id='.$type_id.'
					AND isImageType = '.$isImageType.'
					LIMIT 1';
				$result = $this->db->queryAssoc($query);
				return $result;
			}
			else
				return false;
		}
		
		function whichIsPosterRedux($type_id,$isImageType = 1,$int_ext = false,$array_return = false) {
			if(is_numeric($type_id)) {
				if($int_ext == "interior" || $int_ext == "exterior") {
					$int_ext = substr($int_ext,0,1);
					$query = '
						SELECT p.image_id, i.filename FROM poster p, image i
						WHERE p.building_id='.$this->get("id").'
						AND p.type_id='.$type_id.'
						AND p.isImageType = '.$isImageType.'
						AND p.image_id = i.id
						AND i.ext_int = "'.$int_ext.'"
						LIMIT 1';
				}
				else {
					$query = '
						SELECT p.image_id, i.filename FROM poster p, image i
						WHERE p.building_id='.$this->get("id").'
						AND p.type_id='.$type_id.'
						AND p.isImageType = '.$isImageType.'
						AND p.image_id = i.id
						LIMIT 1';
				}
				$result = $this->db->queryAssoc($query);
				
				if($array_return) return $result;
				else return $result[0]['image_id'];
			}
			else return false;
		}
		
		// third try for a generic poster function, this one is the best!
		
		function posterFor($type_id,$isImageType,$int_ext=false) {
			$id = $this->whichIsPosterRedux($type_id,$isImageType,$int_ext);
			if($id != false) {
				return new Image($id);
			}
			return false;
		}
		
		function whichIsBestForType($type_id,$isImageType,$int_ext) {
			$to_choose_from = $this->getImagesForType($type_id,$isImageType,300,$int_ext);
			return $to_choose_from[0]['id'];
		}
		
		function getImagesForType($element_id,$element_or_image,$size,$int_ext = false) {
			if(is_numeric($element_id)) {
				if($int_ext == "interior" || $int_ext == "exterior") {
					$int_ext = substr($int_ext,0,1);
					if($element_or_image == 1) {
						$query = '
							SELECT e.image_id, e.weight, i.filename, i.rating
							FROM image_keyword_values e, image i
							WHERE e.keyword_id = '.$element_id.' AND i.ext_int = "'.$int_ext.'"
							AND i.building_id = '.$this->get("id").'
							AND i.id = e.image_id ORDER BY e.weight DESC';
					}
					else if($element_or_image == 2) {
						$query = '
							SELECT it.image_id, i.filename, i.rating
							FROM image_image_type_values it, image i
							WHERE it.image_type_id = '.$element_id.' AND i.ext_int = "'.$int_ext.'"
							AND i.building_id = '.$this->get("id").'
							AND i.id = it.image_id ORDER BY it.weight DESC';
					}
				}
				else {
					if($element_or_image == 1) {
						$query = '
							SELECT e.image_id, e.weight, i.filename, i.rating
							FROM image_keyword_values e, image i
							WHERE e.keyword_id = '.$element_id.'
							AND i.building_id = '.$this->get("id").'
							AND i.id = e.image_id ORDER BY e.weight DESC';
					}
					else if($element_or_image == 2) {
						$query = '
							SELECT it.image_id, i.filename, i.rating
							FROM image_image_type_values it, image i
							WHERE it.image_type_id = '.$element_id.'
							AND i.building_id = '.$this->get("id").'
							AND i.id = it.image_id ORDER BY it.weight DESC';
					}
				}
				$rows = $this->db->queryAssoc($query);
				$images = array();
				if($rows) {
					foreach($rows as $key=>$row) {
						$id = $row['image_id'];
						$filename = $row['filename'];
						$building_id = $this->get("id");
						$url = "/archmap/media/buildings/001000/$building_id/images/$size/$filename";
						$images[$key]['url'] = $url;
						$images[$key]['id'] = $id;
					}
				}
				return $images;
			}
			else
				return false;
		}
		
		function getTown() {
			if (! $town  &&  $this->get('town_id') &&  $this->get('town_id') > 0) {
				$this->town = new Place($this->get('town_id'));
			}
			return $this->town;
		}
		
		function getLatLng() {
			if($this->get('lat') && $this->get('lng')) {
				$coords = array();
				$coords['lat'] = $this->get('lat');
				$coords['lng'] = $this->get('lng');
				$coords['accuracy'] = 'building';
				return $coords;
			}
			else {
				$town = $this->getTown();
				return $town->getLatLng();
			}
		}
		
		function media() {
			$query_images = "
				SELECT id,filename,orig_filename,title,ext_int
				FROM image WHERE building_id='".$this->get('id')."'";
			$result = $this->db->queryAssoc($query_images);
			return $result;
		}
		
		/* get the canonical slideshow:
			if that show doesn't exist, make it! */
		
		function getCanonicalSlideshow() {
			$b_id = $this->get("id");
			$query = "SELECT * FROM slideshow WHERE canonical = 1 AND building_id = $b_id";
			$rows = $this->db->queryAssoc($query);
			if($rows) {
				$show = new Slideshow("ROW",$rows[0]);
			}
			else { // if it doesn't exist yet, create it and autopopulate it!
				$show = new Slideshow();
				$show->set("building_id",$b_id);
				$show->set("canonical",1);
				$show->set("name","Canonical Tour for ".$this->get("name"));
				$show->saveChanges();
				// now auto-populate it with courtauld imagery
				$courtaulds = $this->courtauld();
				foreach($courtaulds as $courtauld) {
					$id = $courtauld["category"]["Image"]["attributes"]["id"];
					if($id) {
						$show->addOneSlide($id,"",1);
					}
				}
			}
			//return $show->summarize();
			return $show;
		}
		
		function getSlideshows() {
			$query = '
				SELECT id,name
				FROM slideshow
				WHERE building_id='.$this->get("id");
			$results = $this->db->queryAssoc($query);
			return $results;
		}
		
		function getPosterImage() {
			return new Image($this->get('poster_id'));
		}
	
		function getPosterUrl() {
			$q = 'select * from image where building_id="'.$this->get('id').'" limit 0,1';
			$rows = $this->db->queryAssoc($q);
			if ($rows) {
				$url = 'http://learn.columbia.edu/archmap/media/buildings/001000/'.$this->get('id').'/images/300/'.$rows[0]["filename"];
				return $url;
			}
		}
		
		//// deppppppprecated
		function getDescriptParts() {
			$d = simplexml_load_string(utf8_encode($this->get("descript")));
			if($d->formal != null) {
				$plan = $d->formal->plan;
				$elev = $d->formal->elevation;
			}
			else {
				$plan = $d->plan;
				$elev = $d->elevation;
			}
			$hist = $d->history;
			$cron = $d->chronology;
			$sigg = $d->significance;
			return array("plan"=>utf8_decode($plan),
				"elevation"=>utf8_decode($elev),
				"history"=>utf8_decode($hist),
				"chronology"=>utf8_decode($cron),
				"significance"=>utf8_decode($sigg));
		}
		
		function getEditableAttributes() {
			$attributes = array(
				"Start Date" => array("field" => "beg_year"),
				"End Date" => array("field" => "end_year"),
				"Wikipedia" => array("field" => "wikipedia") );
			parent::setEditableAttributes($attributes);
			return parent::getEditableAttributes();
		}
	
		function get($key) {
			switch($key) {
			    //case "exterior_chevet":
			    //    return $this->courtauldSearch(1,"exterior",54);
				//case "floorplan":
				//	return $this->floorplan();
				case "floorplanURL":
					return $this->floorplanURL(100);
				case "posterURL":
					$poster = $this->getPoster();
					return $poster->url(100);
				default:
					return parent::get($key);
			}
		}
		
		
		/*
		function images($count,$offset = 0) {
			$query = "SELECT * FROM image
				WHERE image_type != 'node' AND building_id = ".$this->get("id");
			if(is_numeric($count)) {
				$query .= " LIMIT ".$count;
				if(!is_null($offset))
					$query .= " OFFSET ".$offset;
			}
			$results = $this->db->queryAssoc($query);
			return $this->objectify($results,"Image");
		}
		*/
		
		function plainImageQuery() {
		    return "SELECT * FROM image WHERE image_type != 'node'
		        AND building_id = ".$this->get("id")." ORDER BY id";
		}
		
		function images($range) {
		    $start = $range[0];
		    $limit = $range[1];
			$query = $this->plainImageQuery();
			if(is_numeric($start) && is_numeric($limit)) {
				$query .= " LIMIT ".$limit;
				if(!is_null($start))
					$query .= " OFFSET ".($start+1);
			}
			$results = $this->db->queryAssoc($query);
			return $this->objectify($results,"Image");
		}
		
		function nodes() {
			$query = "SELECT * FROM image
				WHERE image_type = 'node' AND building_id = ".$this->get("id");
			$results = $this->db->queryAssoc($query);
			return $this->objectify($results,"Node");
		}
		
		function stereos() {
			$query = "SELECT * FROM image
				WHERE has_stereo = 1 AND building_id = ".$this->get("id");
			return $this->objectify($this->db->queryAssoc($query),"Image");
		}
		
		//// I think this was judged to be not really up-to-snuff, so.... deprecated
		
		function walkabout() {
			if($this->walkabout == null) {
				$floorplan = $this->floorplan(); // floorplan
				$image_id = $floorplan->get("id");
				$ratio = $floorplan->get("width")/$floorplan->get("height");
				$height = 700/$ratio;
				$half_height = $height/2;
				$queries = array(
					"south" => "
						SELECT image_id,xloc,yloc,rotation,media_id,title,ext_int,filename,building_id
						FROM image_plot LEFT JOIN image ON image_plot.media_id = image.id 
						WHERE image_id = $image_id AND ext_int = 'e' AND media_type = 1 
						AND yloc > $half_height AND view_type = 1 ORDER BY xloc",
					"north" => "
						SELECT image_id,xloc,yloc,rotation,media_id,title,ext_int,filename,building_id
						FROM image_plot LEFT JOIN image ON image_plot.media_id = image.id
						WHERE image_id = $image_id AND ext_int = 'e' AND media_type = 1 
						AND yloc < $half_height AND view_type = 1 ORDER BY xloc DESC",
					"center" => "SELECT image_id,xloc,yloc,rotation,media_id,title,ext_int,filename,building_id
						FROM image_plot LEFT JOIN image ON image_plot.media_id = image.id
						WHERE image_id = $image_id AND ext_int = 'i' AND media_type = 1 AND level = 1
						AND yloc > $half_height AND view_type = 1 ORDER BY xloc"
				);
				$images = array();
				foreach($queries as $query) {
					$images = array_merge($images,$this->db->queryAssoc($query));
				}
				foreach($images as $key=>$image) {
					$images[$key] = new Image($image["media_id"]);
				}
				$this->walkabout = $images;
			}
			return $this->walkabout;
		}
		
		function floorplan() {
		
			$image = new Image($this->get("plan_image_id"));
			
			return $image;
		}
		function floorplanURL($size) {
			$planImage = new Image($this->get("plan_image_id"));
			return $planImage->url($size);
		}
		
		function posterURL($size) {
			if (! $this->get("poster_id")) {
				return ("/archmap_2/media/ui/NoImage.jpg");
				
			}
			$posterImage = new Image($this->get("poster_id"));
			return $posterImage->url($size);
		}
		
		function lat_section() {
		    $id = $this->get("lat_section_image_id");
		    return ($id) ? new Image($id) : false;
		}
		function lat_sectionURL($size) {
		    $id = $this->get("lat_section_image_id");
		    if (is_numeric($id)) {
		    	$image =  new Image($id);
		    	return $image->url($size);
		    }
		}
		function log_section() {
		    $id = $this->get("long_section_image_id");
		    return ($id) ? new Image($id) : false;
		}
		
		function drawings() {
		    $sql = 'SELECT i.* from images i';
		    
		    
		    
		    //return ($id) ? new Image($id) : false;
		}
		
		function frontispiece() {
			return $this->simplePoster("frontispiece");
		}
		
		function simplePoster($name) {
			$number = null;
			$type = null;
			switch($name) {
				case "frontispiece":
					$number = 9; $type = 1; break;
				case "nave":
					$number = 11; $type = 1; break;
			}
			if($name != null && $number != null) {
			    $image = new Image($this->whichIsPosterRedux($number,$type));
			    return $image;
			    //return ($image->get("id")) ? $image : false;
			}
			else {
				return false;
			}
		}
		
		function exterior_chevet() {
		    return $this->courtauldSearch(1,"exterior",54);
		}
		
		function courtauldSearch($type,$ext_int,$keywords,$already_matched) {

			$result = null;
			
			if(is_array($keywords)) { // fallbacks included
				$i = 0;
				$result = $this->whichIsPosterRedux($keywords[$i],$type,$ext_int);
				while($result == NULL && $i <= count($keywords)) {
					$i += 1;
					$result = $this->whichIsPosterRedux($keywords[$i],$type,$ext_int);
				}
				if($result == NULL) {
					$i = 0;
					$result = $this->whichIsBestForType($keywords[$i],$type,$ext_int);
					while($result == NULL && $i <= count($keywords)) {
						$i += 1;
						$result = $this->whichIsBestForType($keywords[$i],$type,$ext_int);
					}
				}
				if($result == NULL) {
					// total fail
				}
			}
			else { // no fallbacks, 1 keyword to search
				$result = $this->whichIsPosterRedux($keywords,$type,$ext_int);
				if($result == NULL)
					$result = $this->whichIsBestForType($keywords,$type,$ext_int);
			}
			
			if($result != null) {
				return new Image($result);
			}
			else
				return false;
		}
		
		function cascade_select($results,$already_matched) {
			$i = 0;
			while(in_array($results[$i]["id"],$already_matched))
				$i += 1;
			return $results[$i]["id"];
		}
		
		function summaPoster() {
			return $this->posterFor(9,1);
		}
		
		function courtauld() {
			$queries = array(
				//"1. Plans and Drawings" => "2,false,array(12,2,18)",
				"2. Distant or General Views" => "2,'exterior',9",
				"3. Exteriors of the Western Frontispiece" => "1,'exterior',9",
				"4. Exteriors of the Nave" => "1,'exterior',11",
				"5. Exteriors of the Transept or Crossing" => "1,'exterior',array(135,65)",
				"6. Exteriors of the Chevet" => "1,'exterior',54",
				"7. Interiors of the Narthex or Porch" => "1,'interior',array(98,108)",
				"8. Interiors of the Nave" => "1,'interior',11",
				"9. Interiors of the Transept or Crossing" => "1,'interior',array(135,65)",
				"10. Interiors of the Chevet" => "1,'interior',54",
				"11. Ancillary Buildings" => "1,false,array(53,69,111)",
				"12. Sculptural Programs" => "1,false,array(24,84,72)",
				"13. Glass" => "1,false,126",
				"14. Liturgical or Devotional Furniture" => "1,false,array(133,85)",
			);
			$results = array();
			$matched_set = array();
			foreach($queries as $title => $params) {
			    print_r($params);
				eval('$result = $this->courtauldSearch('.$params.',$matched_set);');
				array_push($results,array("category"=>$result));
				array_push($matched_set,$result["Image"]["attributes"]["id"]);
				$results[count($results)-1]["category"]["attributes"] = array("title"=>$title);
			}
			return $results;
		}
		
		
		
		function ensurePlansHaveZ_Related_Entities() {
			
			$plan_id = $this->get('plan_image_id');
			
			
			if ($plan_id && is_numeric($plan_id)) {
				$tmp_sql = "
					select count(*) from z_related_entities z 
					where 	z.from_entity_id=40 
					and 	z.from_id=".$this->get('id')." 
					and   	z.to_entity_id=110
					and   	z.to_id=".$plan_id."
					and 	z.relationship='drawing'";
				
				$count = $this->db->count($tmp_sql);
				
				if (! $count || $count < 1) {
					$image = new Image($plan_id);
					$this->addRelation($image, "drawing");
				}
				
			}
		}
		
		
		
		
		
		/** BUILDING MODEL **/
		function getModel() {
			if (! isset($model)) {
			println("get model rrr ".$this->get("id"));
				$model = new BuildingModel($this->get("id"));
				
			}
			return $model;	
		}
		
		function asXML($incl = null)
		{
			$row = $this->attrs;
			$incl = array("id", "style", "functional_type", "formal_type",
				"beg_year", "end_year", "height", "width", "length", "name",
				"town_id", "descript", "lng", "lat");
	
			$xml .= '<'.get_class($this).'>';
			if ($this->town) {
				$xml .= $this->town->asXML();
			}
			$floorplan = $this->floorplan();
			print_r($floorplan);
			if ($floorplan) {
				
				$xml .= $floorplan->asXMLAttributes(); 
			}
			$lat_section = $this->lat_section();
			if ($lat_section) {
				$xml .= $lat_section->asXMLAttributes(); 
			}
			
			//$url = $this->getPosterUrl();
			if ($url) {
				$xml .= '<poster_url>'.$url.'</poster_url>';
			}
			for ($i=0; $i<sizeof($incl); $i++) {
				if ($incl[$i] == "descript") {
					$tmp = str_replace("<br>", "<br />", $row[$incl[$i]]);
					$xml .= 	'<'.$incl[$i].'>'.utf8_encode($tmp).'</'.$incl[$i].'>';
				
				} else {
					$xml .= 	'<'.$incl[$i].'>'.utf8_encode($row[$incl[$i]]).'</'.$incl[$i].'>';
				}
			}
			$xml .= '</'.get_class($this).'>';
			
			return $xml;
		}

	
	
	}



?>