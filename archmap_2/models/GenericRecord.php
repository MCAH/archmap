<?
	
	class GenericRecord {
		
		/*
			An  class meant to hand basic db transaction
		*/
		
		var $attrs;	
		var $lockedKeys;	
		var $isNew;
	
		var $db;
		
		var $table = "people";
		var $primaryKey = "id";
		
		var $tables;
		var $columns;
		
		var $temp_id;
		
		var $depth;
		
		var $editable_attributes = array(
			"Latitude"=> array("field" => "lat"),
			"Longitude"=> array("field" => "lng") );
			
			
	
			
			
		function db() {
			return $db;
		}
		function tableName() {
			return $this->table;
		}
		function primaryKey() {
			return $this->primaryKey;
		}
		
		function out() {
			println('<pre>');
			print_r($this->attrs);
			println('</pre>');
			printline();
		}
		
		function GenericRecord($arg1="", $arg2="", $record = true) {
			$this->db = Utilities::getSharedDBConnection(); // access one connection rather than creating your own
			$this->setLockedKeys();
			
			if ($arg1 == "") $arg1 = "NEW";
			
			if (is_numeric($arg1)) 
			{	// Allow to instantiate by simply passing an id number
				$arg2 = $arg1;
				$arg1 = 'ID';
			} else if (is_array($arg1)) {
				$arg2 = $arg1;
				$arg1 = 'ROW';		
			} 
			
			switch ($arg1) {
			
				case "ID":
					if ($arg2)	{
						$query 	= 'SELECT * FROM '.$this->tableName().' WHERE '.$this->primaryKey().'='.$arg2;
						
						
						$result = $this->db->queryAssoc($query);
						$this->initFromAssocRow($result[0]);
						
						
					} else {
						$this->initNew();
					}
					break;
	
				case "URLALIAS":
					if ($arg2)	{
						$query 	= 'SELECT * FROM '.$this->tableName().' WHERE urlalias ="'.$arg2.'"';
						
						
						$result = $this->db->queryAssoc($query);
						$this->initFromAssocRow($result[0]);
						
						
					} else {
						$this->initNew();
					}
					break;
	
				
				case "ROW":
						$id = $arg2['id'];
						
						
						if ($id && $id != "" && is_numeric($id)) {
							// first get the row
							$query 	= 'SELECT * FROM '.$this->tableName().' WHERE '.$this->primaryKey().'='.$id;
							$result = $this->db->queryAssoc($query);

							$this->initFromAssocRow($result[0]);


							$this->updateFromAssocRow($arg2);
							

						} else {
							$this->initFromAssocRow($arg2);
						}

						break;
	
		
				case "KEYS":
					if ($arg2)
					{		
						$this->getColumns();
											
						foreach($arg2 as $key=>$val) {
							if($this->columns[$key])  
							{
								if ( ! is_numeric($val) ) {
									$val = addslashes($val);
								}	
								$this->takeValueForKey($key, $val);
								if (! $keyValPairs) 
								{
									$keyValPairs 	 = 			$key.'="'.$val .'"';
								} else {
									$keyValPairs 	.= ' and '.	$key.'="'.$val .'"';
								}
							}
						}	
						
						$query = 'SELECT * FROM '.$this->tableName().' WHERE  '.$keyValPairs;
						$result = $this->db->queryAssoc($query);
	
						if ($result[0]) {
							$this->initFromAssocRow($result[0]);
							
							
						} else {
							$this->initFromAssocRow($arg2);
							$this->isNew = true;
						}
					}	
					break;
		
				
				case 'COPY':
					$this->initFromAssocRow($arg2->attrs);
					foreach ($this->primaryKey as $pk) 
					{
						$this->attrs[$pk] = null;
					}
					break;
					
				
				default:
					$this->initNew();
			}
			if($record == true) {
				//$this->recordObjectsConstruction();
			}

		}
		/*
		function recordObjectsConstruction() {
			// make sure there is an id first
			$key = strtolower(get_class($this))."/".$this->get("id");
			$viewer_id = $_SERVER["REQUEST_URI"]; // some database function for this?
			$user = Utilities::getCurrentUser();
			$base = $_SERVER["HTTP_HOST"];
			$full = $_SERVER["REQUEST_URI"];
			$command = "INSERT INTO statistics 
				VALUES(NULL,'".$key."','".$user->get("id")."','".$base."','".$full."') ";
			$this->db->submit($command);
		}
		*/







		
		function getViewCount() {
			$query = "SELECT COUNT(*) as count FROM statistics WHERE model_key = '".$this->getHashKey()."'";
			$result = $this->db->queryAssoc($query);
			return $result[0]["count"];
		}
		
		function getHashKey() {
			return strtolower(get_class($this))."/".$this->get("id");
		}
		
		function initNew()
		{
			$this->isNew = true;
			$this->setDefaultValuesForAttrs();
		}
		
		function setLockedKeys()
		{
	
		}
		
		function getEntity_id($table_name) {
		
			$q = 'select id from entity_ids where table_name="'.strtolower($table_name).'"';
			$rows = $this->db->query($q);
			if ($rows) {
				return $rows[0][0];
			}
		}
		function getEntity_id_ByClassname($classname) {
			$q = 'select id from entity_ids where name="'.$classname.'"';
			$rows = $this->db->query($q);
			if ($rows) {
				return $rows[0][0];
			}
		}
	
		
		
		function initFromAssocRow($row = 0)
		{
			if ($row) 	$this->attrs = &$row;
			$this->checkValues();
		}
		
		function updateFromAssocRow($row = 0)
		{
			if ($row) 	$this->attrs = array_merge($this->attrs, $row);
			$this->checkValues();
		}
		
		function &attributes()
		{
			return $this->attrs;
		}
		
		
		
		
		function setDefaultValuesForAttrs() 
		{
			if (! $this->valueForKey('createdate')) 	$this->takeValueForKey('createdate', rightNow());
		}	
	
		function checkValues() 
		{
			// ABSTRACT
			
		}
		
		function isLockedKey($attrName) 
		{
			return $this->lockedKeys[$attrName];
		}
	
		function getColumnsFromTable($table = 0) 
		{
			if($table) 
			{
				$query = 'show columns from '.$table;
				$result = $this->db->queryAssoc($query);
				
				if($result) 
				{
					foreach ($result as $row) 
					{			
						$columns[$row['Field']] = $row['Type'];	
					}
					return $columns;
				}
			}
		}
	
		function getColumns() 
		{
			if(! $this->columns) 
			{
				$query = 'show columns from '.$this->table;
				$result = $this->db->queryAssoc($query);
				
				if($result) 
				{
					foreach ($result as $row) 
					{			
						$this->columns[$row['Field']] = true;	
					}
				}
			}
			return $this->columns;
		}
		
		function getTables() 
		{
			if(! $this->tables) 
			{
				$q = 'show tables';
				$rows = $this->db->queryAssoc($q);
				
				
				if($rows) {
					foreach ($rows as $key => $val) 
					{			
						$this->tables[$val['Tables_in_arch_map']] = true;	
					}
				}
			}
			return $this->tables;
		}
		
		
		function setEditableAttributes($more_attributes) {
			$this->editable_attributes = array_merge($more_attributes,$this->editable_attributes);
		}
		
		function getEditableAttributes() {
			foreach($this->editable_attributes as $human => $computer) {
				$this->editable_attributes[$human]['value'] = $this->get($computer['field']);
				if(!$this->editable_attributes[$human]['value'])
					$this->editable_attributes[$human]['value'] = "n/a";
			}
			return $this->editable_attributes;
		}
		
		
		
		function getSearchKey() {
	
			return makeSearchKey();
			
		}
		function makeSearchKey() {
			// some tables don't have names, such as "building_elements"
			if($this->get("searchkey")) {
				return $this->get("searchkey");
			}
			return $this->get("name");
			
		}
	
		function isNew() {
			
			$id = $this->get('id');
			
			
			if (isset($id) && $id != "" && ! is_numeric($id)) {
				// there is an id, but it is not numeric -- assume it is a temporary id and save as 'temp_id'
				$this->temp_id = $id;
				$this->set('id', null);
			}
			
			$id = $this->get('id');
			
			
			if  (! isset($id) || $id == "") {
				return true;
			} else {
				return false;
			
			}
		
		}
		
		function saveChanges() {
		
		
			$this->getColumns();
			$this->checkValues();
			$this->set("metaphone", metaphone($this->get('name')));
			$this->set("contributors_metaphone", metaphone($this->get('contributors')));

			$this->set("name", strip_tags($this->get("name")));
					
			if ( $this->isNew() ) {
				$this->db__insert();
			} else {
				$this->db__update();
			}
			
			//$this->updateAliases();
			
			
		}
		
		function saveChangesIfNew() {
			if ( $this->isNew() ) {
				$this->saveChanges();
			}
		}

		
		
		
		function updateAliases() {
			if ($this->get("name") !== "" && $this->table != "element_types") {
				$entity_id  	= $this->getEntity_id($this->table);
				$item_id 		= $this->get("id");
				$name 			= $this->get("name");
				
				$name_plural	= $this->get("name_plural");
				$metaphone 		= $this->get("metaphone");
				$lang 			= $this->get("lang");
				
				if ( isset($entity_id) && isset($item_id) && isset($name) && $name != "") {
					$q = 'DELETE FROM aliases WHERE entity_id='.$entity_id.' AND item_id='. $item_id . ' AND name="'.$name.'"';
					
					
					$this->db->submit($q);
					
					$q = 'INSERT INTO aliases (entity_id,item_id,name,name_plural,metaphone,lang) 
					VALUES ('.$entity_id.','.$item_id.',"'.$name.'","'.$name_plural.'","'.$metaphone.'","'.$lang.'")';
					$this->db->submit($q);
				}
				
			}
		}
		
		
		
		function generatePrimaryKeyForTable($tableName, $primaryKeyName)
		{
			// assume :  [ ] the EO_PK_TABLE exists
			// remember: [ ] the value of the PK in the row must be >= the MAX($this->primaryKey()) in the actual table
			$query = 'LOCK TABLE `EO_PK_TABLE` WRITE, '.$tableName.' READ';
			$this->db->submit($query);
			
					$query = 'SELECT PK FROM `EO_PK_TABLE`  WHERE NAME = "'.$tableName.'"';
					$result = $this->db->query($query);
					$primaryKeyValue = $result[0][0];
												
					if ($primaryKeyValue) 
					{
							$primaryKeyValue++;
							$this->takeValueForKey($primaryKeyName, $primaryKeyValue);
							$query = 'UPDATE `EO_PK_TABLE` SET PK = '.$primaryKeyValue.' WHERE NAME="'.$tableName.'"';
					} else {
							$query = 'SELECT max('.$primaryKeyName.') FROM '.$tableName;
							$result = $this->db->query($query);
							$primaryKeyValue = $result[0][0];
							$primaryKeyValue++;
							$this->takeValueForKey($primaryKeyName, $primaryKeyValue);
							$query = 'INSERT INTO `EO_PK_TABLE` (NAME, PK) VALUES ("'.$tableName.'",'.$primaryKeyValue.')';
					}  
					$this->db->submit($query);
	  
			$query = 'UNLOCK TABLES';
			$this->db->submit($query);
			
			return $primaryKeyValue;
	
		}
		
		function db__insert() 
		{
			if ($this->attrs)
			{
				// STEP FROM LOWEST TABLE TO HIGEST 
				//		-- WHEN NAME OF PK CHANGES, GENERATE NEW KEY
				//		-- AND INCLUDE OLD PK-VAL PAIR AS KEY-VAL 


				$keys = null;
				$vals = null;
				$columns = $this->getColumnsFromTable($this->table);
				
				
				
				//if (! $primaryKeyValue ) 
				if ($this->primaryKey)
				{
					if (! $primaryKeyValue || ($this->primaryKey != $prevPrimaryKeyName && $columns[$prevPrimaryKeyName]) ) 
					{
						$primaryKeyValue = $this->generatePrimaryKeyForTable($this->table, $this->primaryKey);
	
					} else {
						// EX: takeValueForKey('pageid', $textid);
						$this->set($this->primaryKey, $primaryKeyValue);
					}
				}
				
				
				// Since we now have set a new primaryKey, we can insert...
				foreach($this->attrs as $key=>$val) {
					
					
					if($columns[$key] && $val &&  ! $this->isLockedKey($key))  
					{
						if ( ! is_numeric($val) ) 	$val = addslashes($val);
						
						if (! $keys) {
							$keys 	 = 			$key;
							$vals 	 = 	'"'.	$val .'"';
						} else {
							$keys 	.=  ','.	$key;
							$vals 	.= ',"'.	$val .'"';
						}
					}
				}	
				if($columns['createdate'] && ! $this->attrs['createdate']) {
							$keys 	.=  ','.	'createdate';
							$vals 	.= ',"'.	rightNow().'"';
				}
				if($columns['editdate'] && ! $this->attrs['editdate']) {
							$keys 	.=  ','.	'editdate';
							$vals 	.= ',"'.	rightNow().'"';
				}
			
				$query = 'INSERT INTO '.$this->table.' ('.$keys.') VALUES ('.$vals.')';
				logIt($query);
				$this->db->submit($query);
				
				
				// refresh from db
				$query 	= 'SELECT * FROM '.$this->tableName().' WHERE '.$this->primaryKey().'='.$this->get('id');
				$result = $this->db->queryAssoc($query);
				$this->initFromAssocRow($result[0]);
							

				// eliminate any key=>vals not represented in the table
				// remove any bricabrac that came in a $_REQUEST object
				
				$this->attrs = array_intersect_key($this->attrs, $columns);
				
			}			
		}
		
	
		function db__update() 
		{
		
			if ($this->attrs)
			{
				if($this->valueForKey($this->primaryKey))
				{
					$columns = $this->getColumnsFromTable($this->table);
	
					// VERSIONING SYSTEM
					// if there is a "vers_" table for this table, support versioning by first copying the current row to the vers_ table
					$tables = $this->getTables();
	
					$ver_table = 'vers_'.$this->tableName();
					
					
					if ($tables[$ver_table] != null) {
						$query = 'SELECT * FROM '.$this->tableName().' WHERE '.$this->primaryKey.'='.$this->valueForKey($this->primaryKey);

						$rows = $this->db->queryAssoc($query);
						
						if ($rows) {
							$vers_row = $rows[0];
							
							foreach($columns as $key=>$val) {
								
								
								if ( ! is_numeric($val) ) 	$val = addslashes($val);
								
								if (! $keys) {
									$keys 	 = 			$key;
									$vals 	 = 	'"'.	$vers_row[$key] .'"';
								} else {
									$keys 	.=  ','.	$key;
									$vals 	.= ',"'.	$vers_row[$key] .'"';
								}
							}
						}
						$query = 'INSERT INTO '.$ver_table.' ('.$keys.') VALUES ('.$vals.')';

						//$this->db->submit($query);

	
					}
					// VERSIONING SYSTEM
					
					$keyValPairs = null;
					
					foreach($this->attrs as $key => $val) {
						if($columns[$key] && ! $this->isLockedKey($key))  
						{
							if ( ! is_numeric($val) ) {
								$val = addslashes($val);
							}	
							
							if ($val == "" ) {
							 	$valval = "NULL";
							} else {
								$valval = '"'.$val .'"';
							}
							if ( $key != $this->primaryKey) 
							{
								if (! $keyValPairs) 
								{
									$keyValPairs 	 = 		$key.'='.$valval;
								} else {
									$keyValPairs 	.= ','.	$key.'='.$valval;
								}
							}
						}
					}	
					if($columns['editdate'] ) {
						$keyValPairs 	.= ',editdate="'.rightNow().'"';
					}

					
					if (! $this->primaryKey != $this->valueForKey($this->primaryKey)) // protect from case of "WHERE pageid=pageid"
					{
						if($keyValPairs)
						{
							$query = 'UPDATE '.$this->table.' SET '.$keyValPairs.' WHERE '.$this->primaryKey.'='.$this->valueForKey($this->primaryKey);
							$this->db->submit($query);
						}
					}
					
					// eliminate any key=>vals not represented in the table
					// remove any bricabrac that came in a $_REQUEST object
					$this->attrs = array_intersect_key($this->attrs, $columns);

				}
			}	
		}
	
	
	
	
		// ! ******************** THE BIG DELETE
		function removeFromDatabase() {
		
			logit("GenericRecord:: REMOVING ITEM FROM DATABASE");
			
			if ($this->table == "imageview" || $this->table == "feature" || $this->table == "passage" || $this->table == "essay" || $this->table == "notecard" || $this->table == "image" || $this->table == "publication" || $this->table == "building") {
			
				
				$table_name	= $this->table;
				$entity_id	= $this->getEntity_id($table_name);
				$id 		= $this->get("id");
				
				if (! isset($table_name)) return;
				
				// [1.] remove any relations incolving this model
				if ( isset($entity_id) && is_numeric($entity_id) && isset($id) && is_numeric($id) ) {
					$sql = 'DELETE FROM z_related_entities 
								   WHERE ( (from_entity_id='.$entity_id.' AND from_id='.$id . ') OR (to_entity_id='.$entity_id.' AND to_id='.$id . ') )';
					$this->db->submit($sql);
				}
				
				// [2.] now remove the model
				if ($id && is_numeric($id) && $id > 0) {
					$sql = 'DELETE FROM ' .$this->table .' WHERE id='.$id;
					$this->db->submit($sql);
				}
				
			}
		}
	
	
		// ! ******************** RELATIONS
		function addRelation($model, $relationship, $catnum) {
			
			$from_entity_id = $this->getEntity_id($this->table);
			$to_entity_id 	= $this->getEntity_id($model->table);

			if (getEntity($from_entity_id) == 'Building' &&  getEntity($to_entity_id) == 'Image' ) {
				$model->set('building_id', $this->get('id'));
				$model->saveChanges();
				return;
			}
			if (getEntity($from_entity_id) == 'Image' &&  getEntity($to_entity_id) == 'Building' && $relationship == 'depiction') {
				$this->set('building_id', $model->get('id'));
				$this->saveChanges();
				return;
			}
			if (getEntity($from_entity_id) == 'Building' &&  getEntity($to_entity_id) == 'Image' && $relationship == 'mainplan') {
				$building = new Building($from_id);
				$building->set('plan_image_id', $model->get('id'));
				$building->saveChanges();
				return;
			}
			
			if ($relationship && $relationship != "null") $reltionshipClause = ' AND relationship="'.$relationship.'"';
			
			$sql = '   SELECT count(*) 
						 FROM z_related_entities 
						WHERE from_entity_id='.$from_entity_id.' 
						  AND from_id ='.$this->get('id').' 
						  AND to_entity_id ='.$to_entity_id.'   
						  AND to_id ='.$model->get('id') . $reltionshipClause;
			$count = $this->db->count($sql);
			
			if ($count < 1) {
				if ($relationship) {
					$sql = 'insert into z_related_entities (from_entity_id, from_id, to_entity_id, to_id, createdate, relationship) values ('.$from_entity_id.','.$this->get('id').', '.$to_entity_id.', '.$model->get('id').',"'.rightNow().'","'.$relationship.'")';
				
				} else {
					$sql = 'insert into z_related_entities (from_entity_id, from_id, to_entity_id, to_id, createdate) values ('.$from_entity_id.','.$this->get('id').', '.$to_entity_id.', '.$model->get('id').',"'.rightNow().'")';
				
				}
				$this->db->submit($sql);
			} 
			if ($catnum) {
				$sql = 'UPDATE z_related_entities SET catnum="'.$catnum.'" 						
						WHERE from_entity_id='.$from_entity_id.' 
						  AND from_id ='.$this->get('id').' 
						  AND to_entity_id ='.$to_entity_id.'   
						  AND to_id ='.$model->get('id') . $reltionshipClause;
				$this->db->submit($sql);
			}
			
		}
	
	
		function removeRelation($model, $relationship) {

			$from_entity_id = $this->getEntity_id($this->table);
			$to_entity_id 	= $this->getEntity_id($model->table);
			
			if ($relationship) {
				$reltionshipClause = ' AND relationship="'.$relationship.'"';			
			} else {
				$reltionshipClause = ' AND (relationship IS NULL OR relationship="undefined")';
			}
			$whereClause = 'WHERE ( (	from_entity_id='.$from_entity_id.' 
									AND from_id ='.$this->get('id').' 
									AND to_entity_id ='.$to_entity_id.' 
									AND to_id ='.$model->get('id')  .'
									) 
									OR
									(	from_entity_id='.$to_entity_id.' 
									AND from_id ='.$model->get('id').' 
									AND to_entity_id ='.$from_entity_id.' 
									AND to_id ='.$this->get('id') .'
									) )
									' . $reltionshipClause;
			
			$sql = 'SELECT count(*) FROM z_related_entities '.$whereClause;
						
			
			logIt($sql);
			$count = $this->db->count($sql);
			
			if ($count >= 1) {
				$sql = 'DELETE FROM z_related_entities '.$whereClause;
				logIt($sql);
				$this->db->submit($sql);
			}
		}
		
		
		
		
		
		
				
		
	
		function getRelatedItemsCount($to_entity, $relationship) {

			$from_entity 	= getEntity($this->get('entity_id'));
			
			$from_entity_id = $this->getEntity_id($this->table);
			$from_id 		= $this->get('id');
			$to_entity_id 	= $this->getEntity_id($to_entity);
			
			$table 			= strtolower($to_entity);

			if ($relationship && $relationship != "") {
				if ($relationship == "any") {
					$relationshipClause .= ' ';
				} else {
					$relationshipClause .= ' AND z.relationship="'.$relationship.'"';
				}
				
			} else {
				
				$relationshipClause .= ' AND z.relationship IS NULL';
			}
	




			if ($from_entity == "Person" && $to_entity == "Image" && $relationship == "uploaded") {
				$sql = 'SELECT count(*) FROM image i WHERE author_id='.$from_id; 
				
			} else if ($from_entity == "Person" && $to_entity == "Essay" && $relationship == "author") {
				$sql = 'SELECT count(*) FROM '.$table.' i WHERE author_id='.$from_id; 
			
			} else if ($from_entity == "Building" && $to_entity == "Image" && $relationship == "depiction") {
				$sql = 'SELECT count(*) FROM '.$table.' i WHERE building_id='.$from_id; 
				
			}else if ($from_entity == "Building" && $to_entity == "Image" && $relationship == "panorama") {
				$sql = 'SELECT count(*) FROM '.$table.' i WHERE building_id='.$from_id . '  AND (i.image_type="node" OR  i.image_type="cubic" OR  i.image_type="pano")'; 
				
			} else if ($from_entity == "Publication"  && $to_entity == "Image" && $relationship == "source") {
			
				$sql = 'SELECT count(*) 
								FROM  z_related_entities z  
								WHERE ( 
										(z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").'  AND  z.to_entity_id='  .$to_entity_id.')
								   ||   (z.to_entity_id='  .$from_entity_id.' AND z.to_id='  .$this->get("id").'  AND  z.from_entity_id='.$to_entity_id.')
								   		)'  . $relationshipClause;
			} else  {
			
				$sql = 'SELECT count(*) 
								FROM  z_related_entities z  
								WHERE ( 
										(z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").'  AND  z.to_entity_id='  .$to_entity_id.')
								   ||   (z.to_entity_id='  .$from_entity_id.' AND z.to_id='  .$this->get("id").'  AND  z.from_entity_id='.$to_entity_id.')
								   		)'  . $relationshipClause;
			
				//$sql = $this->constructRelatedItemsSQL(' count(*) ', $to_entity, $relationship);
			}
			
			
			
			$count = $this->db->count($sql);
						
			return $count;		
		}
		
		
	
	
	
	
	
		function getRelatedItems($to_entity, $asJSON = true, $relationship = "any") {
			$from_entity 	= getEntity($this->get('entity_id'));
			
			$from_entity_id = $this->getEntity_id($this->table);
			$from_id 		= $this->get('id');
			
			$to_entity_id 	= $this->getEntity_id($to_entity);
			
			
			$public_statusClause = " ";
			
			
			if ($to_entity == "ImageView") {
				$sql = 'select iv.id as imageview_id,iv.pan, iv.name, iv.tilt, iv.fov,  i.id as image_id, i.image_type, i.filepath, i.filename, i.filesystem,  i.has_sd_tiles from imageview iv, z_related_entities z, image i where z.from_entity_id='.$from_entity_id.' AND from_id='.$from_id.' AND to_entity_id='.$to_entity_id.' AND z.to_id=iv.id AND i.id=iv.image_id';
				$rows = $this->db->queryAssoc($sql);
				
				for ($i=0; $i<sizeof($rows); $i++)
				{
					$iv = new ImageView($rows[$i]);
					$rows[$i]['webpath'] = $iv->getFilesystemBWebPath();
					//printline($rows[$i]['webpath']);				
				}
				
								
				if ($asJSON) {
					return json_encode($rows);
				} else {
					return $rows;
				}
				
			}
			
			
			
			
			
			$incl = array();
			
			$incl[] = "id";
			$incl[] = "entity_id";
			$incl[] = "name";
			$incl[] = "lat";
			$incl[] = "lng";
			$incl[] = "lat2";
			$incl[] = "lng2";
			$incl[] = "beg_year";
			
			$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.lat2, i.lng2, i.beg_year';
			
			
			
			
			$table 		= strtolower($to_entity);
			switch ($to_entity) {
				case "ImageView":
					$selectItems 	= 'i.id, i.image_id, i.name, i.pan, i.tilt, i.fov';
					$incl[] = "id";
					$incl[] = "image_id";
					$incl[] = "name";
					$incl[] = "pan";
					$incl[] = "tilt";
					$incl[] = "fov";
					$incl[] = "webpath";
					
					break;
				case "Person":
				case "HistoricalEvent":
				case "HistoricalObject":
				case "Place":
					$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.beg_year, z.pages, z.catnum';
					break;
					
				case "Essay":
					$selectItems 	= 'i.id, i.entity_id, i.name, i.urlalias, i.lat, i.lng, i.beg_year, i.subtype, i.landingimage_id, i.mapimage_id, z.pages, z.catnum';
					$incl[]		 	= "urlalias";
					$incl[]		 	= "subtype";
					$incl[]		 	= "landingimage_id";
					$incl[]		 	= "mapimage_id";
					break;
					
				case "Feature":
					$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.beg_year, i.descript, i.subtype, i.provenance, i.tags, i.refnum, i.poster_id, i.plan_image_id, z.pages,  z.pos_x, z.pos_y, z.pos_z, z.catnum';
					$incl[]		 	= "subtype";
					$incl[] 		= "descript";
					$incl[] 		= "provenance";
					$incl[] 		= "tags";
					$incl[] 		= "refnum";
					
					$incl[] 		= "pos_x";
					$incl[] 		= "pos_y";
					$incl[] 		= "pos_z";
					$incl[] 		= "plan_image_id";
					$incl[] 		= "poster_id";
					break;
					
				case "NoteCard":
					$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.beg_year, i.descript, i.cardtype, i.public_status, i.author_id, z.pages,  z.catnum, z.relationship';
					$incl[] = "descript";
					$incl[] = "cardtype";
					$incl[] = "public_status";
					$incl[] = "pages";
					$incl[] = "author_id";
					$incl[] = "editdate";
					$incl[] = "relationship";
					
				case "Passage":
					$selectItems 	= 'i.id, i.entity_id, i.name, i.lexicon_entry, i.lat, i.lng, i.beg_year, i.descript, i.cardtype, i.public_status, i.author_id, z.pages,  z.catnum, z.relationship';
					$incl[] = "lexicon_entry";
					$incl[] = "descript";
					$incl[] = "cardtype";
					$incl[] = "public_status";
					$incl[] = "pages";
					$incl[] = "author_id";
					$incl[] = "editdate";
					$incl[] = "relationship";

					break;


				case "Building":
					//if ($from_entity == "Image" ) {
					//	$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.beg_year, i.style, i.poster_id, i.plan_image_id, i.lat_section_image_id, i.long_section_image_id';
				//	} else {
						$selectItems 	= 'i.id, i.entity_id, i.name, i.lat, i.lng, i.beg_year, i.date, i.style, i.poster_id, i.plan_image_id, i.lat_section_image_id, i.long_section_image_id, i.preservation, i.prec_stories, i.prec_windows, geo_precision, z.pages, z.pos_x, z.pos_y, z.pos_z, z.catnum';
						$incl[] = "style";
						$incl[] = "poster_id";
						$incl[] = "plan_image_id";
						$incl[] = "lat_section_image_id";
						$incl[] = "long_section_image_id";
						$incl[] = "pages";
						$incl[] = "date";
						$incl[] = "beg_year";
						$incl[] = "descript";
						$incl[] = "pos_x";
						$incl[] = "pos_y";
						$incl[] = "pos_z";
						$incl[] = "catnum";
						$incl[] = "prec_stories";
						$incl[] = "prec_windows";
						$incl[] = "prec_elong";
						//$incl[] = "preservation";
						
						$incl[] = "geo_precision";
						$incl[] = "related_count";
				//	}
					break;
					
				case "Publication":
					$selectItems = 'i.id, i.entity_id, i.name, i.container_title, i.contributors, i.authors, i.editors, i.volume, i.url, i.lat, i.lng, i.beg_year, i.date, i.type,  i.pubtype, i.pages as jpages, i.publisher, i.location, i.isCatalog, WC_coverid, z.pages, z.catnum';
					$incl[] = "date";
					$incl[] = "publisher";
					$incl[] = "type";
					$incl[] = "pubtype";
					$incl[] = "container_title";
					
					$incl[] = "location";
					$incl[] = "isCatalog";
					$incl[] = "WC_coverid";
					$incl[] = "contributors";
					$incl[] = "authors";
					$incl[] = "editors";
					$incl[] = "jpages";
					$incl[] = "url";
					$incl[] = "pages";
					$incl[] = "catnum";
					break;
				
				case "Image":
					$selectItems = 'i.id, i.entity_id, building_id, i.filepath, i.filename, i.orig_filename,  i.title,  i.caption, i.image_type, i.element_type, i.mimetype, i.filesystem, i.has_sd_tiles, i.width, i.height, i.scale_abs, i.author_id, i.editdate';
					$incl[] = "filename";
					$incl[] = "orig_filename";

					$incl[] = "filepath";
					$incl[] = "building_id";
					$incl[] = "title";
					$incl[] = "caption";
					$incl[] = "image_type";
					$incl[] = "element_type";
					$incl[] = "mimetype";
					$incl[] = "filesystem";
					$incl[] = "has_sd_tiles";
					$incl[] = "width";
					$incl[] = "height";
					$incl[] = "cen_x";
					$incl[] = "cen_y";
					$incl[] = "orien";
					$incl[] = "scale_abs";
					$incl[] = "author_id";
					$incl[] = "editdate";
					$incl[] = "pan";
					$incl[] = "tilt";
					$incl[] = "fov";
					if ($from_entity == "Building" && ($relationship == "depiction" || $relationship == "panorama") || $to_entity == "Image" && $relationship == "uploaded") {
						
					} else {
						
						if ($from_entity == "Building" && $relationship == "drawing") {
							
							$b = new Building($from_id);
							$b->ensurePlansHaveZ_Related_Entities();
						}
						$selectItems .= ', z.pos_x, z.pos_y, z.pos_z, z.axis, z.ang';
						$incl[] = "pos_x";
						$incl[] = "pos_y";
						$incl[] = "pos_z";
						$incl[] = "axis";
						$incl[] = "ang";
					}
					break;
				
				default:
					return null;
			
			}
			
			$selectItems .= ', i.editdate';
			
			$sql = $this->constructRelatedItemsSQL($selectItems, $to_entity, $relationship);
			
			//printline($to_entity);
			
			//if ($to_entity != "Image") {
			//}
			
			//println($sql);
			
			$rows = $this->db->queryAssoc($sql);
			
			$trows = array();
			
			
			foreach($rows as $row) {
				
				$cmd = 'return new '.$to_entity.'($row);';
				$tmp = eval($cmd);
				$tmp->set('partial', true);
				
				$tmp_attrs = $tmp->getEncodedAttrs($incl);
				
				
				$posterSize = ($_REQUEST['posterSize']) ? $_REQUEST['posterSize'] : 100;
				
				
				if ($to_entity == "Building") {
					//print("<br>BUILDING ====================================".$row['name']." </br>");
					$tmp_attrs['plan_url'] 		= $tmp->floorplanURL(100);
					$tmp_attrs['plan_url300'] 	= $tmp->floorplanURL(300);
					
					$tmp_attrs['latsec_url'] 	= $tmp->lat_sectionURL(100);
					
					
					$tmp_attrs['poster_url'] 	= $tmp->posterURL(100);
					$tmp_attrs['poster_url300'] 	= $tmp->posterURL(300);
					
					$poster = new Image($tmp_attrs['poster_id']);
					if ($poster && $poster.attrs.id) {
						$tmp_attrs['poster'] = $poster->getEncodedAttrs($incl);
					}
					
					$plan = new Image($tmp_attrs['plan_image_id']);
					if ($plan && $plan.attrs.id) {
						$tmp_attrs['planImage'] = $plan->attrs;
					}
					$latsec = new Image($tmp_attrs['lat_section_image_id']);
					if ($latsec && $latsec.attrs.id) {
						$tmp_attrs['latsecImage'] = $latsec->attrs;
					}
				//print_r($tmp_attrs);
				//println("<hr>");
					
				} else if ($to_entity == "Feature") {
					$tmp_attrs['poster_url'] 	= $tmp->posterURL(100);
					$tmp_attrs['poster_url300'] 	= $tmp->posterURL(300);
					$poster = new Image($tmp_attrs['poster_id']);
					if ($poster && $poster.attrs.id) {
						$tmp_attrs['poster'] = $poster->getEncodedAttrs($incl);
					}
					$plan = new Image($tmp_attrs['plan_image_id']);
					if ($plan && $plan.attrs.id) {
						$tmp_attrs['planImage'] = $plan->attrs;
					}

				} else if ($to_entity == "Passage") {
				
					$author = new Person($tmp_attrs['author_id']);
					if (strpos($author->attrs['name'], ','));
					$nameParts = explode(', ', $author->attrs['name']);
					
					$tmp_attrs['author_name'] =$nameParts[1] . ' ' . $nameParts[0];
			
					$editdatetime = new DateTime(trim($tmp_attrs['editdate']));
					$tmp_attrs['editdateString'] = $editdatetime->format( 'M d, Y' );
				
				
				} else if ($to_entity == "Image") {
					$tmp_attrs['urlLarge'] 		= $tmp->url('full');
					$tmp_attrs['url100'] 		= $tmp->url(100);
					$tmp_attrs['url300'] 		= $tmp->url(300);
					
					$author = new Person($tmp_attrs['author_id']);
					
					if (strpos($author->attrs['name'], ','));
					$nameParts = explode(', ', $author->attrs['name']);
					
					$tmp_attrs['author_name'] =$nameParts[1] . ' ' . $nameParts[0];
			
					$editdatetime = new DateTime(trim($tmp_attrs['editdate']));
					$tmp_attrs['editdateString'] = $editdatetime->format( 'M d, Y' );
				}
				else if ($to_entity == "ImageView") {
					$tmp_attrs['webpath'] =	"yoyoyo";//	 $tmp->getFilesystemBWebPath();
					
				}
				
				
				
				$trows[] = $tmp_attrs;
				
			}
			
				
		
			
			
			
			//print_r();
			//printline('here');
			
			if ($asJSON) {
			//println("HERE ");
			//print_r($trows);
			//printline('here');
				
			
				return json_encode($trows);
			} else {
				return $trows;
			}
		}
		



		function constructRelatedItemsSQL($selectItems, $to_entity, $relationship) {
			$from_entity_id = $this->get('entity_id');
			$from_entity 	= getEntity($from_entity_id);
			$from_id 		= $this->get('id');
			//$to_entity_id 	= $this->getEntity_id($to_entity);
			$to_entity_id 	= $this->getEntity_id_ByClassname($to_entity);
			
			
			$table 			= strtolower($to_entity);

			
			if ($relationship && $relationship != "" && $relationship != "undefined" ) {
				if ($relationship == "any" ) {
					$relationshipClause .= ' ';
				
				} else {
					$relationshipClause .= ' AND z.relationship="'.$relationship.'"';
				}
				
			} else {
				
				$relationshipClause .= ' AND z.relationship IS NULL';
			}
			
			
			if ($this->get('isCatalog')) {
				$order_by = ' ORDER BY 0+z.pages, 0+z.catnum';
			} else  if ($to_entity == "Building") {
				$order_by = ' ORDER BY name asc';
			} else  if ($to_entity == "Essay") {
				$order_by = ' ORDER BY public_status desc, name asc';
			} else {
				$order_by = ' ORDER BY name';
			}
			
			
					
			switch ($to_entity) {
				case "Person":
				case "HistoricalEvent":
				case "HistoricalObject":
				case "Feature":
				case "Place":
				case "ImageView":
				
					$sql = 'SELECT '.$selectItems.' 
								FROM   z_related_entities z, '.$table.' i  
								WHERE (z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").' AND  z.to_entity_id=' . $to_entity_id.' AND z.to_id=i.id '.$relationshipClause.')
								   || (  z.to_entity_id='.$from_entity_id.' AND z.to_id=' . $this->get("id").' AND  z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id '.$relationshipClause.')
								'.$public_statusClause . $order_by;
					//printline($sql);
					break;
									
				case "NoteCard":
				case "Passage":
				case "Essay":
				
					if ($to_entity == "NoteCard") $order_by = ' ORDER BY z.pages, i.createdate DESC';
					if ($relationship == "author") {
						$sql = 'SELECT  i.id, i.entity_id, i.name, i.urlalias, i.lat, i.lng, i.beg_year 
								FROM   '.$table.' i  
								WHERE  i.author_id='.$from_id;
					
					} else {
						$sql = 'SELECT  '.$selectItems.' 
								FROM   z_related_entities z, '.$table.' i  
								WHERE (z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").' AND  z.to_entity_id=' . $to_entity_id.' AND z.to_id=i.id '.$relationshipClause.')
								   || (  z.to_entity_id='.$from_entity_id.' AND z.to_id=' . $this->get("id").' AND  z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id '.$relationshipClause.')
								'.$public_statusClause . $order_by;
					}
					
					//printline($sql);
					break;
									
									
										
				case "Publication":
					$sql = 'SELECT '.$selectItems.' 
				
								FROM   z_related_entities z, publication i 
								WHERE ((z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").' AND   z.to_entity_id=' . $to_entity_id.' AND z.to_id=i.id '.$relationshipClause.')
								   OR (  z.to_entity_id='.$from_entity_id.' AND z.to_id=' . $this->get("id").' AND   z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id '.$relationshipClause.'))
								ORDER BY i.authors, i.name, i.volume';
					//$relationship = 'author';
					/*
					$sql = 'SELECT '.$selectItems.', 
									(SELECT p.name from person p, z_related_entities z where (z.from_entity_id=60 AND z.from_id=i.id and to_entity_id=50 AND p.id=z.to_id) 
									|| (z.to_entity_id=60 AND z.to_id=i.id and from_entity_id=50 AND p.id=z.from_id) limit 0, 1) 
									AS contributors  
								FROM   z_related_entities z, publication i 
								WHERE ((z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").' AND   z.to_entity_id=' . $to_entity_id.' AND z.to_id=i.id '.$relationshipClause.')
								   OR (  z.to_entity_id='.$from_entity_id.' AND z.to_id=' . $this->get("id").' AND   z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id '.$relationshipClause.'))
								ORDER BY contributors, i.name, i.volume';
					//$relationship = 'author';
					*/
					break;
				
			case "Building":
				
				//if ($from_entity == "Image" ) {
				//		$sql = 'SELECT '.$selectItems.' from image im, building i WHERE   im.id='.$from_id.' AND i.id=im.building_id';
				//} else {	
					/*
					$sql = 'SELECT '.$selectItems.' 
								FROM   z_related_entities z, '.$table.' i  
								WHERE (z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").' AND  z.to_entity_id=' . $to_entity_id.' AND z.to_id=i.id '.$relationshipClause.')
								   || (  z.to_entity_id='.$from_entity_id.' AND z.to_id=' . $this->get("id").' AND  z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id '.$relationshipClause.')
								'.$public_statusClause . $order_by;
					*/
					$sql = 'SELECT '.$selectItems.', (SELECT count(*) FROM z_related_entities z WHERE ( (z.from_entity_id=40 AND z.from_id=i.id) || (z.to_entity_id=40 AND z.to_id=i.id ) ) ) as related_count  
								FROM   z_related_entities z, '.$table.' i  
								WHERE (z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").' AND  z.to_entity_id=' . $to_entity_id.' AND z.to_id=i.id '.$relationshipClause.')
								   || (  z.to_entity_id='.$from_entity_id.' AND z.to_id=' . $this->get("id").' AND  z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id '.$relationshipClause.')
								'.$public_statusClause . $order_by;
					//printline($sql);
				//}
				break;
			
			
			case "Image":
				
				// really two selects here... one for buildings and the other from z_related_entities
					
					
					//$tail = ' AND has_sd_tiles=1 ORDER BY i.has_sd_tiles DESC, i.rating DESC, i.id ASC LIMIT 0,320';

					$tail = ' ORDER BY i.orig_filename, i.id ASC, i.rating DESC LIMIT 0,500';

					if ($from_entity == "Building" && $relationship == "panorama") {
						
						$sql = 'SELECT '.$selectItems.' from image i, building b 
								WHERE   b.id='.$from_id.' AND b.id=i.building_id  AND (i.image_type="node" OR  i.image_type="cubic" OR  i.image_type="pano") ' .$tail;
					
					} else if ($from_entity == "Building" && $relationship == "depiction") {
						
						$sql = 'SELECT '.$selectItems.' from image i, building b 
								WHERE   b.id='.$from_id.' AND b.id=i.building_id  ' .$tail;
					
					} else if ($from_entity == "Person" && $relationship == "uploaded") {
						$sql = 'SELECT '.$selectItems.' FROM image i WHERE (author_id=' . $this->get("id") . ' OR edit_author_id=' . $this->get("id") . ') ORDER BY i.id DESC limit 0, 1000';
											

					
					} else {
						$sql = 'SELECT '.$selectItems.' 
								FROM  z_related_entities z, '.$table.' i  
								WHERE ((z.from_entity_id='.$from_entity_id.' AND z.from_id='.$this->get("id").'  AND   z.to_entity_id='.$to_entity_id.' AND z.to_id=i.id)
								   || (z.to_entity_id='.$from_entity_id.' AND z.to_id='.$this->get("id").' AND   z.from_entity_id='.$to_entity_id.' AND z.from_id=i.id)) 
								'.$public_statusClause .$relationshipClause . $tail;
					
					}
					//printline($sql);
					
					break;

				default:
					return null;
			
			}
		
		
			return $sql;
		}





		
	
		// PARENT
		function getParent() {
			if ($this->get('parent_id')) {
				$cmd = 'return new '.get_class($this).'('.$this->get('parent_id').');';
				$parent = eval($cmd);
				
				return $parent;
			}
		}
	
		// PARENT
		function addParent($model) {
			
			$this->set('parent_id', $model->get('id'));
			
		}
		// ADD_CHILD
		function addChild($model) {
			
			$model->set('parent_id', $this->get('id'));
			
		}
	
	
	
		// ! ATTRIBUTES (from table)
		
		function getAttributes($asJSON = false) {
		
			$subtype = $this->get("subtype");
			
			if (isset($subtype)) {
				$subtypeClause = ' and s.subtype="'.$this->get("subtype").'" ';
			}
			
			$sql = 'select s.id as sheet_id, attr.id as attr_id, attr.name, attr.datatype, av.val from attribute_sheet s left join attribute_sheet_item si on si.sheet_id=s.id left JOIN  attribute attr ON si.attr_id=attr.id  left join attribute_value av on av.attr_id=attr.id and av.item_id='.$this->get('id').' where s.entity_id=170 '.$subtypeClause.' and  s.author_id=363'; 
			$rows = $this->db->queryAssoc($sql);
			
			//printline($sql);
			
			if ($asJSON) {
				return json_encode($rows);
			} else {
				return $rows;
			}
			
			
		}
		

		function getFeatures($subtype, $withAttributes, $asJSON) {
			if (isset($subtype))
				$subtupeClause = ' AND subtype="'.$subtype.'" ';
			
			$sql = 'select f.* from feature f, `z_related_entities` z WHERE from_entity_id=40 AND from_id='.$this->get('id').' AND to_entity_id=170 '.$subtupeClause.' AND to_id=f.id';
		
			$rows = $this->db->queryAssoc($sql);
		
			if ($asJSON) {
				return json_encode($rows);
			} else {
				return $rows;
			}

		}
	
		
	
		function getImagePlots($image_id) {
		
			
			$sql = 'SELECT z.*,f.id, f.name from `z_related_entities` z, feature f WHERE from_entity_id=110 AND from_id='.$image_id.' AND f.id=z.to_id';
			
			$rows = $this->db->queryAssoc($sql);
		
			if ($asJSON) {
				return json_encode($rows);
			} else {
				return $rows;
			}
			
		}
	
	
		// ! ******************** UTILITIES
	
		function getEntities($prefix = 0) {
			
			if ($prefix) {
			
				if ($this->attrs) {
					foreach ($this->attrs as $key => $val) {
						$keys[$prefix . "_" . $key] = $val;
					}
				}
				return $keys;
	
			} else {
				return $this->attrs;
			}
		}
		function getDisplayPageEntities() {
			return $this->attrs;
		}
		
		
		function everything() {
			$columns = $this->getColumns();
			foreach($columns as $key=>$value) {
				// value is meaningless
				$columns[$key] = $this->get($key);
				//$values[$column] = $this->get
				//echo $this->get($column);
				//echo $;
			}
			return $columns;
		}
			
		// accessors
		
		function get($key) 
		{
			$key = $this->mapKey($key);
	
			return stripslashes($this->attrs[$key]);
		}
		function set($key, $value) 
		{
			$key = $this->mapKey($key);
	
			$this->attrs[$key] = $value;
		}
	
		function valueForKey($key) 
		{
			$key = $this->mapKey($key);
	
			return $this->attrs[$key];
		}
		function takeValueForKey($key, $value) 
		{
			$key = $this->mapKey($key);
			
	
			$this->attrs[$key] = $value;
		}
	
		function mapKey($key)
		{
			return $key;
		}
	
		
		function asXML($incl = null)
		{
			$row = $this->attrs;
			
			if (! $incl) $incl = array_keys($row);
	
			$xml .= '<'.get_class($this).'>';
			for ($i=0; $i<sizeof($incl); $i++)
			{
				if ($incl[$i] == "descript" || $incl[$i] == "url"|| $incl[$i] == "type") {
					$tmp = str_replace("<br>", "<br />", $row[$incl[$i]]);
					$xml .= 	'<'.$incl[$i].'>'.utf8_encode(stripslashes($tmp)).'</'.$incl[$i].'>';
				
				} else {
					$xml .= 	'<'.$incl[$i].'>'.utf8_encode(stripslashes($row[$incl[$i]])).'</'.$incl[$i].'>';
				}
				//$xml .= 	'<'.$incl[$i].'>'.stripslashes($row[$incl[$i]]).'</'.$incl[$i].'>';
			}
			
			$xml .= '</'.get_class($this).'>';
			
			return $xml;
		}
		function asJSON($incl = null)
		{

			
			return json_encode($this->getEncodedAttrs());
			
			
		}
		
		
		function getPartialAttrs() {
			$pattrs = array();
			
			
			$pattrs['id'] 	= $this->get('id');
			$pattrs['name'] = $this->get('name');
			$pattrs['lat'] 	= $this->get('lat');
			$pattrs['lng'] 	= $this->get('lng');
			$pattrs['lng'] 	= $this->get('lng');
			
			return $pattrs;
		
		}
		
		
		// ! ******************** GET_ENCODED_ATTRS
		function getEncodedAttrs($incl) {
			$row = $this->attrs;
			
			if (! $incl) $incl = array_keys($row);
	
			$tmpattrs = array();

			// -- special fields --
			$incl[] = "relationship";
			// author_name
			if ($this->author) {
				$tmpattrs["author_name"] = $this->author->get('name');
			}
			
			
			if (get_class($this) == "Image") {
				$tmpattrs["media_folder"] = $this->webPathToMediaFolder();
				$tmpattrs['url100'] 	  = $this->url('100');
				$tmpattrs['url300'] 	  = $this->url('300');
				$tmpattrs['urlLarge'] 	  = $this->url('full');
				
			} 
			else if (get_class($this) == "ImageView")
			{
				$tmpattrs['webpath'] = "momomo"; //$this->getFilesystemBWebPath();
					
				
			}
			
			if ( $row['name'] == ""  && $row['title'] != "") {
				$row['name'] = $row['title'];
			}
			//$row['name'] = 'fdsfdsfds' . ' ' . $row['title'];
			for ($i=0; $i<sizeof($incl); $i++)
			{
				switch($incl[$i]) {
					case "descript":
					case "plan":
					case "elevation":
					case "history":
					case "chronology":
					case "significance":
					case "sculpture":
					case "url":
					case "type":
				
						$tmp = $row[$incl[$i]]; // str_replace("<br>", "<br />", $row[$incl[$i]]);
						$tmpattrs[$incl[$i]] =stripslashes( $this->parseLinkTags($tmp));
						break;
						
					default:
						$tmpattrs[$incl[$i]] = stripslashes($row[$incl[$i]]);
				
				}
				
			}


			if ($this->get('entity_id') == "170") { // feature
				$tmpattrs['poster_url'] 	= $this->posterURL(100);
				$tmpattrs['poster_url300'] = $this->posterURL(300);

				$plan = new Image($tmpattrs['plan_image_id']);
				if ($plan && $plan.attrs.id) {
					$attrs = $plan->attrs;
					if (strpos($attrs['filename'],'vr') ) {
						$attrs['filename'] = $attrs['orig_filename'];
						
					}
					$tmpattrs['planImage'] = $attrs;
				}

			}
			if ($this->get('entity_id') == "40") { // Building
				$tmpattrs['plan_url'] 		= $this->floorplanURL(100);
				$tmpattrs['latsec_url'] 	= $this->lat_sectionURL(100);
				
				
				$tmpattrs['poster_url'] 	= $this->posterURL(100);
				$tmpattrs['poster_url300'] = $this->posterURL(300);
				
				$poster = new Image($tmpattrs['poster_id']);
				if ($poster && $poster.attrs.id) {
					$attrs = $poster->attrs;
					if (strpos($attrs['filename'],'vr') ) {
						$attrs['filename'] = $attrs['orig_filename'];
						
					}
					$tmpattrs['poster'] = $attrs;
				}
				
				$plan = new Image($tmpattrs['plan_image_id']);
				if ($plan && $plan.attrs.id) {
					$attrs = $plan->attrs;
					if (strpos($attrs['filename'],'vr') ) {
						$attrs['filename'] = $attrs['orig_filename'];
						
					}
					$tmpattrs['planImage'] = $attrs;
				}
				$latsec = new Image($tmpattrs['lat_section_image_id']);
				if ($latsec && $latsec.attrs.id) {
					$attrs = $latsec->attrs;
					if (strpos($attrs['filename'],'vr') ) {
						$attrs['filename'] = $attrs['orig_filename'];
						
					}
					$tmpattrs['latsecImage'] = $attrs;
				}
				
			}
			
			// SUPPROT FOR RETURNING THE TEMPID AND THE NEW ID TO THE CLIENT SO IT CAN MAKE UPDATES TO ITS TEMPORARY OBJECT
			if ($this->temp_id && $this->temp_id != "") {
				$tmpattrs['temp_id'] = $this->temp_id;
			}
			
			return $tmpattrs;
		
		}
		function parseLinkTags($string, $link_base = "") {
			$pattern = '/\[([^0-9]+)\]\[([\w\/+]+)\]/';
			$result = preg_match_all($pattern,$string,$matches);
			foreach($matches[0] as $key=>$match) {
				//$link = '<a class="inline" href="'.$link_base.'/'.$matches[2][$key].'">'.$matches[1][$key].'</a>';
				$link = '<b>'.$matches[1][$key].'</b>';
				$string = str_replace($match,$link,$string);
			}
			return $string;
		}
		function asXMLAttributes($incl = null)
		{
			$row = $this->attrs;
			
			if (! $incl) $incl = array_keys($row);
	
			
			$attributesString = "";
			$nestedString = "";
			for ($i=0; $i<sizeof($incl); $i++)
			{
				if (strpos($row[$incl[$i]], "\"")  || $incl[$i] == "title" || $incl[$i] == "descript" || $incl[$i] == "url"|| $incl[$i] == "type") {
					$tmp = str_replace("<br>", "<br />", $row[$incl[$i]]);
					$nestedString .= 	'<'.$incl[$i].'>'.utf8_encode(stripslashes($tmp)).'</'.$incl[$i].'>';
				
				} else {
					// attribute
					if($row[$incl[$i]] != "") {
						$attributesString .= 	$incl[$i].'="'.$row[$incl[$i]].'" ';
					}
				}
				
				//$xml .= 	'<'.$incl[$i].'>'.stripslashes($row[$incl[$i]]).'</'.$incl[$i].'>';
			}
			// opening tag with attributes
			$xml .= '<'.get_class($this) . 'Object ' .$attributesString. ' />';
			
			//$xml .= $nestedString;
			
			//$xml .= '</'.get_class($this).'Object>';
			
			return $xml;
		}
		
	};

?>