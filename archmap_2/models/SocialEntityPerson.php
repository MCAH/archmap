<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Model.php');

	/*
	 * SocialEntityPerson
	 *
	 */
	 
	class SocialEntityPerson extends Model {
	
		function SocialEntityPerson($arg1=0, $arg2=0) {
			$this->table = "socialentity_item";
			parent::GenericRecord($arg1, $arg2);
		}
		
		function summarize() {
			$summary = array();
			$summary["attributes"] = array(
				"id"=>$this->get("id"),
				"beg_year"=>$this->get("beg_year"),
				"end_year"=>$this->get("end_year")
			);
			$summary["notes"] = $this->get("notes");
			$person = new Person($this->get("person_id"));
			$summary["person"] = $person->summarize();
			return array(get_class($this)=>$summary);
		}
		
	}

?>