<?php
	
	 
	class BuildingModel extends Model {
	
		/*
		 * maintains an array of parametric dimensions for the building
		 * the array is keyed by "zone_position_dim"
		 *
		 * example:
		 *  $val = $dims[$zoneIDs["Nave"].'_'.$j.'_'.$i];
		 *	$val = $dims["1_1_3"]
		 *
		 */
		 
		var $db;

		var $building_id;
		
		var $dims; // data from the building_dims table
		
		// ZONES
		public static $zoneIDs = array(
			"Nave" 		=> 1,
			"Transept"	=> 2,
			"Crossing"	=> 3,
			"Choir"		=> 4
		);		
		public static $zoneLabels = array(
			1 			=> "Nave",
			2 			=> "Transept",
			3 			=> "Crossing",
			4 			=> "Choir"	
		);		
		
		// POSITIONS
		public static $positionIDs = array(
			"main" 		=> 1,
			"arcade"	=> 2,
			"aisle"		=> 3,
			"wall"		=> 4
		);		
		public static $positionLabels = array(
			1 => "main",
			2 => "arcade",
			3 => "aisle",
			4 => "wall"	
		);		
		
		// DIMS
		public static $dimIDs = array(
			"apex" 		=> 1,
			"springer"	=> 2,
			"boss"		=> 3,
			"opening"	=> 4,
			"wall"		=> 5,
			"centerline"=> 6
		);		
		public static $dimLabels = array(
			1 			=> "apex",
			2 			=> "springer",
			3 			=> "boss",
			4 			=> "opening",	
			5 			=> "wall",	
			6 			=> "centerline"	
		);		



		function BuildingModel($bid) {
			
			
			
			$this->building_id= $bid;
			
			$this->db = new Database();
			//$this->db = shared_db_connection(); // access one connection rather than creating your own
			
			
			$query = 'select * from building_dims where building_id='.$this->building_id;

			$dims_rows = $this->db->queryAssoc($query);
			
			
			$this->dims = array();
			
			if ($dims_rows) {
				foreach ($dims_rows as $dims_row) {
					$this->dims[$dims_row['zone'] . '_' . $dims_row['position'] . '_' . $dims_row['dim']] = $dims_row['value'];
				}
			}
			
			
			
		}
		
		
		function getDim($zone, $position, $dim) {
			return 	$this->dims[$zone . '_' . $position . '_' . $dim];
		}
		
		function setDim($zone, $position, $dim, $val) {
								 	
		 	$whereClause = ' building_id='.$this->building_id.' and zone='.$zone.' and position='.$position.' and dim='.$dim.' ';
		 	
		 	$qc = 'select count(*) from building_dims where '.$whereClause;
		 	$rcount = $this->db->count($qc);

		 	if ($rcount && $rcount > 0) {
		 		$qu = 'update building_dims set value='.$val.' where '.$whereClause;
		 	} else {
		 		$qu = 'insert into building_dims (building_id,zone,position,dim,value) values ('.$this->building_id.','.$zone.','.$position.','.$dim.','.$val.')';
		 	}
		 	$this->db->submit($qu);
		
		}
		
		function get($field) {
			return true; // oui
		}
		
		function extend_shortlist() {
			return array(
				"dimensions" => $this->dims
			);
		}
		
		
	}

?>