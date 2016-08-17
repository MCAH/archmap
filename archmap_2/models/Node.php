<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  .'/archmap/codebase/models/GenericRecord.php');

	/*
	 * Node extending image
	 * the only real differences
	 * being the way you access certain things
	 * like thumbnails are stuff like that
	 * so that summary is different and the
	 * get has specialized functionality
	 *
	 */
	 
	class Node extends Image {
		
		function Node($arg1=0, $arg2=0) {
			parent::Image($arg1, $arg2);
			// TODO figure out some way to reject images that are not nodes here
		}
		
		// deprecated
		function summarize() {
			$path = "/archmap/media/buildings/001000/".$this->get("building_id")."/panos/";
			$summary = parent::summarize();
			$summary = $summary["Node"]; // get rid of its container
			$summary["attributes"]["medium"] = $path.$this->get("filename").".png";
			$summary["attributes"]["thumbnail"] = $path.$this->get("filename").".jpg";
			$summary["attributes"]["swf"] = $path.$this->get("filename").".swf";
			unset($summary["attributes"]["small"]);
			unset($summary["attributes"]["zoomify"]);
			unset($summary["attributes"]["publication_id"]);
			return array(get_class($this)=>$summary);
		}
		
		// hmm.... this is unnecessary if "get" is always smart....
		function extend_shortlist() {
			return array(
				"medium" => $this->get("medium"),
				"swf" => $this->get("swf"),
				"thumbnail" => $this->get("thumbnail")
			);
		}
		
		function url($size) {
			$extension = ".png"; // default, matches "medium"
			if($size == "thumbnail") { $extension = ".jpg"; }
			elseif($size == "swf") { $extension = ".swf"; }
			return "/archmap/media/buildings/001000/".$this->get("building_id")
				."/panos/".$this->get("filename").$extension;
		}
		
		function get($key) {
			if($key == "medium" || $key == "swf" || $key == "thumbnail") {
				return $this->url($key);
			}
			if($key == "name") {
				return $this->get("title");
			}
			return parent::get($key);
		}

	}
	
?>