<?php



define('SMARTY_DIR', $_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Smarty/libs/');
require(SMARTY_DIR . '/Smarty.class.php');

	class Request {


		
		public static $classNames = array(	'Essay' 			=> 1, 
											'Publication' 		=> 1, 
											'NoteCard' 			=> 1, 
											'Passage' 			=> 1, 
											'Building' 			=> 1, 
											'Person' 			=> 1, 
											'Place' 			=> 1, 
											'HistoricalEvent' 	=> 1, 
											'HistoricalObject' 	=> 1, 
											'Feature' 			=> 1, 
											'ImageView' 		=> 1, 
											'Image' 			=> 1);
		
		
		var $db;
		
		function Request() {


			$this->db = new Database();
		}
		
		
		function db() {
			return $db;
		}
		
		
		function response($requestItems) {
		
			
			
			
		
			$db = Utilities::getSharedDBConnection();	



			
			//print_r($requestItems);
			
			$request 	= $_REQUEST["request"];
			
			
			//logIt("request = " . $request);
			if(! $request) {
				$request = "search";
			}
			
			$tables = array();
			
			$tables["NoteCard"] 		= "notecard";
			$tables["Passage"] 			= "passage";
			$tables["Publication"] 		= "publication";
			$tables["Building"] 		= "building";
			$tables["Person"] 			= "person";
			$tables["Place"] 			= "place";
			$tables["HistoricalEvent"] 	= "historicalevent";
			$tables["HistoricalObject"] = "historicalobject";
			$tables["Feature"] 			= "feature";
			$tables["Image"] 			= "image";
			$tables["ImageView"] 		= "imageview";
		
			$entity 		= $_REQUEST['entity'];
			$fieldname 		= $_REQUEST['fieldname'];
			$fieldvalue 	= $_REQUEST['fieldvalue'];
			$searchString 	= $_REQUEST['searchString'];
			
			$entity 		= $_REQUEST["entity"];
			$id 			= $_REQUEST["id"];
			$relationship 	= $_REQUEST["relationship"];
			
			
			$from_entity 	= $_REQUEST["from_entity"];
			$from_id 		= $_REQUEST["from_id"];
			if (isset($from_entity) && is_numeric($from_id)) {
				$cmd = 'return new '.$from_entity.'('.$from_id.');';
				$from_model = eval($cmd);
			}

			$to_entity 		= $_REQUEST["to_entity"];
			$to_id 			= $_REQUEST["to_id"];
			
			$entity_id 		= getEntityID($entity);
			$from_entity_id = getEntityID($from_entity);
			$to_entity_id 	= getEntityID($to_entity);
		
	
			$relationship   = $_REQUEST["relationship"];



			// AUTH ************************
			if ($_GET["session_id"] != "") {
				$thisUser = new Person('SESSION_ID', $_GET["session_id"]);
			} else if ($_GET["testuser_id"] = "abc123i363") {
				$thisUser = new Person('ID', 363);
				
			}




			$request_key = $request . ' :: ' . $from_entity . ':'.$from_id . ', ' .$to_entity.':'.$to_id.' - '.$relationship;
			$starttime = g_starttime();
			
			$logfile = $_SERVER['DOCUMENT_ROOT']."/archmap_2/logs/my-errors.log";


			/*
			logIt("***********************************: " . $request,  g_endtime($starttime));
			logIt("REQUEST: " . $request,  g_endtime($starttime));
			logIt("-----------------------------------: " . $request,  g_endtime($starttime));
					foreach($_REQUEST as $key=>$val) {
						logIt("$_REQUEST: " .$key.' = '.$val,  g_endtime($starttime));
					}
			logIt("***********************************: " . $request,  g_endtime($starttime));
			*/
			
			switch ($request) {
				
				// ! GET MODEL
				case "getModel":
					$cmd = 'return new '.$entity.'('.$id.');';
					$model = eval($cmd);
					
					
					$endtime = g_endtime($starttime);
					//logIt($request_key,  $endtime);
					
					$author = $model->getAuthor();
					
					return $model->asJSON();
					break;
				
				// ! GET PARENT
				case 'getParent': 
					$cmd = 'return new '.$entity.'('.$id.');';
					
					$model = eval($cmd);
					$parent = $model->getParent();
					if ($parent) {
						return $parent->asJSON();
					} else {
						return '{"result":"failed", "reason": "no parent found", "entity": "'.$entity.'", "id":"'.$id.'"}';
					}
					
				
					break;
				
				
				// ! SAVE_RELATION_CHANGES
				case "saveRelationChanges":
				
					
					logIt('saveRelationChanges');
				
					if (! is_numeric($from_entity_id) || ! is_numeric($from_id) || ! is_numeric($to_entity_id) || ! is_numeric($to_id)) return;
					
					
					//println($from_entity_id);
					
					
					if ($relationship && $relationship != "" && $relationship != "undefined") {
						if ($relationship == "any" || $relationship == "null" ) {
							$relationshipClause .= ' ';
						} else {
							$relationshipClause .= ' AND relationship="'.$relationship.'"';
						}
						
					} else {
						
						$relationshipClause .= ' AND relationship IS NULL';
						$relationship = "NULL";
					}
					
					
					
					
					$sql = 		'select count(*) from z_related_entities WHERE  from_entity_id='.$from_entity_id.' AND from_id='.$from_id.' AND from_id='.$from_id.' AND to_entity_id='.$to_entity_id.' AND to_id='.$to_id.' ';
					$sql .= $relationshipClause;
					$count = $db->count($sql);
					
					logIt('saveRelationChanges sql = '.$sql);
					
					if ($count > 0) {
						
						if ($_REQUEST["pos_x"] != "") 
						{
							$sql = 'UPDATE z_related_entities SET pos_x='.$_REQUEST["pos_x"].', pos_y='.$_REQUEST["pos_y"].' WHERE  from_entity_id='.$from_entity_id.' AND from_id='.$from_id.' AND to_entity_id='.$to_entity_id.' AND to_id='.$to_id;
							
						} else {
							$sql = 'UPDATE z_related_entities SET '.$fieldname.'='.$fieldvalue.' WHERE  from_entity_id='.$from_entity_id.' AND from_id='.$from_id.' AND to_entity_id='.$to_entity_id.' AND to_id='.$to_id.' ';
							
						}
						$sql .= $relationshipClause;
						
						logIt('saveRelationChanges sql 2 = '.$sql);
						$db->submit($sql);
					
					
					} else {
						$sql = 'select count(*) from z_related_entities WHERE  from_entity_id='.$to_entity_id.' AND from_id='.$to_id.' AND to_entity_id='.$from_entity_id.' AND to_id='.$from_id.' ';
						$sql .= $relationshipClause;
						$count = $db->count($sql);
						
				
						if ($count > 0) {
						
							$sql = 'UPDATE z_related_entities SET '.$fieldname.'='.$fieldvalue.' WHERE  from_entity_id='.$to_entity_id.' AND from_id='.$to_id.' AND to_entity_id='.$from_entity_id.' AND to_id='.$from_id.' ';
							$sql .= $relationshipClause;
							$db->submit($sql);
							
						} else {
							
							$sql = 'INSERT into z_related_entities (from_entity_id, from_id, to_entity_id, to_id, createdate, relationship, pos_x, pos_y) values ('.$from_entity_id.','.$from_id.', '.$to_entity_id.', '.$to_id.',"'.rightNow().'","'.$relationship.'","'.$_REQUEST["pos_x"].'","'.$_REQUEST["pos_y"].'")';
							//printline("hh ".$sql);
							
							$db->submit($sql);
						}
					}
					
					return '[{"result":"SUCCESS: relation removed"}]';
					
					break;
										
				
				case "saveAttribute":
				
					// AUTH ************************
					// does user have privs to save these changes to this Model?
					if (! isset($thisUser) || ! is_numeric($thisUser->get('id'))) {
						return;
					}
					// AUTH ************************


					$sql = 'select count(*) FROM attribute_value where entity_id='.$entity_id.' AND item_id='.$_REQUEST['item_id'] .' AND attr_id='.$_REQUEST['attr_id'].' AND author_id='.$thisUser->get("id");
					
					
					$count = $db->count($sql);
					if ($count > 0) {
					
						$sql = 'UPDATE attribute_value SET val='.$_REQUEST['val'].' WHERE entity_id='.$entity_id.' AND item_id='.$_REQUEST['item_id'].' AND attr_id='.$_REQUEST['attr_id'].' AND author_id='.$thisUser->get("id");
						$db->submit($sql);
						
					} else {
						
						$sql = 'INSERT into attribute_value (entity_id, item_id, attr_id, author_id, val, createdate) values ('.$entity_id.','.$_REQUEST['item_id'].', '.$_REQUEST['attr_id'].', ' .$thisUser->get("id").', '.$_REQUEST['val'].',"'.rightNow().'")';
						//printline("hh ".$sql);
						
						$db->submit($sql);
					}
				


					break;
					
				// ! SAVE_CHANGES
				case "saveChanges":
					
					// Assume that the $request has a representation of the model
					// It may have a value for id (if it is an update)
					
					// If only one field is in the $_REQUEST array that matches a table field, 
					//  then it will update only that field and leave the others as is.
					
					// EXAMPLE: /archmap2/api?request=saveChanges&className=Essay&id=3&name=Earthquakers
					
					logIt("SAVE_CHANGES 0a: ".$entity,  g_endtime($starttime));
					
					if (! isset($entity)) {
						return '[{"result":"FAILED: no className specified"}]';
					}
					if (! Request::$classNames[$entity]) {
						return '[{"result":"FAILED: "'.$entity.'" not a valid className"}]';
					}
					logIt("SAVE_CHANGES 0b: ".$_GET["session_id"],  g_endtime($starttime));
					

					// does user have privs to save these changes to this Model?
					if (! $thisUser || ! $thisUser->get('id')) {
						logIt("SAVE_CHANGES 0c1",  g_endtime($starttime));
						
						return;
						
					}
					logIt("SAVE_CHANGES 0d",  g_endtime($starttime));

					// AUTH ************************
					
					logIt("SAVE_CHANGES 1",  g_endtime($starttime));
					
					$cmd = 'return new '.$entity.'($_REQUEST);';
					
					$model = eval($cmd);
					
					
					// support one-off changes in inline editing
					if (isset($fieldname) && isset($fieldvalue)) {
						
						if ( ($fieldname == "name" ||  $fieldname == "descript") && $fieldvalue  != "") {
							//$fieldvalue = urldecode(utf8_decode($fieldvalue));
							$fieldvalue = urldecode($fieldvalue);
						}
						
						//printline($fieldname . ', '. $fieldvalue);
						$model->set($fieldname, $fieldvalue);
						
					} else {
						if (isset($_REQUEST['name']) && "" . $_REQUEST['name'] != "") {
							$model->set("name", utf8_decode($_REQUEST['name']));
						}
					}
					
										
					
					logIt("SAVE_CHANGES 2",  g_endtime($starttime));
					
					$modelIsNew = $model->isNew();
					
					if ($modelIsNew) {
						$model->set("author_id", $thisUser->get("id"));
						$model->set("createdate", rightNow());
						
						// for now, all essays are root to the user. 
						// later, essays may be parented to other essays 
						// in which case, a parent_id will be sent with the request.
						if ($entity == 'Essay') {
							$model->set("parent_entity_id", 50);
							$model->set("parent_item_id", $thisUser->get("id"));
						} 
						
					} else {
						if($thisUser && $thisUser->get("id")) {
							$model->set("editor_id", $thisUser->get("id"));
							$model->set("editdate", rightNow());

							
						}
											
					}
	
					logIt("SAVE_CHANGES 3",  g_endtime($starttime));
	
					if ($entity == "Passage") {
						$model->set("public_status", $thisUser->get("isUser"));
						
					}
					
					if ( ! isset($_REQUEST['name']) || (isset($_REQUEST['name']) && $model->get("name") && "".$model->get("name") != "")) {
						//printline('saving');
						$model->saveChanges();
						
					}
					
					
					logIt("SAVE_CHANGES 4 ". $from_entity . ' - ' . $from_id,  g_endtime($starttime));
					
					
					
					// add this model to the relations table that sent this request
					// this is incase the item is new
					
			
					if ($modelIsNew && isset($from_entity) && $from_entity!='undefined' && $from_entity != "" && $from_id && is_numeric($from_id)) {
						// add the relation
						//	printline("relation " . $from_entity . '==' . $entity . ', ' . $from_id );
						logIt("SAVE_CHANGES 5 ". $from_entity . ' - ' . $from_id,  g_endtime($starttime));
					
						if (  $from_entity != $entity || $from_id != $model->get('id')  ) {
							logIt("SAVE_CHANGES 6 ". $from_entity . ' - ' . $from_id,  g_endtime($starttime));

							
							$from_model = $this->getTheModel($from_entity, $from_id);
							logIt("SAVE_CHANGES 7 ". $from_model,  g_endtime($starttime));
							if ($from_model) {
								logIt("SAVE_CHANGES 8 ". $from_entity . ' - ' . $from_id,  g_endtime($starttime));
								$from_model->addRelation($model, $relationship);
							}
							
						
							
						}
						
					}
					
					
					
					//logIt($request_key,  g_endtime($starttime));
					
					$reponse = $model->asJSON();
					logIt("SAVE_CHANGES 9: returning: " . $reponse,  g_endtime($starttime));
					return $reponse;
										
										
					break;
				
				
				// ! getFeatureSubtypes
				case 'getFeatureSubtypes':
				
					$sql = 'SELECT id, name, proper, name_plural FROM lexicon_entry WHERE isKeyword=1 ORDER BY name ASC';
					
					$ret_rows = $this->db->queryAssoc($sql);
	
					return json_encode($ret_rows);
					

					break;
				
				// ! MAKE_SEADRAGON_TILES
				case 'makeSeaDragonImageTiles':
					$cmd = 'return new Image('.$id.');';
					$model = eval($cmd);
					
					$model->makeOneoffSeaDragonTiles();
					
					//return $model->asJSON();
					return '{"result":"SUCCESS", "id":"'.$id.'"}';
					
					break;



				// ! LIST OF BUILDINGS WITH SEADRAGON TILES
				case 'buildingsWithSeaDragonImageTiles':
					
					// HAS_TILES FILTER
					if ($_REQUEST["filter"] == 'has_tiles') {
						$has_sd_tiles_filter = 'i.has_sd_tiles=1';
					} else {
						$has_sd_tiles_filter = ' (i.has_sd_tiles IS NULL OR i.has_sd_tiles<1) ';
					}
					
					// ORDER BY
					if ($_REQUEST["orderby"] == 'editdate') {
						
						$orderby = ' i.editdate DESC ';
						
					}	else {
						
						$orderby = ' b.name ';
					}
					
					$style = array();
					$style['Crusader'] 		= 13;
					$style['FrenchGothic'] 	= 11;
					$style['SpanishGothic'] = 15;
					$style['ItalianGothic'] = 14;
					$style['Byzantine'] 	= 16;
					$style['Romanesque'] 	= 10;
					$style['Islamic'] 		= 12;


					// STYLE
					$styleid = 11;
					if ($_REQUEST["style"]) {
						$styleid = $style[$_REQUEST["style"]];
					}
					
					
					if ($_REQUEST["building_id"] && $_REQUEST["building_id"] > 0 ) {
						$sql = 'SELECT i.id, i.name, i.filename, i.orig_filename FROM image i WHERE i.building_id='.$_REQUEST["building_id"].' AND '.$has_sd_tiles_filter.' ORDER BY i.filename ';
					} else {
						$sql = 'SELECT b.id, b.name, count(i.id) AS imageCount FROM building b left join image i ON (i.building_id=b.id) where '.$has_sd_tiles_filter.' AND i.image_type <> "cubic" AND i.image_type <> "node" AND b.style='.$styleid.' GROUP BY b.id ORDER BY '.$orderby;
					}
										
					$rows = $this->db->queryAssoc($sql);


					$ret_rows = array();

					foreach($rows as $row) {
						$row['name'] = utf8_encode(stripslashes( $row['name'] ));
						$ret_rows[] = $row;
					}
					return json_encode($ret_rows);
					
					break;




				



				
				// ! IMPORT ENTITIES
				case 'importEntities':

					$table = $tables[$entity];

					$names = $_REQUEST['names'];

					// this should be input as a JSON data string
					
					$result = array();
					
					foreach ($names as $name) {
					
						$sql_ = 'SELECT * FROM ' . $table . ' WHERE name="'.$name.'"';
						$rows = $db->queryAssoc($sql_);
						// prepare these as suggestions to resolve conflicts

						if (! $rows || $rows == "") {
							$sql_ = 'SELECT * FROM ' . $table . ' WHERE name LIKE "%'.$name.'%"';
							$rows = $db->queryAssoc($sql_);
						}
						if (! $rows || $rows == "") {
							$sql_ = 'SELECT * FROM ' . $table . ' WHERE name LIKE "%'.$name.'%"';
							$rows = $db->queryAssoc($sql_);
						}
						$tmp = array();
						$tmp['name'] = $name;

						if ( $rows && $rows != "") {
							$tmp['status'] = 'CONFLICT';
							
							
							$trows = array();
							foreach($rows as $row) {

								$cmd = 'return new '.$entity.'("ROW", $row);';
								$tmpobj = eval($cmd);
								$tmpobj->set('partial', true);
								$trows[] = $tmpobj->getPartialAttrs();
							}
							
							$tmp['suggestions'] = $trows;
						
							
						} else  {
							// create Entity
							$tmp['status'] = 'NEW';
						
							$attrs['name'] = $name;
							$cmd = 'return new '.$entity.'($attrs);';
							$tmpobj = eval($cmd);
							$tmpobj->saveChanges();
							$tmp['model'] = $tmpobj->getPartialAttrs();
							
							if (isset($from_model)) {
								$from_model->addRelation($tmpobj, $relationship);
							}

						}
						$result[] = $tmp;
						// package results in wrappers 
					}
					return json_encode($result);
					
					break;
				
				
					
				
				// ! REMOVE_ITEM_FROM_LIST
				case "removeItemFromList":
				

					
					// AUTH ************************
					// does user have privs to save these changes to this Model?
					if (! isset($thisUser) || ! is_numeric($thisUser->get('id'))) {
						return;
					}
					// AUTH ************************
					
					// add the relation
					$cmd = 'return new '.$from_entity.'('.$from_id.');';
					$from = eval($cmd);
					
					$cmd = 'return new '.$to_entity.'('.$to_id.');';
					$model = eval($cmd);
					
					$from->removeRelation($model, $relationship);
					
					if ($_REQUEST["remove_type"] == "delFromDB" && $to_entity == "Publication")
					{
						// really delete from db
						$model->removeFromDatabase();
						
					} 
					else
					{
						$from->removeRelation($model, $relationship);

					}
					
					return '[{"result":"SUCCESS: relation removed"}]';
					
				
					break;
					
					
				// ! ADD_ITEM_TO_LIST
				case "addItemToList":

					if (! isset($from_entity)) {
						return '[{"result":"FAILED: no from_entity specified"}]';
					}
					if (! Request::$classNames[$from_entity]) {
						return '[{"result":" FAILED: '.$from_entity.' is not a valid classname"}]';
					}
					if (! isset($to_entity)) {
						return '[{"result":"FAILED: no to_entity specified"}]';
					}
					if (! Request::$classNames[$from_entity]) {
						return '[{"result":" FAILED: '.$to_entity.' is not a valid classname"}]';
					}

					// AUTH ************************
					// does user have privs to save these changes to this Model?
					if (! $thisUser || ! $thisUser->get('id')) {
						return;
					}
					// AUTH ************************
					
					$cmd = 'return new '.$from_entity.'('.$from_id.');';
					$from_model = eval($cmd);
					

					$cmd = 'return new '.$to_entity.'('.$to_id.');';
					$to_model = eval($cmd);
		
					if ($relationship == "null") $relationship == "NULL";
					 
					if ($from_model && $to_model) {
						// add the relation
						
						
						$from_model->addRelation($to_model, $relationship);
						
						if ($relationship == "parent") {
							$to_model->addRelation($from_model, "parent");
						} else if ($relationship == "child") {
							$from_model->addRelation($to_model, "parent");
						} else {
						
							$from_model->addRelation($to_model, $relationship);
						}
						return '[{"result":"SUCCESS: relation added"}]';
					}
				
				
					break;
					
					
					
					
					
					
					
					
					
					
				// ! DELETE_ITEM_FROM DATABASE
				case "deleteItemFromDatabase":
				
					// Assume that the $request has a representation of the model
					// It may have a value for id (if it is an update)
					
					// It only one field is in the $_REQUEST array that matches a table field, 
					//  then it will update only that field and leave the others as is.
					
					// EXAMPLE: /archmap2/api?request=deleteItem&classname=Essay&name=Earthquakers&id=3
					
				
					$entity 	= $_REQUEST["entity"];
					if (! isset($entity)) {
						return '[{"result":"FAILED: no classname specified"}]';
					}
					if (! Request::$classNames[$entity]) {
						return '[{"result":"FAILED: "'.$entity.'" is not a valid classname"}]';
					}

					

					
					// AUTH ************************
					// does user have privs to save these changes to this Model?
					if (! $thisUser || ! $thisUser->get('id')) {
						return '[{"result":"FAILED: no user "}]';
					}
					// AUTH ************************
					
					
					// does user have privs to save these changes to this Model?
					
					
					// HERE DO MAJOR CONSTRUCTION
					
					// -- 1. For now, only delete id essay or notecard... later add secure permissions.
					// -- 2. Remove relations for the deleted object.
					$cmd = 'return new '.$entity.'($_REQUEST);';
					$model = eval($cmd);
					
					
					// CHECK PERMISSION TO DELETE
					// For now permission is based on the user level and the public_status of the record to be deleted
					// The user level has to be one higher than the public status
					// or the user has to be the author and the public status not higher than the users.
					if ($thisUser->get('isUser') <= $model->get("public_status")  &&  ! ($thisUser->get('id') == $model->get("author_id") && $model->get("public_status") <= $thisUser->get('isUser'))  ) {
						logIt("NO PERMISSION TO DELETE");
						return '{"success":0, "message":"You do not have permission to delete this ' . $entity . '. This ' . $entity . ' has a publication status of ' . $model->get("public_status").'"}';
					}								
								
								
										
					if ($model->isNew()) {
						// nothing in the database to delete
						return '{"result":"FAILED: nothing matches the item to be deleted"}';
					} else {
					
						// Don't delete the main site entities!!!!! Just in case ;-)
						if (get_class($model) == "ImageView" || get_class($model) == "Feature" || get_class($model) == "Passage" || get_class($model) == "Essay" || get_class($model) == "NoteCard"  || get_class($model) == "Image" || get_class($model) == "Publication" || (get_class($model) == "Building" && $model->get('author_id') == $thisUser->get('id')) ) {
							logIt('deleted item ' .$model->get('id'));
							
							$model->removeFromDatabase();
						}
						return '{"success":"1", "message":"'. $entity . ' deleted"}';	
					
					}
					
					break;
					
				// ! UPDATE_RELATED_ITEM	
				
		
				case "updateRelatedItem":
				
					// AUTH ************************
					// does user have privs to save these changes to this Model?
					if (! $thisUser || ! $thisUser->get('id')) {
						return '[{"result":"FAILED: user must login"}]';
					}
					// AUTH ************************
					
					
				
					if (is_numeric($from_entity_id) && is_numeric($from_id) && is_numeric($to_entity_id) && is_numeric($to_id)) {
					
						
						if ( isset($fieldname) && $fieldname != "" && isset($fieldvalue) && $fieldvalue != "" ) {
						
							$sql = 'SELECT id FROM z_related_entities where ( (from_entity_id='.$from_entity_id.' AND from_id='.$from_id.' AND to_entity_id='.$to_entity_id.' AND to_id='.$to_id.') OR (from_entity_id='.$to_entity_id.' AND from_id='.$to_id.' AND to_entity_id='.$from_entity_id.' AND to_id='.$from_id.') ) ';
							
							if ($relationship && $relationship != "") {
								if ($relationship == "any" || $relationship == "null" ) {
									$relationshipClause .= ' ';
								} else {
									$relationshipClause .= ' AND relationship="'.$relationship.'"';
								}
								
							} else {
								
								$relationshipClause .= ' AND relationship IS NULL';
							}
							
							$sql .= $relationshipClause;
							
							
							$result = $db->queryAssoc($sql);
							$relation_id = $result[0]['id'];
						
						
							if ($relation_id && $relation_id != "" && is_numeric($relation_id)) {
								
								$sql = 'UPDATE z_related_entities SET '.$fieldname.'="'.$fieldvalue.'" WHERE id='.$relation_id.';'; 
								$db->submit($sql);
								return '[{"result":"SUCCESS"}]';
							}
						} else {
							return '[{"result":"FAILED: need field name or field value"}]';
						}
							
					} else {
						return '[{"result":"FAILED: need ids"}]';
					}
					
									
					break;
					
					
				// ! UPDATE_RELATED_ITEM_FIELDS	
					
				case "updateRelatedItemFields":
				
					// AUTH ************************					
					// does user have privs to save these changes to this Model?
					if (! $thisUser || ! $thisUser->get('id')) {
						return '[{"result":"FAILED: user must login"}]';
					}
					// AUTH ************************
					
					
				
					if (is_numeric($from_entity_id) && is_numeric($from_id) && is_numeric($to_entity_id) && is_numeric($to_id)) {
					
				
						$sql = 'SELECT id FROM z_related_entities where ( (from_entity_id='.$from_entity_id.' AND from_id='.$from_id.' AND to_entity_id='.$to_entity_id.' AND to_id='.$to_id.') OR (from_entity_id='.$to_entity_id.' AND from_id='.$to_id.' AND to_entity_id='.$from_entity_id.' AND to_id='.$from_id.') ) ';
						
						
						logIt("updating relationship: " . $sql);
						if ($relationship && $relationship != "") {
							if ($relationship == "any" || $relationship == "null" ) {
								$relationshipClause .= ' ';
							} else {
								$relationshipClause .= ' AND relationship="'.$relationship.'"';
							}
							
						} else {
							
							$relationshipClause .= ' AND relationship IS NULL';
						}
													
						$sql .= $relationshipClause;
						
						
						$result = $db->queryAssoc($sql);
						$relation_id = $result[0]['id'];
					

						// WAS THERE A RECORD TO UPDATE?
						if ($relation_id && $relation_id != "" && is_numeric($relation_id)) {
						
						
							$fields = array();
							$fields["catnum"] 	= true;
							$fields["pages"] 	= true;
							$fields["pos_x"] 	= true;
							$fields["pos_y"] 	= true;
							$fields["pos_z"] 	= true;
							$fields["ang"] 		= true;
							$fields["axis"] 	= true;
											
							foreach($_REQUEST as $key => $val) {
								logIt("setting ". $key .'='. $val);
								if ($fields[$key]) {
									if (! $keyValPairs) 
									{
										$keyValPairs 	 = 		$key.'="'.$val.'"';
									} else {
										$keyValPairs 	.= ','.	$key.'="'.$val.'"';
									}
									
								}
							}
							
							
							if ($keyValPairs && $keyValPairs != "") {
								$sql = 'UPDATE z_related_entities SET '.$keyValPairs.'  WHERE id='.$relation_id.';'; 
								$db->submit($sql);
								return '[{"result":"SUCCESS"}]';
							} else {
								
								return '[{"result":"FAILED: need field names and values"}]';
							}
						}
					
							
					} else {
						return '[{"result":"FAILED: need ids"}]';
					}
					
									
					break;
					
					
					
				// ! GET_RELATED_ITEMS_COUNT
				case "getRelatedItemsCount":
					
					
					$cmd = 'return new '.$from_entity.'('.$from_id.');';
					$from_model = eval($cmd);
					
					// get the author's items
					$count = $from_model->getRelatedItemsCount($to_entity, $relationship);
					
					$ret['from_entity'] 	= $from_entity;
					$ret['from_id'] 		= $from_id;
					$ret['to_entity'] 		= $_REQUEST["to_entity"];
					$ret['relationship'] 	= $_REQUEST["relationship"];
					
					$ret['count'] = $count;
					//return $JSON;
					
					logIt($request_key,  g_endtime($starttime));
					
					return json_encode($ret);

					break;
					
										
				// ! GET_RELATED_ITEMS
				case "getRelatedItems":
					
					logIt("getRelatedItems",  g_endtime($starttime));
	
					
					if (! isset($from_entity) ) {
						return '{"result":"FAILED: "'.$from_entity.'" does not match permissible names"}';
					}
					if (! is_numeric($from_id)) {
						return '[{"result":"FAILED: no id"}]';
					}
					
					
					$cmd = 'return new '.$from_entity.'('.$from_id.');';
					$from_model = eval($cmd);
					
					// get the author's items
					$items = $from_model->getRelatedItems($to_entity, false, $relationship);
					
					$ret['from_entity'] 	= $from_entity;
					$ret['from_id'] 		= $from_id;
					$ret['to_entity'] 		= $_REQUEST["to_entity"];
					$ret['relationship'] 	= $_REQUEST["relationship"];
					$ret['items'] 			= $items;
					
					//return $JSON;

					logIt($request_key,  g_endtime($starttime));
					
					return json_encode($ret);

					break;
					
					
				// ! GET_BUILDING POSTER
				case "getBuildingPoster": 
					
					$id = $_REQUEST['id'];
					
					if (! is_numeric($id)) {
						return '[{"result":"FAILED: no id"}]';
					}
					$building = new Building($id);
					$poster = $building->posterFor(1, 2);
					return $poster->asJSON();
					break;
					
					
						
				// ! GET_BUILDING PLAN IMAGE PLOTS
				case "getOldImagePlotsForImageid": 
					
					$id = $_REQUEST['id'];
					
					if (! is_numeric($id)) {
						return '[{"result":"FAILED: no id"}]';
					}
					
					$sql = "SELECT p.media_id, p.pos_x, p.pos_y, p.rotation, p.level, i.id, i.filename, i.orig_filename, i.filesystem  FROM image_plot p, image i WHERE p.image_id=". $id .' AND p.media_id=i.id';;
					
					$rows = $db->queryAssoc($sql);
					
					
					for($i=0; $i<sizeof($rows); $i++)
					{
						$image = new Image($rows[$i]);
						$url = $image->url(300);
						$rows[$i]['url300'] = $url;					
						
					}

					return  json_encode($rows);
					break;
					
					
					
					
				
				//! SEARCH
				case 'search':
					
					//printline($request . '::--' . $entity . '--: name=' . $_REQUEST['name'] . ', authors='.$_REQUEST['authors'] ,  g_endtime($starttime));

					$queryString = $_REQUEST['searchString'];

					if ($queryString == "")
					return "";
					
					
					if ($entity == "")
						$entity="Building";
						
					$table = strtolower($entity);

					$sql = 'SELECT *, MATCH (name) AGAINST ("'.$queryString.'") AS score FROM '.$table.' WHERE MATCH (name) AGAINST ("'.$queryString.'")   limit 0,20';
					$sug_rows = $this->get_rows($sql);	
					$whereClause = "";
					if ($sug_rows == "")
					{
						$parts = explode(" ",$queryString);
						foreach ($parts as $word) 
						{
							if ($whereClause != "") $whereClause .= " AND ";
							$whereClause .= ' name LIKE "%' . $word . '%" ';
						}
						
						$sql = 'SELECT * FROM '.$table.' WHERE '.$whereClause.'   limit 0,20';
						$sug_rows = $this->get_rows($sql);	
					}
					
					$sug_rows = $this->get_rows($sql);													

					foreach ($sug_rows as $row) {
						
						$smarty = new Smarty;
						$smarty->setTemplateDir('Site/templates');
								
						if ($hasId[$row['id']]) {
							
							// move on
						} else {
							$uret_rows[] = $row;
							$hasId[$row['id']] = true;
							
							
							$resultcount++;
							
							
							$building 	= new Building($row);
							$image 		= $building->getPosterImage();
							
							$smarty->assign("collection", $_REQUEST['collection'], true);
							$smarty->assign("building", $building->attrs, true);
							
							if ($image->get('id')) {
								$smarty->assign("posterUrl100", $image->url(100));
								$smarty->assign("image", $image->attrs, true);
							} else {
								$smarty->assign("posterUrl100", "/archmap_2/media/ui/NoImage.jpg");
							}
							//$thumbHtml = $smarty->fetch('ImageThumbnail.tpl');
							//$smarty->assign("thumbnail", $thumbHtml);
							
							// RENDER
							$bhtml = $smarty->fetch('BuildingCard.tpl');


							$html .= '<div >'.$bhtml.'</div>';
						}
						
						
						
					
					
						$cmd = 'return new '.$entity.'($row);';
						$tmp = eval($cmd);
						$tmp->set('partial', true);
						
						$tmp_attrs = $tmp->getEncodedAttrs($incl);
						
						$tmp_attrs['entity'] = getEntity($tmp_attrs['entity_id']);
						
						$posterSize = ($_REQUEST['posterSize']) ? $_REQUEST['posterSize'] : 100;
						
						
						if ($entity == "Building") {
							//print("<br>BUILDING ====================================".$row['name']." </br>");
							$tmp_attrs['plan_url'] 		= $tmp->floorplanURL(100);
							$tmp_attrs['plan_url300'] 	= $tmp->floorplanURL(300);
							
							$tmp_attrs['latsec_url'] 	= $tmp->lat_sectionURL(100);
							$tmp_attrs['latsec_url300'] 	= $tmp->lat_sectionURL(300);
							
							
							$tmp_attrs['poster_url'] 	= $tmp->posterURL(100);
							$tmp_attrs['poster_url300'] 	= $tmp->posterURL(300);
							
							$poster = new Image($tmp_attrs['poster_id']);
							if ($poster && $poster.attrs.id) {
								$tmp_attrs['poster'] = $poster->attrs;
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
							
						}
						
						
						$trows[] = $tmp_attrs;
							
						
					
						
					}
					
					
					
				
					return json_encode($trows);
					
					//echo '<div class="search-results-panel"> <div >Search Results: '.$resultcount.'</div> '. $html. ' </div>';
					//exit;

					break; 
					







					







				// ! SEARCH_WORLDCAT
				case "searchWorldCat":
				
					$search 		= $_REQUEST['search'];
					
					$name 			= $_REQUEST['name'];
					$contributors 	= $_REQUEST['contributors'];
					$keywords 		= $_REQUEST['keywords'];
					$pubtypeName 	= $_REQUEST['pubtypeName'];
					
					$query = $search;
					if ($name || $contributors || $keywords || $pubtypeName) {
						$queryType	= "advanced";
						if ($name) 			$query	.= ' ti:'.$name;
						if ($contributors) 		$query	.= ' au:'.$contributors;
						if ($keywords) 		$query	.= ' kw:'.$keywords;
						if ($pubtypeName) {
							switch($pubtypeName) {
								case "Article":
								case "JournalArticle":
								case "BookSection":
								case "Chapter":
									$fq	 = 'x0:artchap';
									break;
								case "Book":
								case "EditedBook":
									$fq	 = 'x0:book';
									break;
							}		
						
						}	
							
					} else {
						$queryType	= "worldcat_org_all";
					}






										
					$url = "http://www.worldcat.org/search?qt=".$queryType."&q=".urlencode($query);
					if ($fq) {
						$url .= '&fq='.urlencode($fq);
					}
									    
				    
				    //printline($url);
					$html = file_get_contents($url);
					
					
					//echo $html;
					
					//printline(" ---- + : " .$html . " ======");
					return $html;
				
					break;




				// ! SEARCH_PUBLICATION
				case "searchPublication":

					$queryString = $_REQUEST['queryString'];
					if ( ("="+$queryString+"=") == "")
						$queryString = $_REQUEST['searchString'];
						
					$sql = 'SELECT *, MATCH (name, contributors) AGAINST ("'.$queryString.' '.$queryString.'") AS score FROM publication WHERE MATCH (name, contributors) AGAINST ("'.$queryString.' '.$queryString.'")  and pubtype <> 1000  limit 0,20';
					//return $sql;
					$sug_rows = $this->get_rows($sql);							
					
					if ($sug_rows) 
					{
						$good_score = 5;
						$good_sug_rows = array();
						for ($j = 0; $j<sizeof($sug_rows); $j++) 
						{
							if ($sug_rows[$j]['score'] > $good_score) 
							{
							
								$tmp = new Publication($sug_rows[$j]);
								$tmp->set('partial', true);
								$tmp_attrs = $tmp->getEncodedAttrs();						
								$tmp_attrs['entity'] = getEntity($tmp_attrs['entity_id']);
							
								$tmp_attrs['score'] = $sug_rows[$j]['score'];
							
								$tmp_attrs['am_pubid'] = $sug_rows[$j]['id'];
								$tmp_attrs['name'] = utf8_encode(stripslashes($sug_rows[$j]['name']));
								
								$good_sug_rows[] = $tmp_attrs;
							}							
						}
					}
					
					
					return json_encode($good_sug_rows);
					break;
					

				// ! CHECK JSON BIBLIO_RECORDS 
				case "checkBiblioJSONRecords":
					logIt(" HERE - checkBiblioJSONRecords");
					
					$pub_rows = json_decode($_POST['json'], true);
					
					for ($i = 0; $i<sizeof($pub_rows); $i++) 
					{				
						$title 			= $pub_rows[$i]['title'];
						$title 			= str_replace('"','',$title);
						
						$contributors 	= $pub_rows[$i]['author'][0]['family'];
						
						$sql = 'SELECT *, MATCH (name, contributors) AGAINST ("'.$title.' '.$contributors.'") AS score FROM publication WHERE MATCH (name, contributors) AGAINST ("'.$title.' '.$contributors.'")  and pubtype <> 1000  limit 0,3';
						//return $sql;
						$sug_rows = $this->get_rows($sql);							
						
						if ($sug_rows) 
						{
							$good_score = 20;
							$good_sug_rows = array();
							for ($j = 0; $j<sizeof($sug_rows); $j++) 
							{
								if ($sug_rows[$j]['score'] > $good_score) 
								{
									$sug_rows[$j]['am_pubid'] = $sug_rows[$j]['id'];
									$sug_rows[$j]['name'] = utf8_encode(stripslashes($sug_rows[$j]['name']));
									$good_sug_rows[] = $sug_rows[$j];
								}							
							}
						}
						$pub_rows[$i]['suggested'] = $good_sug_rows;
					}
					return json_encode($pub_rows);
					
					break;

				// ! SUBMIT_JSON_BIB_RECORDS
				case "submitJSONBibRecords":
					
					// if the id in the row is "import" then assume no record for this pub exists yet.
					// otherwise, just use the id to make a relationship.
					// ** no checking for duplicates is done here.
					
					/* ZOTERO JSON is of the form:
						{
						    "from_entity": "null",
						    "from_id": "null",
						    "records": [
						        {
						            "id": "import",
						            "pub_data": {
						                "id": 989,
						                "type": "book",
						                "title": "Developments in structural form",
						                "publisher": "M.I.T. Press",
						                "publisher-place": "Cambridge, Mass.",
						                "source": "Open WorldCat",
						                "event-place": "Cambridge, Mass.",
						                "ISBN": "0262131110 9780262131117",
						                "language": "English",
						                "author": [
						                    {
						                        "family": "Mainstone",
						                        "given": "R. J"
						                    }
						                ],
						                "issued": {
						                    "date-parts": [
						                        [
						                            "1975"
						                        ]
						                    ]
						                },
						                "suggested": []
						            }
						        },
						        {
						            "id": 3287
						        },
						        ...
						 */
						 
						
				// AUTH ************************					
					// does user have privs to save these changes to this Model?
					if (! $thisUser || ! $thisUser->get('id')) {
						return '[{"result":"FAILED: user must login"}]';
					}
					// AUTH ************************
						
					$pub_rows = json_decode($_POST['json_records'], true);
					
					logit("***");
					logIt( $_POST['json_records']);
					logit("*** ". sizeof($pub_rows));
					logit("*** ". $pub_rows[0]['id']);
					//return "---" .$pub_rows[0]['id'];//['title']; //$row['type'];
					
					foreach ($pub_rows as $row) {
						$id 	= $row['id'];
						$pub 	= $row['pub_data'];
						
						logIt('id = ' . $id);
						
						if(isset($id) && $id != "") {
							if ($id == "import") {
								$p = new Publication();
								
								$p->set("author_id", $thisUser->get("id"));
								
								//return $row['type'];
								
								// TYPE
								$p->set('type', addslashes($pub['type']));
								
								// TITLE
								$name = $pub['title'];
								$name = str_replace("ē", "e", $name);
								$p->set('name', addslashes($name));
								
								// ABSTRACT
								if(isset($pub['abstract']))
									$p->set('descript', addslashes($pub['abstract']));
								
								
								// AUTHORS
								$authstr = "";
								$authRstr = "";
								
								if (isset($pub['director'] )) {
									$pub_author = $pub['director'];
								} else {
									$pub_author = $pub['author'];
								}							
								foreach($pub_author as $auth) 
								{
									if($authstr != "") $authstr .= ";";
									$authstr .= $auth['given'] . ' ' . $auth['family'] ;
									
									if($authRstr != "") $authRstr .= ";";
									$authRstr .= $auth['family'] . ', ' . $auth['given'] ;
								}
								$p->set('contributors', addslashes($authstr));
								$p->set('authors', 		addslashes($authRstr));
								// save the actual json from zotero
								//$p->set('authors_json', json_encode($pub_author));
								
								// EDITORS
								$editorstr = "";
								foreach($pub['editor'] as $editor) 
								{
									if($editorstr != "") $editorstr .= ";";
									$editorstr  .= $editor['family'] . ', ' . $editor['given'] ;
								}
								$p->set('editors', utf8_decode(addslashes($editorstr)));
								
								// DATE
								$date = "";
								foreach( $pub['issued']['date-parts'][0] as $dpart) {
									if ($date != "") $date .= "-";
									$date .= $dpart;
								}
								$p->set('date', $date);
								
								$p->set('url', stripslashes($pub['URL']));
								
								switch($pub['type'])
								{
									case "book":
										// book mapping
										$p->set('pubtype', 6);
										$p->set('publisher', 		$pub['publisher']);
										$p->set('location', 		$pub['publisher-place']);
										$p->set('ISBN_ISSN', 		$pub['ISBN']);
										break;
									
									case "thesis":
										// book mapping
										$p->set('pubtype', 7);
										$p->set('publisher', 		$pub['publisher']);
										$p->set('location', 		$pub['publisher-place']);
										$p->set('ISBN_ISSN', 		$pub['ISBN']);
										break;
									
									case "article-journal":
										// journal article mapping									
										$p->set('pubtype', 17);
										$p->set('container_title', utf8_decode(addslashes($pub['container-title'])));
										$p->set('pages', 			$pub['page']);
										$p->set('volume', 			$pub['volume']);
										$p->set('callnumber', 		$pub['call-number']);
										$p->set('ISBN_ISSN', 		$pub['ISSN']);
										break;
									
									case "chapter":
										// journal article mapping									
										$p->set('pubtype', 5);
										$p->set('container_title', utf8_decode(addslashes($pub['container-title'])));
										$p->set('publisher', 		$pub['publisher']);
										$p->set('location', 		$pub['publisher-place']);
										$p->set('pages', 			$pub['page']);
										$p->set('volume', 			$pub['volume']);
										$p->set('callnumber', 		$pub['call-number']);
										$p->set('ISBN_ISSN', 		$pub['ISSN']);
										break;
										
									case "motion_picture":
										// book mapping
										$p->set('pubtype', 50);
										$p->set('publisher', 		$pub['publisher']);
										break;
									
								}
								
								logIt("HERE");
								
								$p->saveChanges();
								
	
							} else {
								$p = new Publication('ID', $id);
								
							}
							
								
							// if from_entity and from_id, make relationship
							logIt('RELATION:: '.$from_entity.', '.$from_id);
							if (isset($from_model) && isset($p) ) {
								logIt('ADDING RELATION:: '.$from_model->get('id').' to '.$p->get('id'));
							
								$from_model->addRelation($p);
							}
						}
						
					}	
					
					return json_encode($pub_rows);
					
					
					break;






					
				case "distinctFieldItems":

					$sql = 'SELECT distinct('.$fieldname.') FROM '. $tables[$entity] . ' WHERE '.$fieldname.' LIKE "'.$searchString.'%"';
					$ret_rows = $this->get_rows($sql);
					return json_encode($ret_rows);
					break;
					
				
				case "searchPubs":
					/*
						Check in both title field and related authors.
					*/
				
				
					break;
					
				case "searchCLIO":
				
					
					$arg = urlencode($_REQUEST['searchString']);
					$url = "http://clio.cul.columbia.edu:7018/vwebv/search?searchArg=".$arg."&searchCode=GKEY^*&searchType=0&recCount=50";
					$html = file_get_contents($url);
					return $html;
					
					
				
					break;
					
					
				case "searchJSTOR":
					
					$arg = urlencode($_REQUEST['searchString']);
					
					$getUrl = 'http://www.jstor.org/search/SRU/jstor'; // source 
					$getFields = array('query'=>$arg, 'version'=>'1.1', 'operation'=>'searchRetrieve', 'maximumRecords'=>'10'); //login form field names and values
					  
					
					$results = $this->getUrl($getUrl, 'get', $getFields); //request
					
					return $results;
					
				
					break;
				
				
				
				
				// ! REGISTER	
				case "register":
				
				
					if (! isset($_GET["firstname"]) ||  ! isset($_GET["lastname"]) ||  ! isset($_GET["email"]) ||  ! isset($_GET["pword"])  ) {
						return '[{"result":"FAILED: not enough information provided "}]';
					}
					$keys ['email'] = $_GET["email"];
			
					$registrant = new Person('KEYS', $keys);
					if (! $registrant->isNew()) {
						return '[{"result":"FAILED: Email already exists in the database"}]';
					}
					
				
					$registrant->set("firstname", 	$_GET["firstname"]);
					$registrant->set("lastname", 	$_GET["lastname"]);
					$registrant->set("name", 		$_GET["lastname"] . ', ' . $_GET["firstname"]);
					$registrant->set("pword", sha1($_GET["pword"]));
					$registrant->set("isUser", 1);
					
					$randKey = guid();
					$registrant->set("change_key",  $randKey );
					$registrant->saveChanges();
					
					mail($_GET["email"], "Archmap Registration","Archmap Registration\n\r\n\rThanks you for registering! To confirm your email, please click this link: \n\rhttp://archmap.org/api?request=emailConfirmation&n=".$randKey);
										
					return '[{"success":"true"}]';
					
					break;
				
				
				// ! EMAL CONFIRMATION
				case "emailConfirmation":
				
					$keys ['change_key'] = $_GET["n"];
					
					$person = new Person('KEYS', $keys);
					if (! $person->isNew()) {
						$person->set('isUser', 2);
						$person->saveChanges();
						
					}
				
					header('Location: http://archmap.org/istanbul?login_email='.$person->get('email'));
					exit;
					
				
				
				// ! LOGIN	
				case "login":
					$email = $_GET["email"];
					$pword = $_GET["pword"];
					
					
					
					if ($email != "" && $pword != "") {
					
						if (! strpos($email, '@')) {
							$email .= '@columbia.edu';
						}
						//println('login 1');
						$user = new Person('KEYS', array('email'=>$email));
						//println('login 2');
						if ($user && $user->get('id') != "") {											
							$session_id = $user->login($pword);
							if (! $session_id || $session_id == "" ) {
								return '[{"result":"FAILED: password incorrect "}]';
							}
							
							logIt($request_key,  g_endtime($starttime));
						
							return $user->asJSON();
						} else {
							return '[{"result":"FAILED: no user with that email "}]';
						}
					} else {
						return '[{"result":"FAILED: no email or password provided "}]';
					}
					break;
					
				case "tickle":
					if ($_GET["session_id"] != "") {
						$user = new Person('SESSION_ID', $_GET["session_id"]);
						if (isset($user) && $user->isLoggedIn()) {
							$user->tickle();
							return '[{"result":"SUCCESS"}]';
						} else {
							return '[{"result":"FAILED: no user logged-in with that session_id"}]';
						}
					} else {
						return '[{"result":"FAILED: no session_id"}]';
					}
					break;						
				case "logout":
					if ($_GET["session_id"] != "") {
						$user = new Person('SESSION_ID', $_GET["session_id"]);
						if (isset($user) && $user->isLoggedIn()) {
							$user->logout();
							return '[{"result":"SUCCESS"}]';
						} else {
							return '[{"result":"FAILED: no user logged-in with that session_id"}]';
						}
					} else {
						return '[{"result":"FAILED: no session_id"}]';
					}
					break;
					
				
									
				case "Building":
					$query = 'SELECT * FROM building WHERE id=' . $requestItems[2];
					$ret_rows = $this->get_rows($query);
					break;
				
				case "Users":
					$query = 'SELECT id, name FROM person WHERE isUser>0 ORDER BY isUser DESC, id ASC, name ASC';
					$ret_rows = $this->get_rows($query);
					break;
			
				case "getAuthorsRootItems":
					// establish the author
					if ($_GET["session_id"] != "") {
						$author = new Person('SESSION_ID', $_GET["session_id"]);

						// get the author's items
						$rootItemsJSON = $author->getRootItemsByClass("Essay", true);
						return $rootItemsJSON;
				
				
					} else {
						return '[{"result":"FAILED: no session_id"}]';
					}
					break;
				case "getAuthorImages":
					// establish the author
					if ($_GET["session_id"] != "") {
						$author = new Person('SESSION_ID', $_GET["session_id"]);

						// get the author's items
						$rootItemsJSON = $author->getRootItemsByClass("Image", true);
						return $rootItemsJSON;
				
				
					} else {
						return '[{"result":"FAILED: no session_id"}]';
					}
					break;
					
					
				case "getPlottedImages":
					//$sql = 'SELECT xloc, yloc, rotation, level FROM image_plot  WHERE image_id='.$id;
					$sql = 'SELECT xloc, yloc, rotation, level, filename, width, height FROM image i, image_plot p  WHERE p.image_id='.$id .' and p.media_type=1 and  p.media_id=i.id';
					$ret_rows = $this->get_rows($sql);
					
					
					break;
								
				default: 
				
					return '[{"result":"FAILED: unrecognized request"}]';			}
		
			
			if (isset($ret_rows)) {
		    	return json_encode($ret_rows);
		    }
		    
	    }	
	    
	    
		function getUrl($url, $method='', $vars='') {
		    $ch = curl_init();
		    if ($method == 'post') {
		        curl_setopt($ch, CURLOPT_POST, 1);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		    }
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies/cookies.txt');
		    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/cookies.txt');
		    $buffer = curl_exec($ch);
		    curl_close($ch);
		    return $buffer;
		}					

	    function get_rows($query) {
	    
	    	
	    
			$rows = array();
			$ret_rows = array();
			
			
			/*
			try {  
				$db = new PDO("mysql:host=learn.columbia.edu;dbname=arch_map", "mgf", "mgfmgfmgf");
					$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
					
					$result = $db->query($query);
					$rows = $result->fetchAll(PDO::FETCH_ASSOC);
					
					foreach($rows as $row) {
						if ($row["name"] != "") $row["name"] = utf8_encode(stripslashes($row["name"]));
						$ret_rows[] = $row;
					}
			}  
			catch(PDOException $e) {  
			    print('PDOErrors.txt: ' . $e->getMessage());  
			}  
			$db = null;
			
			$result = $this->db->queryAssoc($query);
			
			*/
			
			$ret_rows = $this->db->queryAssoc($query);
			
			
			return $ret_rows;
	    
	    }
	    
	    function getEntityRows($entity, $sql) {


			
			$rows = $this->db->queryAssoc($sql);
			

			$trows = array();
			foreach($rows as $row) {
				$cmd = 'return new '.$entity.'();';
				$tmp = eval($cmd);
				$tmp->initFromAssocRow($row);
				
				
				
				$tmp->set('partial', true);
				
				
				$tmp_attrs = $tmp->getEncodedAttrs($incl);
				
				if ($entity == "Building") {
					$tmp_attrs['plan_url'] 		= $tmp->floorplanURL(50);
					$tmp_attrs['poster_url'] 	= $tmp->posterURL(100);
				}
				if ($entity == "Image") {
					$tmp_attrs['urlLarge'] 		= $tmp->url('full');
				}
				
				
				
				$trows[] = $tmp_attrs;
				
			}
			
			
			return $trows;
		}			

	
		function getTheModel($entity, $id) {
		logIt("getTheModel 1: ".$entity.'::'.$id);
			if (! Request::$classNames[$entity])  
				return null;
			logIt("getTheModel 2: ".$entity.'::'.$id);
			if (! is_numeric($id)) 
				return null;
			logIt("getTheModel 3: ".$entity.'::'.$id);
			$cmd = 'return new '.$entity.'('.$id.');';
			return eval($cmd);
		}
	
		function utf8_encode_all($dat) // -- It returns $dat encoded to UTF8 
		{ 
		  if (is_string($dat)) return utf8_encode($dat); 
		  if (!is_array($dat)) return $dat; 
		  $ret = array(); 
		  foreach($dat as $i=>$d) $ret[$i] = utf8_encode_all($d); 
		  return $ret; 
		} 
	
	}


?>