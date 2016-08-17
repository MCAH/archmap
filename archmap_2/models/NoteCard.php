<?php
	

	/*
	 * NOTECARD
	 *
	 */
	 
	class NoteCard extends Model {
	
		function NoteCard($arg1=0, $arg2=0) {
			$this->table = "notecard";
			parent::GenericRecord($arg1, $arg2);
		}
		
		
		
		
		function getItems($className, $asJSON = true) {
			
			
			
			$public_statusClause = " ";
			$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.beg_year';
			switch ($className) {
				case "Building":
					$table 		= "building";
					break;
					
				case "NoteCard":
					$table 		= "notecard";
					$public_statusClause = " AND public_status > 0";
					break;
					
				case "Publication":
					$table 		= "publication";
					$selectItems .= ', i.date';
					break;
				
				default:
					return null;
			
			}
			$rel_table 	= "z_essay_".$table;
			
			switch ($className) {
				case "Building":
					$sql = 'SELECT '.$selectItems.' FROM '.$rel_table.' r, '.$table.' i WHERE r.essay_id=' . $this->get("id") .' and r.'.$table.'_id=i.id '.$public_statusClause;
					break;
					
				case "NoteCard":
					$sql = 'SELECT '.$selectItems.' FROM '.$rel_table.' r, '.$table.' i WHERE r.essay_id=' . $this->get("id") .' and r.'.$table.'_id=i.id '.$public_statusClause;
					break;
					
				case "Publication":
					$sql = 'SELECT '.$selectItems.', (select p.name from person p, publication_authors pa where pa.pub_id=i.id and pa.person_id=p.id limit 0, 1) as contributors  from z_essay_publication r, publication i where r.essay_id='.$this->get("id").' and r.publication_id=i.id;';
					break;
				
				default:
					return null;
			
			}
			
			$rows = $this->db->queryAssoc($sql);
			
			
			$trows = array();
			foreach($rows as $row) {
				$tmp = new Building($row);
				$trows[] = $tmp->getEncodedAttrs();
			}
			
			if ($asJSON) {
				return json_encode($trow);
			} else {
				return $trows;
			}
		}
		
		
		
		
		
		
		
	}

?>