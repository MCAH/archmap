<?
	
	class GenericRecord {
		
		/*
			An  class meant to hand basic db transaction
		*/
		
		var $attrs;	
		var $lockedKeys;	
		var $isNew;
	
		var $db;
		
		var $table 		= "ZWORD";
		var $primaryKey = "Z_PK";
		
		var $tables;
		var $columns;
		
		var $depth;
		
		var $editable_attributes = array(
			"Latitude"=> array("field" => "lat"),
			"Longitude"=> array("field" => "lng") );
			
		function db() {
			return $this->db;
		}
		function tableName() {
			return $this->table;
		}
		function primaryKey() {
			return "Z_PK";
		}
		
		function out() {
			println('<pre>');
			print_r($this->attrs);
			println('</pre>');
			printline();
		}
		
		function GenericRecord($arg1="", $arg2="", $record = true) {
			
			$this->db = new PDO("mysql:host=www.learn.columbia.edu;dbname=arch_map", "mgf", "mgfmgfmgf");
						
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
						$query 	= 'SELECT * FROM '.$this->tableName().' WHERE Z_PK='.$arg2;
						$result = $this->db->query($query);
						$this->initFromAssocRow($result->fetch());
					} else {
						$this->initNew();
					}
					break;
	
				
				case "ROW":
				
						$this->initFromAssocRow($arg2);
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
						
						$query  = 'SELECT * FROM '.$this->tableName().' WHERE  '.$keyValPairs;
						$result = $this->db->query($query);
						$row    = $result->fetch();
						if ($row) $this->initFromAssocRow($row);
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

		function query($sql) {
				
				try {  
					$db = new PDO("mysql:host=www.learn.columbia.edu;dbname=arch_map", "mgf", "mgfmgfmgf");
  					$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  

 					$result = $db->query($query );
 					$result->setFetchMode(PDO::FETCH_ASSOC);
 					$retArray = array();
					foreach ($result as $row) {
				  		$retArray [$row['name']] = $row['type'];
					}
				}  
				catch(PDOException $e) {  
				    echo "I'm sorry, Dave. I'm afraid I can't do that.";  
				    print('PDOErrors.txt: ' . $e->getMessage());  
				}  
				$db = null;

		}

		
		function getViewCount() {
			$query 	= "SELECT COUNT(*) as count FROM statistics WHERE model_key = '".$this->getHashKey()."'";
			$result = $this->db->query($query);
			$row 	= $result->fetch();
			return    $row["count"];
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
		
			$query  = 'select id from entity_ids where table_name="'.$table_name.'"';
			$result = $this->db->query($query);
			$row 	= $result->fetch();
			if ($row) {
				return $row[0];
			}
		}
		function getEntity_id_ByClassname($classname) {
			$query  = 'select id from entity_ids where name="'.$classname.'"';
			$result = $this->db->query($query);
			$row 	= $result->fetch();
			if ($row) {
				return $row[0];
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
			//if (! $this->valueForKey('createdate')) 	$this->takeValueForKey('createdate', rightNow());
		}	
	
		function checkValues() 
		{
			// ABSTRACT
		}
		
		function isLockedKey($attrName) 
		{
			return $this->lockedKeys[$attrName];
		}
	
	
		function getColumnsFromTable($table_name = 0) 
		{
			if($table_name) 
			{
			print("++".$table_name."++");
				$result = $this->db->query("PRAGMA table_info(" . $table_name . ")");
				$result->setFetchMode(PDO::FETCH_ASSOC);
				$columns = array();
				foreach ($result as $row) {
				  $columns[$row['name']] = $row['type'];
				}
				return $columns;		
			}
		}
	
		function getColumns() 
		{
			if(! $this->columns) 
			{
				$query = 'show columns from '.$this->table;
				$result = $this->db->query($query);
				
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
				$query = 'show tables';
				$result = $this->db->query($query);
				
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
	
		function saveChanges() {
			
			$this->getColumns();
			//$this->checkValues();
			//$this->set("metaphone", metaphone($this->get('name')));
					
			if (  ! $this->primaryKey || ! $this->valueForKey($this->primaryKey)  || ! is_numeric($this->valueForKey($this->primaryKey)) ) {
				$this->db__insert();
			} else {
				$this->db__update();
			}
			
			
		}
		
		
		
		
	
		
		
		
		function generatePrimaryKeyForTable($tableName, $primaryKeyName)
		{
			// assume :  [ ] the EO_PK_TABLE exists
			// remember: [ ] the value of the PK in the row must be >= the MAX($this->primaryKey()) in the actual table
			$query = 'LOCK TABLE `Z_PRIMARYKEY` WRITE, '.$tableName.' READ';
			$this->db->exec($query);
			
					$query  = 'SELECT Z_MAX FROM `Z_PRIMARYKEY`  WHERE NAME = "'.$tableName.'"';
					$result = $this->db->query($query);
					if ($result) {
						$row 	= $result->fetch();
						$primaryKeyValue = $row[0];
					}							
					if ($primaryKeyValue) 
					{
							$primaryKeyValue++;
							$this->takeValueForKey("Z_PK", $primaryKeyValue);
							$query = 'UPDATE `Z_PRIMARYKEY` SET Z_MAX = '.$primaryKeyValue.' WHERE NAME="'.$tableName.'"';
					} else {
							$query = 'SELECT max('.$primaryKeyName.') FROM '.$tableName;
							$result = $this->db->query($query);
							$row 	= $result->fetch();
							$primaryKeyValue = $row[0];
							$primaryKeyValue++;
							$this->takeValueForKey($primaryKeyName, $primaryKeyValue);
							$query = 'INSERT INTO `Z_PRIMARYKEY` (NAME, Z_MAX) VALUES ("'.$tableName.'",'.$primaryKeyValue.')';
					}  
					$this->db->exec($query);
	  
			$query = 'UNLOCK TABLES';
			$this->db->query($query);
			
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
					
					//if($columns[$key] && $val &&  ! $this->isLockedKey($key))  
					if($columns[$key] && $val)  
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
				$query = 'INSERT INTO '.$this->table.' ('.$keys.') VALUES ('.$vals.');';
			
				
				try {  
					$db = new PDO("mysql:host=www.learn.columbia.edu;dbname=arch_map", "mgf", "mgfmgfmgf");
  					$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  

 					$count = $db->exec($query );
				}  
				catch(PDOException $e) {  
				    echo "I'm sorry, Dave. I'm afraid I can't do that.";  
				    print('PDOErrors.txt: ' . $e->getMessage());  
				}  
				$db = null;
			}			
		}
		
		
	
		function db__update() 
		{
			if ($this->attrs)
			{
				if($this->valueForKey($this->primaryKey))
				{
					$columns = $this->getColumnsFromTable($this->table);
	
					
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
							$this->db->exec($query);
						}
					}
				}
			}	
		}
	
	
	
	
	
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
	
		
		function toJSON() {
			$row = $this->attrs;
			return(json_encode($this->attrs));		
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