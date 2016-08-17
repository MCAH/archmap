<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/archmap/codebase/models/Model.php');

	/*
	 * SocialEntity (which is-a collection)
	 *
	 */
	 
	class SocialEntity extends Collection {
	
		function SocialEntity($arg1=0,$arg2=0) {
			parent::Collection($arg1, $arg2);
			// before we just say, "yeah, it's a social entity"
			// we should make sure it's actually a social entity
			if($this->get("is_social") == 0) {
				if(count($this->getVanillaCollectionItems()) == 0) {
					$this->set("is_social",1);
					$this->saveChanges();
				}
				else {
					return false; // this is just a collection, not a social entity
					// TODO: some way of redirecting someone who gets here
				}
			}
		}
		
		function associatePerson($person_id,$user_id,$beg_year = NULL,$end_year = NULL,$notes = "") {
			$entity = $this->add($person_id,"Person");
			$entity->set("beg_year",$beg_year);
			$entity->set("end_year",$end_year);
			$entity->set("notes",$notes);
			$entity->saveChanges();
		}
		
		function getMembers() {
			return $this->getVanillaCollectionItems();
		}
		
	}

?>