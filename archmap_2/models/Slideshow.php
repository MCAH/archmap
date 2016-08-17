<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Slide.php');

	/*
	 * A slideshow
	 *
	 */
	 
	class Slideshow extends Model {
	
		var $table = "slideshow";
		var $primaryKey = "id";
	
		function Slideshow($arg1=0, $arg2=0) { parent::GenericRecord($arg1, $arg2); }
		
		function getSearchKey() { return $this->get("name"); }
		
		/* build a slideshow from a json data structure */
		/* may want to implement other ways to do this, but why? */
		
		function build_from($json_string) {
			// TODO :: CAPTIONS
			$data = json_decode(stripslashes($json_string),true);
			if($data) { // making sure it was json
				$this->clearAssociatedSlides();
				foreach($data["data"] as $d) {
					$this->addOneSlide($d["id"],$d["caption"],$d["benchmark"]);
				}
			}
		}
		
		function addOneSlide($image_id,$caption,$benchmark = 0) {
			$slide = new Slide();
			$slide->set("slideshow_id",$this->get("id"));
			$slide->set("image_id",$image_id);
			$slide->set("caption",$caption);
			$slide->set("benchmark",$benchmark);
			$slide->set("sortval",$this->countSlides()+1);
			$slide->saveChanges(); // should it not be doing this?
			return $slide;
		}
		
		/* Delete duplicates of a certain image id, so it can be appended again */
		
		function clearDuplicateSlides($image_id) {
			$s_id = $this->get("id");
			if(isset($image_id,$s_id) && is_numeric($s_id) && is_numeric($image_id)) {
				$query = "DELETE FROM slide WHERE slideshow_id = $s_id AND image_id = $image_id";
				$rows = $this->db->submit($query);
				//echo $query;
			}
		}
		
		function clearAssociatedSlides() {
			$confirmedID = $this->get("id");
			// maybe there should be a forced saveChanges() here?
			if($confirmedID && is_numeric($confirmedID) && $confirmedID > 0) {
				$command = 'DELETE FROM slide where slideshow_id='.$confirmedID;
				$this->db->submit($command);
				return true;
			}
			else return false;
		}
		
		/*
			How many slides are there in this slideshow?
		*/
		function countSlides() {
			$slides = $this->getSlides();
			return sizeof($slides);
		}
		
		/*
			Provides an array of Slide objects representing all slides in this slideshow
		*/
		function getSlides() {
			$query = 'SELECT * from slide where slideshow_id="'.$this->get("id").'" ORDER BY sortval ASC';
			$slides = $this->db->queryAssoc($query);
			$slideObjects = array();
			if(!empty($slides)) {
				foreach($slides as $key=>$slide) {
					$slideObjects[$key] = new Slide($slide['id']);
					//$slideObjects[$key] = $newSlide;
				}
			}
			return $slideObjects;
		}
		
		// TEMPORARY
		function getSlideSummaries() {
			$slides = $this->getSlides();
			foreach($slides as $key=>$slide) {
				$slides[$key] = $slide->summarize();
			}
			return $slides;
		}
		
		function getSlidesSimple() {
			$query = 'SELECT image_id from slide where slideshow_id="'.$this->get("id").'" ORDER BY sortval ASC';
			$slides = $this->db->queryAssoc($query);
			return $slides;
		}
		
		function beforeAndAfter($image_id) {
			$query = "SELECT * FROM slide WHERE image_id = $image_id AND slideshow_id = ".$this->get("id");
			$rows = $this->db->queryAssoc($query);
			if($rows) {
				$pos = $rows[0]['sortval'];
				$query = "SELECT sortval,i.* FROM slide s JOIN image i ON s.image_id = i.id
					WHERE slideshow_id = ".$this->get("id")." AND (sortval = $pos-1 OR sortval = $pos+1)
					ORDER BY sortval";
				$result = $this->db->queryAssoc($query);
				$return = array();
				foreach($result as $image) {
					if($image["sortval"] < $pos) {
						$return["before"] = new Image("ROW",$image);
					}
					else {
						$return["after"] = new Image("ROW",$image);
					}
				}
				return $return;
			}
			else return false;
		}
		
		function extend_shortlist() {
			return array("slides"=>$this->getSlides());
		}
		
		// deprecated
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"id" => $this->get("id"),
				"name" => $this->get("name"),
				"building_id" => $this->get("building_id")
			);
			$summary["slides"] = $this->getSlideSummaries();
			return array(get_class($this)=>$summary);
		}
		
	}
?>