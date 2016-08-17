<?php
	
	require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/GenericRecord.php');

	/*
	 * PlotPoint
	 *
	 */
	 
	class PlotPoint extends Model {
	
		var $table = "image_plot";
		var $primaryKey = "id";
	
		function PlotPoint($arg1=0, $arg2=0) {
			parent::GenericRecord($arg1, $arg2);
		}
		
		function clearDuplicates() {
			$image_id = $this->get("image_id");
			$media_id = $this->get("media_id");
			$media_type = $this->get("media_type");
			$query = '
				SELECT *
				FROM image_plot
				WHERE image_id='.$image_id.'
				AND media_id='.$media_id.'
				AND media_type='.$media_type.'';
			$duplicates = $this->db->queryAssoc($query);
			foreach($duplicates as $duplicate) {
				print_r($duplicate);
				$duplicate_point = new PlotPoint($duplicate['id']);
				$duplicate_point->delete();
			}
		}
		
		function delete() {
			$confirmedID = $this->get("id");
			if($confirmedID && is_numeric($confirmedID) && $confirmedID > 0) {
				$command = 'DELETE FROM image_plot WHERE id='.$confirmedID;
				$this->db->submit($command);
				return true;
			}
			else
				return false;
		}
		
		function saveChanges() {
			echo $this->get("level")."<br/>";
			self::clearDuplicates();
			parent::saveChanges();
			echo $this->get("level")."<br/>";
		}
	}



?>