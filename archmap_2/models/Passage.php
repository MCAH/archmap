<?php

 
	/*
	 * NOTE
	 *
	 */
	 
	class Passage extends Model {
	
		var $table = "passage";
		var $primaryKey = "id";
		
	   function Passage($arg1=0, $arg2=0) {
		   parent::GenericRecord($arg1, $arg2);
		}
	
	}

?>