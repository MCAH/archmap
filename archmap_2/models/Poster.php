<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');

	/*
	 * TOWN
	 *
	 */
	 
	class Poster extends Model {
	
		var $table = "poster";
		var $primaryKey = "id";
	
		function Poster($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
		
		function clearDuplicates($ext_int = false) {
			$building_id = $this->get("building_id");
			$type_id = $this->get("type_id");
			$isImageType = $this->get("isImageType");
			if($ext_int == "i" || $ext_int == "e") {
				$query = '
					SELECT p.id FROM poster p, image i
					WHERE p.building_id='.$building_id.'
					AND p.type_id='.$type_id.'
					AND p.isImageType='.$isImageType.'
					AND p.image_id = i.id
					AND i.ext_int = "'.$ext_int.'"';
			}
			else {
				$query = '
					SELECT id FROM poster
					WHERE building_id='.$building_id.'
					AND type_id='.$type_id.'
					AND isImageType='.$isImageType.'';
			}
			$duplicates = $this->db->queryAssoc($query);
			foreach($duplicates as $duplicate) {
				$duplicate_poster = new Poster($duplicate['id']);
				$duplicate_poster->delete();
			}
		}
		
		function delete() {
			$confirmedID = $this->get("id");
			if($confirmedID && is_numeric($confirmedID) && $confirmedID > 0) {
				$command = 'DELETE FROM poster WHERE id='.$confirmedID;
				$this->db->submit($command);
				return true;
			}
			else
				return false;
		}

		function saveChanges($ext_int = false) {
			self::clearDuplicates($ext_int);
			parent::saveChanges();
		}
		
	}



?>