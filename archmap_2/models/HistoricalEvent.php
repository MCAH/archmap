<?php
	

	/*
	 * HISTORICAL_EVENT asdf
	 *
	 */
	 
	class HistoricalEvent extends Model {
	
		function HistoricalEvent($arg1=0, $arg2=0) {
			$this->table = "historicalevent";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		function entityName() {
			return "HistoricalEvent";
		}

		
	}

?>