<?php
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/archmap/codebase/models/Model.php');

	/*
	 * META (for getting/setting permissions and input types on fields in database)
	 */
	 
	class Meta extends Model {
		
		var $dummy;
		
		function Meta($arg1=0,$arg2=0) {
			$this->table = "meta";
			
			if($arg1 == "KEYS") {
				$keys = $arg2;
			}
			elseif($arg1 == "ID") { // you gotta stretch for compatability!
				$parts = split("::",$arg2);
				$keys = array("model" => $parts[0], "field" => $parts[1]);
			}
			else {
				$keys = array("model" => $arg1, "field" => $arg2);
			}
			parent::GenericRecord("KEYS",$keys);
		}
		
		function get($field) {
			if($field == "id") {
				return strtolower($this->get("model")."::".$this->get("field"));
			}
			if($field == "rangetop") {
				$value = parent::get("rangetop");
				if(is_numeric($value)) {
					return $value;
				}
				else {
					return 10;
				}
			}
			return parent::get($field);
		}
		
		function editableFeatures() {
			$shortlist = $this->shortlist(); // soooo meta
			$keys = array_keys($shortlist["Meta"]);
			$fields = array();
			foreach($keys as $key) {
				$fields[$key] = new Meta("ID","Meta::$key");
			}
			return $fields;
		}
		
		function requirements() {
			return self::objectify($this->dummy_object()->creation_requirements(),"Meta");
		}
		
		function nonrequirements() {
			return self::objectify($this->dummy_object()->creation_nonrequirements(),"Meta");
		}
		
		function dummy_object() { // return an instantiated subclass model to use
		  if(!$this->dummy) {
		    $class = str_replace("_","",$this->get("model"));
  			$this->dummy = new $class(); // dummy object
		  }
		  return $this->dummy;
		}
		
	}

?>