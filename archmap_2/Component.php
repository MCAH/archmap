<?php	


	//require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Model.php');
	//require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Building.php');
	//require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap/codebase/models/Publication.php');

	/*
	 * Component
	 */
	
	class Component {
	
		var $model;
		var $dataSource;
		var $attributes;
		var $domDoc;
		var $node;
		var $html;
		var $scripts = array();
		var $html_tags = array("","component","#comment","#text",
			"br","h1","h2","h3","h4","h5","table","tr","td","hr","div",
			"span","link","option","ul","li","form","fieldset","legend", "label","input","textarea",
			"a","p","style","script","html","head","body","pre","img","select", "button");
		
		var $modelClassName = array("building"=>"Building", 
									"person"=>"Person", 
									"place"=>"Place", 
									"publication"=>"Publication");
		
		function Component($filename = null) {
			$this->domDoc 	= new DomDocument();
			
			//$attributes = $_GET;
			//print($filename . '<br />');
		 	$modelClassName = array("building"=>"Building", 
		 							"person"=>"Person", 
		 							"place"=>"Place", 
		 							"publication"=>"Publication");
			
			if(isset($filename)) {
				
				$tplFileName = $filename;
			} else {
				
				$tplFileName = 'components/'.$this->getPathName().'.xml';
			}
			
			

			if(is_file($tplFileName)) {
				//print("is file <br />");
				$res = $this->domDoc->load($tplFileName);
				if($res)
					$this->node = $this->domDoc->firstChild;
				else
					print('bad xml in: '.$tplFileName.'<br />');
			} else {
				//print("is NOT file <br />");
			}		
		}
		
		function getPathName() {
			return "Component";
		}
		
		function setModel($m){
			$this->model = $m;
		}
		function setModelWithId($id) {
			// OVERRIDE to allow each component to decide what class it instantiates
		}

		function getScripts() {
			return $this->scripts;
		}

		function process($node = null) {
			
			$output = ""; // big concatenating string for return
			
			if (! $node) $node = $this->node;
			$tagName = $node->nodeName;
			$compNameParts = explode(".", $tagName);
			
			foreach($compNameParts as $compNamePart) {
				if (isset($componentPath)) $componentPath .= "/";
				$componentPath .= $compNamePart;
			}
			$tagName = $compNameParts[sizeof($compNameParts)-1];
			
			
			
			
			$controllerFile = 'components/'.$componentPath.'.php';
			$templateFile   = 'components/'.$componentPath.'.xml';
				
			$isCustomTag = (in_array(strtolower($tagName), $this->html_tags)) ? null : 1;
			
			if ( $isCustomTag ) { // CUSTOM COMPONENT	
				
				// QROWS ************************************************** //
				if ($tagName == "qrows") {
					
					// SELECT 
					$select = $node->getAttribute('select');
					if (! isset($select) || $select == "") $select = '*';

					// FROM (TABLES)
					$from = $node->getAttribute('from');
					if (! isset($from) || $from == "") $from = 'building';
					
					// WHERE 
					$where = $node->getAttribute('where');
					$where = $this->parseLiteral($where);
					if (! isset($where) || $where == "")  $where = '1';
					else $where = $this->parseLiteral($where);
					
					// ORDERBY
					$orderby = $node->getAttribute('orderby');
					if (! isset($orderby) || $orderby == "" ) $orderby = "name";

					// LIMIT
					$start = $node->getAttribute('start');
					if (! isset($start) || $start < 1) $start = 0;

					$step = $node->getAttribute('step');
					if (! isset($step) || $step < 1) $step = 10;

					
					$sql = 'SELECT '.$select.' FROM '.$from.' WHERE '.$where.' ORDER BY '.$orderby.' LIMIT '.$start.', ' . $step;
					
					
					
					try {  
						$db = new PDO("mysql:host=www.learn.columbia.edu;dbname=arch_map", "mgf", "mgfmgfmgf");
	  					$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	
	 					$rows = $db->query($sql);
					}  
					catch(PDOException $e) {    
					    print('PDOErrors.txt: ' . $e->getMessage());  
					}  
					$db = null;
							
							
								
					$ii = 0;
					if ($rows) {
						foreach($rows as $row) {
							$modelClassName = array("building"=>"Building", 
													"person"=>"Person", 
													"place"=>"Place", 
													"publication"=>"Publication");
							
							
							if ($node->getAttribute('entity')) {
								$cmd = 'return new '.$node->getAttribute('entity').'($row);';
							} else if ($row['entity_id']) {
								$cmd = 'return new '.getEntity($row['entity_id']).'($row);';
							
							} else {
								$cmd = 'return new GenericRecord($row);';
							}
							$model = eval($cmd);
									
						
								
							foreach($node->childNodes as $cnode) {
								$compon = new Component();
								$compon->dataSource = $this->dataSource;
								//$compon->attributes['iii'] = $rows[$count]['name']; //$count;
								$compon->setModel($model);
								$compon->node = $cnode;
								$output .= $compon->process();
							}
							
							//foreach($node->childNodes as $cnode) {
							//	$output .= $this->process($cnode);
							//}
	
						}
					}
								
					
				}
				
				else if ($tagName == "person") {
					//foreach ($node->attributes as $attr) 
			        //{ 
			        //    $array[$attr->nodeName] = $attr->nodeValue; 
			        //}
			        
			        $id = $node->getAttribute('id');
			        

					$sql = 'SELECT * FROM '.$tagName.' WHERE id=' . $id;
				
					try {  
						$db = new PDO("mysql:host=www.learn.columbia.edu;dbname=arch_map", "mgf", "mgfmgfmgf");
	  					$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	
	 					$result = $db->query($sql);
	 					$result->setFetchMode(PDO::FETCH_ASSOC);
	 						 				
	 					$model = new Person($result->fetch());
					}  
					catch(PDOException $e) {    
					    print('PDOErrors.txt: ' . $e->getMessage());  
					}  
					$db = null;
					
					
					foreach($node->childNodes as $cnode) {
						$compon = new Component();
						$compon->dataSource = $this->dataSource;
						//$compon->attributes['iii'] = $rows[$count]['name']; //$count;
						$compon->setModel($model);
						$compon->node = $cnode;
						$output .= $compon->process();
					}

					
			        		
				}
				
					
				else if (is_file($controllerFile)) { // HAS CONTROLLER
				
				
					require_once ($controllerFile);
					$cmd = 'return new '.$tagName.'("'.$templateFile.'");';
									
					$compon = eval($cmd);
					$compon->dataSource = $this->dataSource;
					$compon->setModel($this->model);
					$output .= '<div>'.$compon->process().'</div>';
					foreach($compon->getScripts() as $script)
						array_push($this->scripts,$script);
				}
				else if (is_file($templateFile)) { // NO CONTROLLER
					$compon = new Component($templateFile);
					$output .= $compon->process();
					foreach($compon->getScripts() as $script)
						array_push($this->scripts,$script);
				}
				else {
					$output .= '<div class="unknown">['.$tagName.' goes here]</div>';
				}
				
			}
			
			// special case:
			// pass javascript to class array of scripts
			// which is loaded after the html document is loaded
			
			//else if($tagName == "script") {
			//	array_push($this->scripts,$this->domDoc->saveXML($node));
			//}
			
			else if($node->childNodes) { // ----------- TYPICAL TAG WITH CHILDREN (e.g. br, hr, a, etc.)
				// rebuild open tag
				
				if ($tagName == "input") {
				
					$output .= "<".$tagName;
					foreach ($node->attributes as $attrName => $attrNode) {
						$output .= " " . $attrName . '="' .$this->parseLiteral($attrNode->nodeValue). '"';
					}
					$output .= " />";
				
				} else {
				
					$output .= "<".$tagName;
					foreach ($node->attributes as $attrName => $attrNode) {
						$output .= " " . $attrName . '="' .$this->parseLiteral($attrNode->nodeValue). '"';
					}
					$output .= ">";
					// process internals
					foreach($node->childNodes as $cnode) {
	
						$compon = new Component();
						$compon->node = $cnode;
						$compon->attributes = $this->attributes;
						$compon->setModel($this->model);
						$output .= $compon->process();
					}
					// rebuild close tag
					$output .= "</".$tagName.">";
				}
			}
			else if($tagName == "#text") { //  ----------- TEXT NODE
				$text = $this->parseLiteral($node->textContent);
				$output .= $text;
			}
			else { //  ----------- DEFAULT
				//$output .= $this->domDoc->saveXML($node);
			}
			
			return $output; // everything, built up recursively
		}
		
		function parseLiteral($text) {
			preg_match_all("/\{(\w.*?)\}/", $text, $matches, PREG_SET_ORDER);
			foreach ($matches as $val) {
				//println('matchcount: '.$val[1]); 
				if ($val[1] == "NE") {
					$text = str_replace($val[0], "<>", $text);
				} else if ($val[1] == "amp") {
					$text = str_replace($val[0], "&", $text);
				} else {
					
					$parts = explode(".", $val[1]);
					if (sizeof($parts)==1) {
						//print_r($this->attributes);
						$text = str_replace($val[0], $this->attributes[$parts[0]], $text);
					} else {
				   		if(isset($this->model) && $this->model != "") {
				   			if ($this->model->get($parts[1]) != "") {
				   				$text = str_replace($val[0], $this->model->get($parts[1]), $text);
				   			} else {
				   			
				   				switch($parts[1]) {
				   					case "lat": 
				   					case "lng":
				   						$default = 0;
				   						break;
				   					case "descript":
				   					case "title":
				   					case "caption":
				   						$default = $parts[1];
				   						break;
				   						
				   					default:
				   						$default = "";
				   				
				   				}
				   				$text = str_replace($val[0], $default, $text);
				   			}
				    		
				    	}
					}
				}
			}
			return $text;		
		}
	 
	}
	
?>