<?php
	

	/*
	 * ESSAY
	 *
	 */
	 
	class Essay extends Model {
	
		function Essay($arg1=0, $arg2=0) {
			$this->table = "essay";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		
		function getAuthor() {
			
			return new Person($this->get('author_id'));
		}
		
		
		
		
		
	}

?>