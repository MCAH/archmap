<?php
	

	/*
	 * HISTORICAL_EVENT asdf
	 *
	 */
	 
	class HistoricalObject extends Model {
	
		function HistoricalObject($arg1=0, $arg2=0) {
			$this->table = "historicalobject";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		function entityName() {
			return "HistoricalObject";
		}

		
	}

?>