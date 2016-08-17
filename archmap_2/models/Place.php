<?php

	/*
	 * PLACE
	 *
	 */
	 
	class Place extends Model {
	
	
		function Place($arg1=0, $arg2=0) {
			$this->table = "place";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		function entityName() {
			return "Place";
		}
		
		
	}

?>