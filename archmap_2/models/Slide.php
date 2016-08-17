<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/Database.php');

	/*
	 * A slide
	 *
	 */
	 
	class Slide extends Model {
	
		var $table = "slide";
		var $primaryKey = "id";
	
		function Slide($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
		
		function getSearchKey() {
			return $this->get("name");
		}
		
		function url($size) {
			$newImage = new Image($this->get('image_id'));
			return $newImage->url($size);
		}
		
		// the image at the heart of the slide
		function getImage() {
			return new Image($this->get("image_id"));
		}
		
		function extend_shortlist() {
			return array("image" => $this->getImage());
		}
		
		// deprecated
		function summarize() {
			$summary = array();
			$summary["id"] = $this->get("id");
			$summary["benchmark"] = $this->get("benchmark");
			$summary["caption"] = $this->get("caption");
			$image = new Image($this->get("image_id"));
			$summary["image"] = $image->summarize();
			return array(get_class($this)=>$summary);
		}
	
	} // end of the class

?>