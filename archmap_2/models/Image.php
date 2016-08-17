<?php
	

	/*
	 * IMAGE
	 *
	 */
	 
	class Image extends Model {
	
		var $table = "image";
		var $primaryKey = "id";
		var $image_image_types;
		var $image_element_types;
		var $building;
		var $slideshows = array();
		var $keywords;
		
		var $image_typeids = array('photograph' => 1, 'drawing' => 2, 'aerial' => 3, 'archaeological' => 4, 'axonometric' => 5, 'detail' => 7, 'elevation' => 11, 'floorplan' => 12 );
		
		function Image($arg1=0, $arg2=0) {
		
			parent::GenericRecord($arg1, $arg2);
		}
		
	
		/* simple override for latitude and longitude */
		
		function get($key) {
			switch($key) {
					
				
				case "url":
					return $this->url();
				case "tiny":
					return $this->url(50);
				case "thumbnail":
					return $this->url(100);
				case "medium":
					return $this->url(700);
				case "full":
				  return $this->url("full");
				case "building_name":
					$building = new Building($this->get("building_id"));
					return $building->get("name");
				case "author_name":
					$author = new Person($this->get("author_id"));
					return $author->get("name");
				case "zeroethTile":
					return $this->get_0_0_0_Tile();
				default:
					return parent::get($key);
			}
		}
		
		
		
		
		
		
		
		// ! ******** URL MAPPING
		function url($size) {
		
			if (! $size) { $size = 'full'; }
			
		
	

			$ext = $this->determineFileExtension($this->get("mimetype"));
			
			if ( $this->get("filesystem") == "B") {
				// one off uploads
				
				if ( strstr($this->get("orig_filename"), '/') ) { // file path in orig_filename
					$src_url = '/archmap/media/images/'.$this->get("orig_filename").'_'.$size.'.'.$ext;
				} else {
					$src_url = '/archmap/media/images/'.$this->get("filename").'_'.$size.'.'.$ext;
				}
			
			} else if ($this->get("id") < 30000) {
				// a bourbonnais curch
		
				switch ($this->get("element_type")) {
				
					case 'ca':
						$folder = 'capitals';
						if ($size == 'full') {
							$size = 'large';
						} else {
							$size = '50';
						}

						break;
				
					case 's_elev':
					case 'w_elev':
						$folder = 'elevations';
						if ($size == 'full') {
							$size = '50';
						} else {
							$size = '05';
						}
						break;
					case 'pl':
						$folder = 'plans/genermont_rotated';
						if ($size == 'full') {
							$size = 'huge';
						} else {
							$size = 'small';
						}
						break;
					case 'pr':
						$folder = 'piers';
						if ($size == 'full') {
							$size = 1000;
						} else {
							$size = '80';
						}
						break;
					default:
						if ($size == 'full') {
							$size = 'medium';
						} else {
							$size = 'pinky';
						}
						$folder = 'photos';				
				
				}
				$src_url = '/bourb/media/'.$folder.'/'.$size.'/'.$this->get("filename");
			
			} else {
				
			
				// archmap (mgf) images stored in media/buildings -- all images from lightroom upload script
				$src_url = '/archmap/media/buildings/001000/'.$this->get("building_id").'/images/'.$size.'/'.$this->get("filename");
				
			
			}
				
	
			
			return $src_url;
			
		}
		
		

		function oldurl($size) {
			if($this->get("filesystem") == "B") {
				$ext = $this->determineFileExtension($this->get("mimetype"));
				$stub = $this->get("filename");
				if($this->get("width") > $this->get("height")) {
					$max = $this->get("width");
				}
				else {
					$max = $this->get("height");
				}
				if($size > $max - 50) {
					return "/archmap/media/images/{$stub}_full.$ext";
				}
				else {
					return "/archmap/media/images/{$stub}_{$size}.$ext";
				}
			}
			$building_id = $this->get("building_id");
			$filename = $this->get("filename");
			return "/archmap/media/buildings/001000/".$building_id."/images/".$size."/".$filename;
		}
		
		function allUrls() {
			$urls = array();
			$enums = array('50','100','300','700','1300','1700','full');
			foreach($enums as $enum) {
				$urls[$enum] = $this->url($enum);
			}
			return $urls;
		}
		
		function getBuilding() {
			if (!$building && $this->get('building_id') && $this->get('building_id') > 0) {
				$this->building = new Building($this->get('building_id'));
			}
			return $this->building;
		}
		
		function getImagePosition() {
		    $id = $this->get("id");
		    $building = $this->getBuilding();
		    $rows = $this->db->queryAssoc($building->plainImageQuery());
		    foreach($rows as $i => $row) {
		        if($row["id"] == $id) {
		            return $i;
		        }
		    }
		    return false; // didn't find it (theoretically impossible)
		}
		
		function getResultsPageNumber($perPage) {
		    return ceil($this->getImagePosition()/$perPage);
		}
		
		function where() {
			$info = array();
			$building = $this->getBuilding();
			$place = $building->getTown();
			$info['building'] = array();
			$info['place'] = array();
			$info['building']['id'] = $building->get('id');
			$info['building']['name'] = $building->get('building_name');
			if($place) {
				$info['place']['id'] = $place->get('id');
				$info['place']['name'] = $place->get('name');
			}
			$info['coords'] = $this->getLatLng();
			return $info;
		}
		
		function wherePlotted() {
			$query = "SELECT * FROM image_plot WHERE media_type = 1 AND media_id = ".$this->get("id");
			$result = $this->db->queryAssoc($query);
			$floorplan = new Image($result[0]['image_id']);
			$floorplan_url = $floorplan->url("300");
			$coords = array("x"=>$result[0]['xloc'],"y"=>$result[0]['yloc']);
			$rotation = $result[0]['rotation'];
			return array("floor_url"=>$floorplan_url,"coords"=>$coords,"rotation"=>$rotation);
		}
		
		function plot() {
			$query = "
				SELECT media_type,media_id,xloc,yloc,rotation,level,view_type,ext_int
				FROM image_plot LEFT JOIN image ON image_plot.media_id = image.id
				WHERE image_id = ".$this->get("id");
			return $this->db->queryAssoc($query);
		}
		
		// count number of times the image has been viewed,
		// called at the discretion of the image.php view
		
		function view() {
			$view_count = $this->get("views");
			$view_count++;
			$this->set("views",$view_count);
			$this->saveChanges();
		}
		
		function countViews() {
			return $this->get("views");
		}
		
		function getLatLng() {
			$building = $this->getBuilding();
			return $building->getLatLng();
		}
		
		function getKeywords() {
			$query = '
				SELECT e.id, e.name, ie.weight
				FROM lexicon_entry e, image_keyword_values ie
				WHERE ie.image_id = '.$this->get("id").'
				AND ie.keyword_id = e.id
				ORDER BY ie.weight DESC';
			$results = $this->db->queryAssoc($query);
			return $results;
		}
		
		function getImageTypes2() {
			$query = '
				SELECT t.id, t.name, i.weight
				FROM image_types t, image_image_type_values i
				WHERE i.image_id = '.$this->get("id").'
				AND i.image_type_id = t.id
				ORDER BY t.name ASC';
			$results = $this->db->queryAssoc($query);
			return $results;
		}
		
		function getTags() {
			return array_merge($this->getKeywords(),$this->getImageTypes2());
		}
		
		function getLexiconEntries() {
			// to be added later
		}
		
		function getOriginalMetadata() {
			$filename = $this->url('full');
			$output = shell_exec('exiftool -a -u -g1 -j ../../'.$filename);
			$json = json_decode($output,TRUE);
			return $json;
		}
		
		function imagetypes() {
		    $keywords = $this->getImageTypes2();
		    foreach($keywords as $k=>$v) {
		        $keywords[$k] = new ImageType($v["id"]);
		    }
		    return $keywords;
		}
		
		function lexiconentries() {
		    $keywords = $this->getKeywords();
		    foreach($keywords as $k=>$v) {
		        $keywords[$k] = new LexiconEntry($v["id"]);
		    }
		    return $keywords;
		}
		
		function slideshows() {
			if(empty($slideshows)) {
				$query = 'SELECT sh.* FROM slide sl JOIN slideshow sh ON sl.slideshow_id = sh.id
					WHERE sl.image_id='.$this->get('id');
				$results = $this->db->queryAssoc($query);
				$returns = array();
				foreach($results as $result) {
					$show = new Slideshow("ROW",$result);
					array_push($this->slideshows,$show);
				}
			}
			return $this->slideshows;
		}
		
		function beforeAndAfter() {
			$slideshows = $this->slideshows();
			$dimensions = array();
			foreach($slideshows as $key=>$slideshow) {
				$slideshows[$key] = $slideshow->beforeAndAfter($this->get("id"));
			}
			return $slideshows;
		}

		function related() {
			return $this->slideshows();
		}
		
		function previousImage() {
		   if(!$this->prevImage) {
		      $this->prevImage = $this->_traverseImages(-1);
		   }
		   return $this->prevImage;
		}
		
		function nextImage() {
		   if(!$this->nextImage) {
		      $this->nextImage = $this->_traverseImages(1);
		   }
		   return $this->nextImage;
		}
		
		function _traverseImages($increment) {
		   $id = $this->get("id");
		   $tryId = $id + $increment;
		   $try = new Image($tryId);
		   $tries = 0;
		   while(!$try->get("filename")) { // until we find a real image
		      $tryId += $increment;
		      $try = new Image($tryId);
		      $tries += 1;
		      if($tries > 100) {
		         return false;
		      }
		   }
		   return $try;
		}
		
		/* simple layout functions (mimicing javascript functionality) */
		
		function getHeightPaddingForSize($size,$offset=10) {
		   $sizes = $this->maximizeForTile($size,$size);
		   $padding = ($size-$sizes["height"])/2;
		   return ($offset+$padding)."px";
		}
		
		function getHeightForSize($size) {
		   $sizes = $this->maximizeForTile($size,$size);
		   return $sizes["height"];
		}
		
		function maximizeForTile($height,$width) {
			$ratioElement = $height/$width;
			$ratioImage = $this->get("height")/$this->get("width");
			if($ratioImage > $ratioElement) {
				return array("height"=>$height, "width"=>$this->get("width") * ($height/$this->get("height")) );
			}
			else {
				return array("width"=>$width, "height"=>$this->get("height") * ($width/$this->get("width")) );
			}
		}


		/* Methods for interfacing with image_image_type and image_element_type */
	
		function getImageTypes() {
			if (!$this->image_image_types) {
				$q = 'SELECT * FROM image_image_type_values WHERE id='.$this->get("id");
				$image_types = $this->db->queryAssoc($q);
			}
			return $image_types;
		}
		
		function addImageTypeFromList($more_image_types) {
			foreach($more_image_types as $new_image_type) {
				$this->addImageType($new_image_type);
			}
		}
		
		function addImageType($image_type_id) {
			if(is_numeric($image_type_id)) {
				$this->image_image_types[] = $image_type_id;
			} else {
				//$this->image_image_types[] = 
			}
		}
		
		// ! ------ ADD_TYPE_NAME
		function addTypeName($type) {
			$type_id = $image_typeids[$type];
			
			if ($type_id && is_numeric($type_id)) {
				$sql = 'SELECT * FROM image_image_type_values where image_id='.$this->get("id").' AND image_type_id='.$type_id;
				$res = $this->db->queryAssoc(sql);
				
				if (! $res || $res == "") {
					$command = 'INSERT INTO image_image_type_values (image_id,image_type_id) VALUES ('.$this->get("id").','.$value.')';
				}
			}
		}
		
		
		
		function getElementTypes() {
			if(!$element_types) {
				$q = 'SELECT * FROM image_keyword_values WHERE id='.$this->get("id");
				$element_types = $this->db->queryAssoc($q);
			}
			return $element_types;
		}
		
		function addElementType($element_type_id) {
			if(is_numeric($element_type_id)) {
				$this->image_element_types[] = $element_type_id;
			}
		}
		
		function addElementTypeFromList($more_element_types) {
			foreach($more_element_types as $new_element_type)
				$this->addElementType($new_element_type);
		}

		function commitTypes() {
		
			/*
			if($this->get("id") && is_numeric($this->get("id")) && $this->get("id") > 0) {
				$delete_command = 'DELETE FROM image_image_type_values WHERE image_id='.$this->get("id");
				$this->db->submit($delete_command);
				$delete_command = 'DELETE FROM image_keyword_values WHERE image_id='.$this->get("id");
				$this->db->submit($delete_command);
			}
			*/
			if($this->image_image_types) {
				//echo '<hr>image types being committed';
				foreach($this->image_image_types as $value) {
				//	echo "<br/>".$value;
					$command = 'INSERT INTO image_image_type_values (image_id,image_type_id) VALUES ('.$this->get("id").','.$value.')';
					$this->db->submit($command);
				}
			}
			if($this->image_element_types) {
				//echo 'element types being committed';
				foreach($this->image_element_types as $value) {
					$command = 'INSERT INTO image_keyword_values (image_id,keyword_id) VALUES ('.$this->get("id").','.$value.')';
					$this->db->submit($command);
				}
			}
		}
		
		
		function addKeyword($keyword) {
			$keyword_entry = new LexiconEntry("LOOKUP",$keyword);
			$id = $keyword_entry->get("id");
			if(!$id || $keyword_entry->get("isKeyword") == 0) {
				$keyword_entry = new ImageType("LOOKUP",$keyword);
				$id = $keyword_entry->get("id");
				if(!$id) return "not an image type or a keyword, sorry";
				$existing_types = $this->getImageTypes2();
				foreach($existing_types as $existant) {
					if($existant['name'] == $keyword) return "This image has that that image type";
				}
				$command = 'INSERT INTO image_image_type_values (image_id,image_type_id)
					VALUES ('.$this->get("id").','.$id.')';
				$this->db->submit($command);
				return "that image type has been added";
			}
			$existing_keywords = $this->getKeywords();
			foreach($existing_keywords as $existant) {
				if($existant['name'] == $keyword) return "This image already has that keyword";
			}
			// assuming you've gotten here, you can add the keyword, no sweat
			$command = 'INSERT INTO image_keyword_values (image_id,keyword_id)
				VALUES ('.$this->get("id").','.$id.')';
			$this->db->submit($command);
			return "it has been done";
		}
		
		function deleteKeyword($keyword) {
			$keyword_entry = new LexiconEntry("LOOKUP",$keyword);
			$id = $keyword_entry->get("id");
			if(!$id) {
				$keyword_entry = new ImageType("LOOKUP",$keyword);
				$id = $keyword_entry->get("id");
				if(!$id) return "not an image type or a keyword, sorry.";
				$existing_types = $this->getImageTypes2();
				$type_found = false;
				foreach($existing_types as $existant) {
					if($existant['id'] == $id) $type_found = true;
				}
				if(!$type_found) return "This image does not have that image type";
				$command = 'DELETE FROM image_image_type_values 
					WHERE image_id = '.$this->get("id").' AND image_type_id = '.$id;
				$this->db->submit($command);
				return "That image type ".$keyword_entry->get("name")." has been deleted.";
			}
			$existing_keywords = $this->getKeywords();
			$keyword_found = false;
			foreach($existing_keywords as $existant) {
				if($existant['name'] == $keyword) $keyword_found = true;
			}
			if(!$keyword_found) return "This image does not have that keyword.";
			// assuming you've gotten here, you can delete the keyword, no sweat
			$command = 'DELETE FROM image_keyword_values 
				WHERE image_id = '.$this->get("id").' AND keyword_id = '.$id;
			$this->db->submit($command);
			return "It has been done.";
		}
		
		function autoweightKeywords() {
			$keywords = $this->getKeywords();
			$title = strtolower($this->get("title"));
			$id = $this->get("id");
			$changes = array();
			foreach($keywords as $keyword) {
				// make sure the keyword has not previously been weighted
				if($keyword['weight'] == 3 || $keyword['weight'] == NULL) {
					$weight = "3";
					$keyword_id = $keyword["id"];
					if(strpos($title,strtolower($keyword['name'])) !== false)
						$weight++;
					$command = "
						UPDATE image_keyword_values SET weight = $weight
						WHERE image_id = $id AND keyword_id = $keyword_id";
					$this->db->submit($command);
					$changes[$keyword['name']] = "weighted to $weight";
				}
				else {
					$changes[$keyword['name']] = "unchanged";
				}
			}
			return $changes;
		}
		
		function weightTag($tag,$delta) {
			
			// need to find the id of the keyword first
			$keyword_entry = new LexiconEntry("LOOKUP",$tag);
			$id = $keyword_entry->get("id");
			if(!$id) {
				$keyword_entry = new ImageType("LOOKUP",$tag);
				$id = $keyword_entry->get("id");
				if(!$id) return "not an image type or a keyword, sorry.";
				$existing_types = $this->getImageTypes2();
				$type_found = false;
				$current_weight = 0;
				foreach($existing_types as $existant) {
					if($existant['name'] == $tag) {
						$type_found = true;
						$current_weight = $existant['weight'];
					}
				}
				if(!$type_found) return "This image does not have that image type";
				if($current_weight == "") $current_weight = 3;
				$command = 'UPDATE image_image_type_values
					SET weight = '.($current_weight+$delta).', confirmation = 1
					WHERE image_id = '.$this->get("id").' AND image_type_id = '.$id;
				$this->db->submit($command);
				return "it has been done";
			}
			$existing_keywords = $this->getKeywords();
			$keyword_found = false;
			$current_weight = 0;
			foreach($existing_keywords as $existant) {
				if($existant['name'] == $tag) {
					$keyword_found = true;
					$current_weight = $existant['weight'];
				}
			}
			if(!$keyword_found) return "This image does not have that keyword.";
			// assuming you've gotten here, you can delete the keyword, no sweat
			$command = 'UPDATE image_keyword_values 
				SET weight = '.($current_weight+$delta).', confirmation = 1
				WHERE image_id = '.$this->get("id").' AND keyword_id = '.$id;
			$this->db->submit($command);
			return "it has been done";
		}
		
		function extend_shortlist() {
			return array(
				"thumbnail" => $this->url(100),
				"small" => $this->url(300),
				"medium" => $this->url(700),
				"zoomify" => $this->buildZoomify()
			);
		}
		
		function buildZoomify() {
			$url = str_replace("_w.jpg","",$this->get("filename"));
			return "buildings__001000__".$this->get("building_id")."__zoomify__".$url;
		}
		
		function getEditableAttributes() {
			$attributes = array(
				"Rating" => array("field" => "rating"),
				"Author" => array("field" => "author_id"),
				"Exterior/Interior" => array("field" => "ext_int") );
			parent::setEditableAttributes($attributes);
			return parent::getEditableAttributes();
		}
		

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		 * THUMBNAILS
		 *
		 *
		 *
		 */
		
		
		// ! FILESYSTEM B
		function getFilesystemBsubfolderPath() 
		{	
			// of the form: 	"05/19"
			$padded = str_pad($this->get("id"), 6,'0',STR_PAD_LEFT);
			return substr($padded,0,2) .'/'.substr($padded,2,2);
		}
		
		function getFilesystemBWebPath() 
		{
			// of the form: 	"/archmap/media/images/05/19"
			return "/archmap/media/images/" . $this->getFilesystemBsubfolderPath();
		}
		
		
		function getFileSystemPath() 
		{
			// of the form: 	"/home/mgf/archmap/media/images/05/19"
			return 	$_SERVER["DOCUMENT_ROOT"] . $this->getFilesystemBWebPath();
		}
		
		function  ensureFilesystemBFolders() {
	
			$IBASE_PATH = $_SERVER["DOCUMENT_ROOT"]."/archmap/media/images";
			$id = $this->get("id");
			$padded = str_pad($id,6,'0',STR_PAD_LEFT);
			// the first folder
			$folder1 = substr($padded,0,2);
			$file_path = $IBASE_PATH."/".$folder1;
			if(!is_dir($file_path)) {
				mkdir($file_path,0777);
			}
			// the second folder
			$folder2 = substr($padded,2,2);
			$file_path .= "/".$folder2;
			if(!is_dir($file_path)) {
				mkdir($file_path,0777);
			}
	
		}



		
		function makeOneoffPath() {
	
		 	$this->ensureFilesystemBFolders();
	 	
			$this->set("filesystem","B");
			
			$localfilepath = $this->getFilesystemBsubfolderPath().'/'.$this->get('id');

			if ($this->get("image_type") == "node") 
			{
				$this->set("orig_filename",	$localfilepath);
			} else {
				$this->set("filename",		$localfilepath);
			}
			
			$this->set("filepath",			$localfilepath);
			
			$this->saveChanges();
			
			
		}
		
		
		function makeOneoffPathForOldMGF() {
			
			$this->ensureFilesystemBFolders();
			
			$localfilepath = $this->getFilesystemBsubfolderPath().'/'.$this->get('id');
			
			//$this->set("orig_filename",$this->get("filename"));
			$this->set("orig_filename", $localfilepath);
			$this->set("filepath", 		$localfilepath);
			
			// don't touch filename
			
			$this->saveChanges();
			return $file_path;
		}
		
		
		
		
		
		
		
		
		
		// PROCESS ORIGINAL
		
		function proceesUploadedOriginalFile($original) {
		
			///println('making one off of: ' . $original);
			$ext 		= $this->determineFileExtension($this->get("mimetype"));
			
			$this->makeOneoffPath();
			$path = $this->getFileSystemPath();
			
		 	$newfile 	= $path."/".$this->get("id")."_full.$ext";
		 	// copy original
			copy($original,$newfile);
			chmod($newfile,0777);
			$max = ($this->get('width') > $this->get('height')) ? $this->get('width') : $this->get('height');
			
			
				
			if ($this->get('image_type') == "node" || $this->get('image_type')== "cubic" ) 
			{
				// -- PANO CUBIC TILES --
				$this->makeCubicTiles($original);
				
				$this->set('has_sd_tiles', 3);				
				
				$this->saveChanges();
			} 
			else 
			{
				// -- SEADRAGON TILES --
				$this->makeOneoffSeaDragonTiles();
			}

			
			
			if ($max >= 1000) $this->makeOneoffIcon($original, 700, $path, $ext);
			if ($max >=  500) $this->makeOneoffIcon($original, 300, $path, $ext);
			if ($max >=  100) $this->makeOneoffIcon($original, 100, $path, $ext);
			if ($max >=   50) $this->makeOneoffIcon($original, 50, $path, $ext);
			
			unlink($original);
		}
		
	
	
		function proceesCubeTilesFromExistingCubeStrip() 
		{
			$path = $this->getFileSystemPath();
			
			$fullFile = $path.'/'.$this->get('id').'_full.jpg';
			 
			$this->makeCubicTiles($fullFile);
			
			$this->set('has_sd_tiles', 3);
			
			$this->saveChanges();
			
		}
	
		
		function makeCubicTiles($original)
		{
		
			$max = $this->get('height') - 300;
			for($face_id = 0; $face_id < 6; $face_id++)
			{
				for($size = 512; $size<$max; $size *= 2) 	
				{
					$this->makeCubicTile($original, $size, $face_id);
				}
				$this->makeCubicTile($original, 'full', $face_id);
			}	
				
		}
		
		
		function makeCubicTile($original, $size, $face_id)
		{
			$path = $this->getFileSystemPath();
			
			$originalCubeSize = $this->get('height');
			
			$posx = $face_id*$originalCubeSize;
			
			$faceNames = array("front","right","back","left","top","bottom");	
			
			$tilefile =  $path."/".$this->get("id"). '_face_'.$size.'_'.$face_id.'.jpg';
			
			if ($size == 'full')
				$size = $this->get('height');
			
			
			
			$tempImg 	= imagecreatetruecolor($size,$size);
			$src 		= imagecreatefromjpeg($original);
			imagecopyresized($tempImg, $src, 0, 0, $posx, 0, $size, $size, $originalCubeSize, $originalCubeSize);
			imagejpeg($tempImg, $tilefile, 75);
			
			
			echo "tilefile=".$tilefile.'<br>';
			//unlink($tilefile);
			
		}
		
		
		
		
		
		
		// From series of cube face originals
		function makeCubicTilesFromCubeFaceFile($original, $face_id)
		{
			$this->makeOneoffPath();
			$path = $this->getFileSystemPath();
	
			for($size = 512; $size<2500; $size *= 2) 	
			{
				$this->makeCubicTileFromCubeFaceFile($original, $size, $face_id);
			}

			// USE file to create full-sized face tile as copy
			$tilefile =  $path."/".$this->get("id"). '_face_full_'.$face_id.'.jpg';
			copy($original,$tilefile);
			chmod($tilefile,0664);
			
			
			// thumbnails
			if ($face_id == 0) 
			{
				//$this->makeOneoffIcon($original, 700, $path, "jpg");
				$this->makeOneoffIcon($original, 300, $path,  "jpg");
				$this->makeOneoffIcon($original, 100, $path,  "jpg");
				$this->makeOneoffIcon($original, 50, $path,  "jpg");				
			}
							
		}

		
		function makeCubicTileFromCubeFaceFile($original, $size, $face_id)
		{
			
			$dimens = $this->grab_data_from_imagefile($original);
			
			$this->set('width', 6*$dimens['height']);
			$this->set('height',  $dimens['height']);
			$this->saveChanges();
			
			
			$originalCubeSize = $this->get('height');
		
			$path = $this->getFileSystemPath();
			
			
			$tilefile =  $path."/".$this->get("id"). '_face_'.$size.'_'.$face_id.'.jpg';
			
			
			$tempImg 	= imagecreatetruecolor($size,$size);
			$src 		= imagecreatefromjpeg($original);
			imagecopyresized($tempImg, $src, 0, 0, $posx, 0, $size, $size, $originalCubeSize, $originalCubeSize);
			imagejpeg($tempImg, $tilefile, 75);
			
			chmod($tilefile,0664);
			
			echo "tilefile=".$tilefile.'<br>';
			
			
		}
		
		
		function makeOneoffIcon($original,$size,$path,$ext) {
			// determine fileending from mimetype
			$newfilename = $path."/".$this->get("id")."_".$size.".".$ext;

			ini_set("max_execution_time", "2000");
			ini_set("memory_limit", "256M");

			$w = $this->get('width');
			$h = $this->get('height');

			if ($this->get('image_type') == "node"  || $this->get('image_type') == "cubic") {
				// make a square cropped icon instead of the 6-tile image
				
				$posx = 0.0;
				
				$tempImg = imagecreatetruecolor($size,$size);
			
				$src = imagecreatefromjpeg($original);
				imagecopyresized($tempImg, $src, 0, 0, $posx, 0, $size, $size, $h, $h);
				imagejpeg($tempImg, $newfilename);

			} else {
				
				if ($w > $h) 
				{
					$nw = $size;
					$nh = $h * ( $nw / $w);
				} 
				else 
				{
					$nh = $size;
					$nw = $w * ( $nh / $h);
				}
				
			
				$dest = imagecreatetruecolor($nw,$nh);
				
				if($ext == "jpg") 
				{
					$src = imagecreatefromjpeg($original);
					imagecopyresampled($dest,$src, 0,0, 0,0, $nw,$nh, $w,$h);
					imagejpeg($dest, $newfilename);
				}
				elseif($ext == "gif") 
				{
					$src = imagecreatefromgif($original);
					imagecopyresampled($dest,$src, 0,0, 0,0, $nw,$nh, $w,$h);
					imagegif($dest, $newfilename);
				}
				elseif($ext == "png") 
				{
					$src = imagecreatefrompng($original);
					imagecopyresampled($dest,$src, 0,0, 0,0, $nw,$nh, $w,$h);
					imagepng($dest, $newfilename);
				}
				
			}
			
			chmod($newfilename,0664);
			
		}


		
		
		
		
		
		
		
		// PROCESS THUMBNAILS FROM GIVEN -- (DOES NOT TOUCH ORIGINAL!)
		
		function updateOneOffIcons($uploadedIconFile) {
			
			logit(" ====== ====== UPDATING ONE-OFF ICONS ======== =======");
			
			$ext 		= $this->determineFileExtension($this->get("mimetype"));
			$file_path 	= $this->getFileSystemPath();
			
			logit(" saving to: " . $file_path);
			
			
			 $this->updateOneoffIcon($uploadedIconFile, 300, $file_path, $ext);
			 $this->updateOneoffIcon($uploadedIconFile, 100, $file_path, $ext);
			 $this->updateOneoffIcon($uploadedIconFile, 50, $file_path, $ext);
			
		}
		
				
		function updateOneoffIcon($uploadedIconFile,$size,$path,$ext) {

				$dimens = GetImageSize($uploadedIconFile);
				//$size 		= filesize($newIconFile);
				$w 			= $dimens[0];
				$h 			= $dimens[1];
				$mimetype 	= $dimens[2];
				
				
				if ($w > $h) {
					$nw = $size;
					$nh = $h * ( $nw / $w);
				} else {
					$nh = $size;
					$nw = $w * ( $nh / $h);
				}
				
				$newfilename = $path."/".$this->get("id")."_".$size.".".$ext;
			
			//logit(" saving: " . $uploadedIconFile . " to " . $newfilename . ' w=' . $w. ' h=' . $h. ' nw=' . $nw. ' nh=' . $nh);
			
				$tmp_img = imagecreatetruecolor($nw,$nh);
				
				$ext = 'png';
				
				if($ext == "jpg") {
					logit('making a jpg');
					

					$src = imagecreatefromjpeg($uploadedIconFile);
					imagecopyresized($tmp_img, $src, 0,0, 0,0, $nw,$nh, $w,$h);
					imagejpeg($tmp_img, $newfilename);
				}
				elseif($ext == "gif") {
					$src = imagecreatefromgif($uploadedIconFile);
					imagecopyresampled($tmp_img, $src, 0,0, 0,0, $nw,$nh, $w,$h);
					imagegif($tmp_img, $newfilename);
				}
				elseif($ext == "png") {
					$src = imagecreatefrompng($uploadedIconFile);
					imagecopyresampled($tmp_img,$src, 0,0, 0,0, $nw,$nh, $w,$h);
					imagepng($tmp_img, $newfilename);
				}
				
				chmod($newfilename,0777);
		
		}
		
		





























		/*
		 * SEADRAGON TILES... 
		 *
		 *
		 *
		 */

		
		function makeOneoffSeaDragonTiles() {
			$ext 		= $this->determineFileExtension($this->get("mimetype"));
			
			$this->makeOneoffPath();
			$path = $this->getFileSystemPath();
			
			$sourcefile = $path."/".$this->get("id")."_full.$ext";
			
			// GENERATE TILES
			
			// Previously the tiling was done by a php script.
			// As of 2013-09-24, they are tiled using the process that Peter set up.
			
			$usePhpToTile = false;
			
			if ($usePhpToTile) {
			
				// TILES FOLDER
				$tile_dir 	= $path .'/'.$this->get("id").'_tiles';
				if (! is_dir($tile_dir)) {
					mkdir($tile_dir);
				}
	
				set_include_path(implode(PATH_SEPARATOR, array(
				    realpath($_SERVER['DOCUMENT_ROOT'].'/archmap_2/DeepZoom/lib'),
				    get_include_path(),
				)));
				require $_SERVER['DOCUMENT_ROOT'].'/archmap_2/DeepZoom/lib/Oz/Deepzoom/ImageCreator.php';

				$converter = new Oz_Deepzoom_ImageCreator();
				$converter->create( $sourcefile, $tile_dir.'/'.$this->get("id").'.xml' );
			
				$this->set('has_sd_tiles', 1);
			
			
			} else { // use server process
				
				$tiff_file   = $path."/".$this->get("id")."_full.tif";
				$destination = "/home/tiles/".$this->get("id")."_full.tif";

			// --     "/usr/bin/vips im_vips2tiff '%s' '%s':jpeg:90,tile:256x256,pyramid", filePath, destination

	//$cmd = 'convert /home/mgf/archmap/media/images/05/70/57094_full.jpg /home/mgf/archmap/media/images/05/70/57094_full.tiff';
	//$ret = system($cmd);

				$cmd ="convert " . $sourcefile . " " .$tiff_file;
				$resp = system($cmd);
				logit($cmd . " === " . $resp);
				
				$resp = $cmd = "/usr/bin/vips im_vips2tiff '".$tiff_file."' '".$destination."':jpeg:90,tile:256x256,pyramid";
				
				//$cmd = "/usr/bin/vips im_vips2tiff '%s' '%s':jpeg:90,tile:256x256,pyramid", filePath, destination
				
				logit($cmd . " === " . $resp);
				system($cmd);
				
				unlink($tiff_file);
			
				$this->set('has_sd_tiles', 2);
			}
			
			
			
			// SET NEW STATUS OF IMAGE IN THE DB
			$this->saveChanges();
		}
		
		
		
		
		function makeBourbSeaDragonTilesFromGivenSourcefile($orifinalfile) {
			//print($orifinalfile . '<hr>');
			
			if ($this->get('has_sd_tiles') == 1) {
				
				return;
			}
		
			$ext 		= $this->determineFileExtension($this->get("mimetype"));
			
			$this->makeOneoffPath();
			$path = $this->getFileSystemPath();
			
			$sourcefile = $path."/".$this->get("id")."_full.$ext";
			
			//print($sourcefile . '<br>');
		
			copy($orifinalfile, $sourcefile);
			
			$tiff_file   = $path."/".$this->get("id")."_full.tif";
			$destination = "/home/tiles/".$this->get("id")."_full.tif";

			$cmd ="convert " . $sourcefile . " " .$tiff_file;
			$resp = system($cmd);
			logit($cmd . " === " . $resp);
			
			$resp = $cmd = "/usr/bin/vips im_vips2tiff '".$tiff_file."' '".$destination."':jpeg:90,tile:256x256,pyramid";
			
			//$cmd = "/usr/bin/vips im_vips2tiff '%s' '%s':jpeg:90,tile:256x256,pyramid", filePath, destination
			
			logit($cmd . " === " . $resp);
			system($cmd);
		
			$this->set('has_sd_tiles', 2);
			
			// SET NEW STATUS OF IMAGE IN THE DB
			$this->saveChanges();
		
		}
		
		
		function makeExistingMGFBuildingSeaDragonTilesFromGivenSourcefile($orifinalfile) {
			
			
			if ($this->get('has_sd_tiles') > 0) {
				
				return;
			}
		
			$ext 		= $this->determineFileExtension($this->get("mimetype"));
			
			$this->makeOneoffPathForOldMGF();
			$path = $this->getFileSystemPath();
			
			$sourcefile = $path."/".$this->get("id")."_full.$ext";
			
			//print($sourcefile . '<br>');
		
			copy($orifinalfile, $sourcefile);
			
			$tiff_file   = $path."/".$this->get("id")."_full.tif";
			$destination = "/home/tiles/".$this->get("id")."_full.tif";

			$cmd ="convert " . $sourcefile . " " .$tiff_file;
			$resp = system($cmd);
			logit($cmd . " === " . $resp);
			
			$resp = $cmd = "/usr/bin/vips im_vips2tiff '".$tiff_file."' '".$destination."':jpeg:90,tile:256x256,pyramid";
			
			//$cmd = "/usr/bin/vips im_vips2tiff '%s' '%s':jpeg:90,tile:256x256,pyramid", filePath, destination
			
			logit($cmd . " === " . $resp);
			system($cmd);
			
			unlink($tiff_file);
		
			$this->set('has_sd_tiles', 2);
			
			// SET NEW STATUS OF IMAGE IN THE DB
			$this->saveChanges();
			
			
			//if ($max >=  500) $this->makeOneoffIcon($orifinalfile, 300, $path, $ext);
			//if ($max >=  100) $this->makeOneoffIcon($orifinalfile, 100, $path, $ext);
			//if ($max >=   50) $this->makeOneoffIcon($orifinalfile, 50, $path, $ext);

		}
	
		
		
		function makeExistingMGFBuildingSeaDragonTilesFromGivenSourcefile__OLD($sourcefile) {
			
			if ($this->get('has_sd_tiles') == 1) {
				
				return;
			}
			
			
			$ext 		= $this->determineFileExtension($this->get("mimetype"));

			$seadragonFolder = $_SERVER['DOCUMENT_ROOT'] . $this->webPathToMediaFolder() . '/seadragon';
			
			
						
			if (! is_dir($seadragonFolder)) {
				mkdir($seadragonFolder);
			}

			set_include_path(implode(PATH_SEPARATOR, array(
			    realpath($_SERVER['DOCUMENT_ROOT'].'/archmap_2/DeepZoom/lib'),
			    get_include_path(),
			)));
			
			require $_SERVER['DOCUMENT_ROOT'].'/archmap_2/DeepZoom/lib/Oz/Deepzoom/ImageCreator.php';


			// FILES OF THE FORM: 1103_00001.jpg or 1103_00001_w.jpg
		
			$parts = explode('.', $this->get('filename'));
			$filename_root = $parts[0];

			$parts = explode('_', $filename_root);
			$name = $parts[0] . '_' . $parts[1];
			
						
			$converter = new Oz_Deepzoom_ImageCreator();
			$converter->create( $sourcefile, $seadragonFolder.'/'.$name.'.xml' );
			
			$this->set('has_sd_tiles', 1);
			$this->saveChanges();
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		function removeFromDatabase() {
			// For now, for security's sake, only allow deletion of filesystem B images
			logit("Image:: REMOVING ITEM FROM DATABASE");
			if ($this->get("filesystem") == "B") {
				
				$this->removeMedia();
			
				parent::removeFromDatabase();
			}

		}


		function removeMedia() {
			$firstIdOfFilesystemB 	= 32000;
			
			$this->makeOneoffPath();
			$path = $this->getFileSystemPath();
			
			$ext 					= $this->determineFileExtension($this->get("mimetype"));
			
			if (is_numeric($this->get("id")) && $this->get("id") > $firstIdOfFilesystemB) {			
				
				$sourcefiles_prefix = $path."/".$this->get("id")."_";
			
				// remove $sourcefiles_prefix*
				if (isset($sourcefiles_prefix) && "".$sourcefiles_prefix != "") {
					unlink($sourcefiles_prefix .'50.'.$ext);
					unlink($sourcefiles_prefix .'100.'.$ext);
					unlink($sourcefiles_prefix .'300.'.$ext);
					unlink($sourcefiles_prefix .'700.'.$ext);
					unlink($sourcefiles_prefix .'full.'.$ext);
				
					$tile_dir 	= $path .'/'.$this->get("id").'_tiles';
					$syscmd = "rm -r " . $tile_dir;
					system($syscmd);
					
				}
			}
		}
		
		function webPathToMediaFolder() {
		
		
			$WEB_PATH = '/archmap/media';
			
			if ($this->get("filesystem") == "B") {
			
				$file_path = $this->getFilesystemBWebPath();
			} else {
				$building_id = $this->get("building_id");

				$WEB_PATH .= "/buildings";
			
				// MILLENIUM FOLDER
				$folder1 = str_pad( (floor($building_id / 1000) *1000), 6, '0', STR_PAD_LEFT);
				
				//  BUILDING FOLDER
				$folder2 = $building_id; 
				
				$file_path = $WEB_PATH. '/' . $folder1 . '/' . $folder2;  
				
				
			}
			
			return $file_path;
			
		}


		// ! FILESYSTEM A


		function makePath() {
		
			/* 
			 *
			 * to find an image of building serial id 34055
			 *    just forget the last two digits and break the others 
			 *    into twos
			 *    /00/03/40   would be the directory path to the image
			 */
				
			//
			$IBASE_PATH = $_SERVER['DOCUMENT_ROOT']  . '/archmap/media';
			
			$building_id = $this->get("building_id");
			if ($building_id  && is_numeric($building_id) && $building_id > 0 ) {
				
				$IBASE_PATH .= "/buildings";
				
				// MILLENIUM FOLDER
				$folder1 = str_pad( (floor($building_id / 1000) *1000), 6, '0', STR_PAD_LEFT);
				
				$file_path = $IBASE_PATH. '/' . $folder1;    
				if (! is_dir ( $file_path ) ) {
					   mkdir ( $file_path, 0777);
				}
				
				//  BUILDING FOLDER
				$folder2 = $building_id; 
				
				$file_path = $file_path . '/' . $folder2;
				if (! is_dir ( $file_path ) ) {
					   mkdir ( $file_path, 0777);
				}
				
				// IMAGES FOLDER
				$folder3 = "images"; 
				
				$file_path = $file_path . '/' . $folder3;
				if (! is_dir ( $file_path ) ) {
					   mkdir ( $file_path, 0777);
					   mkdir ( $file_path.'/full', 	0777);
					   mkdir ( $file_path.'/2000', 	0777);
					   mkdir ( $file_path.'/1700', 	0777);
					   mkdir ( $file_path.'/1300', 	0777);
					   mkdir ( $file_path. '/700', 	0777);
					   mkdir ( $file_path. '/300', 	0777);
					   mkdir ( $file_path. '/100', 	0777);
					   mkdir ( $file_path.  '/50', 	0777);
				}
				
				return $file_path;
			}

		}
		
		
		function makeIcons($original) {
		
		 	$path = $this->makePath();
		 	
		 	$newfile = $path.'/full/'.$this->get("filename");
			copy( $original, $newfile);
			chmod($newfile, 0777);

			$max = ($this->get('width') > $this->get('height')) ? $this->get('width') : $this->get('height');
			
			if ($max >= 2000) $this->makeIcon($original, 2000);

			//if ($max >= 1700) $this->makeIcon($original, 1700);
			//if ($max >= 1300) $this->makeIcon($original, 1300);
			if ($max >= 1000) $this->makeIcon($original,  700);
			if ($max >=  500) $this->makeIcon($original,  300);
			if ($max >=  100) $this->makeIcon($original,  100);
			if ($max >=   50) $this->makeIcon($original,   50);
	
		}
		
		function makeIcon($original, $size) {
			$path = $this->makePath();
			$newfilename = $path . '/' . $size . '/' . $this->get("filename");
			
			$w 		= $this->get('width');
			$h 		= $this->get('height');
			
			if ($w > $h) {
				$nw		=	$size;
				$nh		=	$h * ( $nw / $w);
			} else {
				$nh		=	$size;
				$nw		=	$w * ( $nh / $h);
			}
			
			//print($newfilename . '<hr />');
			
			
			ini_set("max_execution_time",  "1000");
			ini_set("memory_limit",			"50M");	
			
			$dest 	= imagecreatetruecolor	($nw,$nh);
			$src 	= imagecreatefromjpeg	($original);
			imagecopyresampled	($dest, $src, 0,0, 0,0,$nw,$nh,$w,$h);
			imagejpeg($dest, $newfilename);	
			return $newfilename;
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		function asXMLAttributes($incl = null)
		{
			$row = $this->attrs;
			
			if (! $incl) $incl = array_keys($row);
	
			
			$attributesString = "";
			$nestedString = "";
			for ($i=0; $i<sizeof($incl); $i++)
			{
				if (strpos($row[$incl[$i]], "\"")  || $incl[$i] == "title" || $incl[$i] == "descript" || $incl[$i] == "url"|| $incl[$i] == "type") {
					$tmp = str_replace("<br>", "<br />", $row[$incl[$i]]);
					$nestedString .= 	'<'.$incl[$i].'>'.utf8_encode(stripslashes($tmp)).'</'.$incl[$i].'>';
				
				} else {
					// attribute
					if($row[$incl[$i]] != "") {
						$attributesString .= 	$incl[$i].'="'.$row[$incl[$i]].'" ';
					}
				}
								//$xml .= 	'<'.$incl[$i].'>'.stripslashes($row[$incl[$i]]).'</'.$incl[$i].'>';
			}
			
			$attributesString .= 'urlLarge="' .$this->url('full').'" ';
			$attributesString .= 'urlMedium="'.$this->url(700).'" ';
			$attributesString .= 'urlSmall="' .$this->url(300).'" ';

			
			// opening tag with attributes
			$xml .= '<'.get_class($this) . 'Object ' .$attributesString. ' />';
			
			//$xml .= $nestedString;
			
			//$xml .= '</'.get_class($this).'Object>';
			
			return $xml;
		}
		
		
		function determineFileExtension($mimetype) {
			switch($mimetype) {
				case 1:
					return "gif";
				case 2:
					return "jpg";
				case 3:
					return "png";
				default:
					return "jpg";
			}
		}

		function grab_data_from_imagefile($image_path) {
			$dimens = GetImageSize($image_path);
			$attrs['size'] = filesize($image_path);
			$attrs['width'] = $dimens[0];
			$attrs['height'] = $dimens[1];
			$attrs['mimetype'] = $dimens[2];
			return $attrs;
		}


	}
	
?>