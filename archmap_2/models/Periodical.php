<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');

	/*
	 * PERIODICAL
	 *
	 */
	 
	class Periodical extends Model {
	
		var $table 			= "periodical";
		var $primaryKey 	= "id";
	
		function Periodical($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
	
	}



?>