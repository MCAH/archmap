<?php

	
	class Feature extends Model {
	
		function Feature($arg1=0, $arg2=0) {
			$this->table = "feature";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		function entityName() {
			return "Feature";
		}
		
		function posterURL($size) {
			if (! $this->get("poster_id")) {
				return ("/archmap_2/media/ui/NoImage.jpg");
				
			}
			$posterImage = new Image($this->get("poster_id"));
			return $posterImage->url($size);
		}
		function floorplan() {
		
			$image = new Image($this->get("plan_image_id"));
			
			return $image;
		}


	}

?>