<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Model.php');

	/*
	 * HISTORICAL_EVENT
	 *
	 */
	 
	class SocialEntity extends Model {
	
	
		function SocialEntity($arg1=0, $arg2=0) {
			$this->table = "socialentity";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
	}



?>