	ini_set("memory_limit","256M");
		
		error_reporting(E_ERROR | E_PARSE);
	
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');
	
		println("All nodes");
	
	
		$db = new Database();
		
		$sql = 'select i.id, i.building_id, i.filename, i.orig_filename, i.title, i.has_sd_tiles, b.name, b.id as bid from image i, building b  where i.image_type="node" and i.building_id=b.id order by b.name, i.id asc';
		
		$rows =  $db->queryAssoc($sql);
		
