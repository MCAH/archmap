<?php

		ini_set("memory_limit","256M");
		
		error_reporting(E_ERROR | E_PARSE);
	
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Setup.php');
		require_once ($_SERVER['DOCUMENT_ROOT']  . '/archmap_2/Database.php');
	
		println("All authors");
	
	
		$db = new Database();
		
		$sql = 'select *  from publication';
		
		$rows =  $db->queryAssoc($sql);
		
		foreach($rows as $row) {
		
			$c = $row['contributors'];
			
			$nc = "";
			$json = "[";
			if (isset($c) && $c != "")
			{
				print ('<br><br>'.$row['contributors'].' <hr>');
				$aparts = split(';', $c);
				foreach($aparts as $a) {
					$a = trim($a);
					
					print('-'.$a.'<br>');
					
					//$nparts = split(' ', $a);
					$pos = strrpos($a, ' ', -1);
					$first = trim(substr($a, 0, $pos));
					$family = trim(substr($a, $pos));
					
					if ($json != "[") $json .=",";
					$json .= '{"family":"'.$family.'","given"""'.$first.'"}';
					
					$as = $family.', '.$first;
					
					if ($nc != "") $nc .=";";
					$nc .= $as;
				}
				
			}
			$json .= "]";
			print("...".$nc."...");
			
			//$sql = 'update publication set authors="'.$nc.'" where id='.$row['id'];
			$sql = "update publication set authors_json='".$json."' where id=".$row['id'];
			$db->submit($sql);
		}
?>