<?php

	if($_GET['filepath']) {
	
		$output = shell_exec('exiftool -a -u -g1 -j ../../../'.$filepath);
		$json = json_decode($output,TRUE);
		
		echo '
			<h3>author :: '.$json[0]["IPTC"]["By-line"].'</h3>
			<h5>camera :: '.$json[0]["IFD0"]["Make"].' // '.$json[0]["IFD0"]["Model"].'</h5>';
		
		
		echo '
			<pre>';
		
		//print_r($json);
		
		echo '
			</pre>';
	
	}

?>