<?php

   require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');

	/*
	 * NOTE
	 *
	 */
	 
	class Note extends Model {
	
		var $table = "note";
		var $primaryKey = "id";
		
	   function Note($arg1=0, $arg2=0) {
		   parent::GenericRecord($arg1, $arg2);
		}
	
	}

?>