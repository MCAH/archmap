<?php

	require_once ($_SERVER['DOCUMENT_ROOT'].'/archmap/codebase/models/GenericRecord.php');
	
	class Story extends Collection {
		
		var $table;
		
		function Story($arg1=0,$arg2=0) {
			$this->table = "collection";
			// DOESN'T WORK YET
			if(is_numeric($arg2) === false) {
				$arg2 = $this->lookupWithSlug($arg2);
			}
			parent::Collection($arg1,$arg2);
		}
		
	}

?>