<?php
	// /archmap/media/buildings/001000/1047/panos/1047_vr_00001.jpg

	require_once("../Setup.php");
	$db = Utilities::getSharedDBConnection();
	
	//$syspath = $_SERVER["DOCUMENT_ROOT"];
	//$webpath = '/archmap/media/buildings/001000/1047/panos';
	//$sysdirectory = $syspath.$webpath;
	//$base = opendir($sysdirectory);
	//$sub_directories = array();
	//while($file = readdir($base)) {
	//	if($file != "." && $file != ".." && $file != ".DS_Store")
	//		array_push($sub_directories,$file."/panos");
	//}
	//closedir($base);
	//foreach($sub_directories as $sub) {
	//	$path = $syspath.$webpath."/".$sub;
	//	$base = opendir($path);
	//	while($file = readdir($base)) {
	//		if(strstr($file,".png")) {
	//			$node_name = str_replace(".png","",$file);
	//			//$file_name = str_replace(".png",".jpg",$file);
	//			$image = "<img width=300 src='/archmap/media/buildings/001000/$sub/$node_name.png'/>";
	//			$feature .= '
	//			 <a target="_blank" href="nodes/'.$node_name.'">'.$image.'</a>
	//			 ';
	//		}
	//	}
	//	closedir($base);
	//}
	
	function grab_metadata($filepath) {
		$output = shell_exec("exiftool -a -u -g1 -j $filepath");
		$json = json_decode($output,TRUE);
		return array("json"=>$json,"raw"=>$output);
	}
	
	function grab_data_from_filename($filename) {
		$attrs['filename'] = str_replace(".jpg","",$filename);
		$parts = explode("_", $filename);
		$attrs['building_id'] = $parts[0];
		return $attrs;
	}
	
	function parse_types_from_keywords($json) {
		$types = array();
		$keywords = null;
		$elem_types = getElementTypes();
		$image_types = getImageTypes();
		$this_image_types = array();
		$this_element_types = array();
		$drawing = false;
		
		if(is_array($json[0]["IPTC"]["Keywords"])) {
			foreach($json[0]["IPTC"]["Keywords"] as $keyword) {
				$keywords .= strtolower($keyword).";";
				if(strtolower($keyword) == 'interior')
					$interior_or_exterior = "i";
				else if(strtolower($keyword) == 'exterior')
					$interior_or_exterior = "e";
			}
			$keywords = substr_replace($keywords,'',-1,1); // no trailing semicolon
		}
		else
			$keywords = strtolower($json[0]["IPTC"]["Keywords"]);
		
		
		$keys_to_check = explode(";",$keywords);
		
		foreach($keys_to_check as $key_to_check) {
			foreach($direction_types as $key=>$direction_type) {
				if($key_to_check == $direction_type)
					$direction = $key;
			}
			foreach($image_types as $image_type) {
				if($key_to_check == $image_type['name']) {
					array_push($this_image_types,$image_type['id']);
				}
			}
			foreach($elem_types as $elem_type) {
				if($key_to_check == $elem_type['name']) {
					array_push($this_element_types,$elem_type['id']);
				}
			}
		}
		
		// if it's not a drawing, it's a photograph
		if(!$drawing)
			array_push($this_image_types,"1");
		
		// prepare data for shipping
		$types['interior_or_exterior'] = $interior_or_exterior;
		$types['direction'] = $direction;
		$types['keywords'] = $keywords;
		$types['element_types'] = $this_element_types;
		$types['image_types'] = $this_image_types;
		
		return $types;
	}
	
	function format_iptc($json,$keywords) {
		
		$IPTC_goods = array(
			"Headline"=>"title",
			"Credit"=>"pages",
			"Source"=>"publication_id",
			"By-line"=>"author",
			"By-lineTitle"=>"author_status");
		
		// authors ids lookup table
		$authors["Stephen D Murray"] = 288;
		$authors["Andrew J Tallon"] = 338;
		$authors["Rory ONeill"] = 339;
		$authors["Nicole Griggs"] 	= 340;
		$authors["M Jordan Love"] 	= 341;
		$authors["Zachary D Stewart"] = 357;
		
		// keywords
		if(array_key_exists("Keywords",$json[0]["IPTC"])) { $attrs["keywords"] = $keywords; }
		
		// rating
		if($json[0]["XMP-xmp"]["Rating"])
			$attrs["rating"] = $json[0]["XMP-xmp"]["Rating"];
		
		// date taken
		if($json[0]["XMP-xmp"]["CreateDate"])
			$attrs["originaldate"] = $json[0]["XMP-xmp"]["CreateDate"];
		
		// miscellaneous iptc data
		foreach($IPTC_goods as $perlName=>$dbName) {
			if(!empty($json[0]["IPTC"][$perlName])) {
				if(!is_numeric($json[0]["IPTC"][$perlName]))
					$attrs[$dbName] = addslashes($json[0]["IPTC"][$perlName]);
				else
					$attrs[$dbName] = $json[0]["IPTC"][$perlName];
			}
		}
		// author ids
		if(array_key_exists($attrs['author'],$authors))
			$attrs['author_id'] = $authors[$attrs['author']];

		return $attrs;
	}
	
	
	
	/* ================= */
	/* === utilities === */
	/* ================= */
	
	function getElementTypes() {
		global $db;
		$query = 'SELECT * FROM lexicon_entry WHERE isKeyword=1';
		$rows = $db->queryAssoc($query);
		foreach($rows as $row) {
			$keyword = $row['name'];
			$etypes[$keyword] = $row;
		}
		return $etypes;
	}
	
	function getImageTypes() {
		global $db;
		$query = 'SELECT * FROM image_types';
		$rows = $db->queryAssoc($query);
		foreach($rows as $row) {
			$typekey = $row['id'];
			$i_types[$typekey] = $row;	
		}
		return $i_types;
	}
	
	// main loop
	
	header("Content-type:text/plain"); // the little things in life
	; /// intentional syntax error
	$id = Utilities::sanitizeString($_GET["bid"]);
	if(!$id) {
		exit();
	}
	foreach($db->queryAssoc("SELECT id FROM building WHERE id = $id") as $row) {
		$bid = $row["id"];
		echo $bid."\n\n\n";
		$path = $_SERVER["DOCUMENT_ROOT"]."/archmap/media/buildings/001000/$bid/panos";
		$dir = opendir($path);
		while($file = readdir($dir)) {
			if(strstr($file,".jpg")) {
				$attrs = array();
				$attrs["image_type"] = "node";
				$attrs = array_merge($attrs,grab_data_from_filename($file));
				$metadata = grab_metadata($path."/".$file);
				$json = $metadata["json"];
				$types = parse_types_from_keywords($json);
				$attrs = array_merge($attrs,format_iptc($json,$types['keywords']));
				//print_r($attrs);
				// see if the node already exists
				$node = new Node("KEYS",$attrs);
				if($node->get("id")) {
					$nodeid = $node->get("id");
					echo "\n\n$nodeid already exists.\n\n";
				}
				else {
					echo "\n\n---> does not exist.\n\n";
					print_r($attrs);
					$node->saveChanges();
					$node->addElementTypeFromList($types["element_types"]);
					$node->commitTypes();
					echo "\t\tsaved.";
				}
				//$node = new Node();
				//foreach($attrs as $key=>$attr) {
				//	$node->set($key,$attr);
				//}
				//$node->saveChanges();
				//$node->addElementTypeFromList($types["element_types"]);
				//$node->commitTypes();
			}
		}
		closedir($dir);
	}
	
?>