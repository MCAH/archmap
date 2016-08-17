<?php

	require_once("../Database.php");
	$db = new Database();
	
	$aliases = $db->queryAssoc("
		SELECT a.id,a.item_id,e.table_name
		FROM aliases a, entity_ids e
		WHERE a.entity_id = e.id
	");
	foreach($aliases as $alias) {
		$table = $alias["table_name"];
		$item_id = $alias["item_id"];
		$id = $alias["id"];
		$result = $db->queryAssoc("SELECT COUNT(*) as count FROM $table WHERE id = $item_id");
		if($result[0]["count"] < 1) {
			echo "$table $id";
			echo "does not exist<br/>";
			//if(isset($id)) {
			//	$db->submit("DELETE FROM aliases WHERE id = $id");
			//}
		}
	}

?>