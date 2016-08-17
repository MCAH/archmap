<h1>jStor Test</h1>

<?

		
		
		
		$host =  "http://www.jstor.org";
		
		$res = http_get("http://www.jstor.org/search/SRU/jstor?query=cat&version=1.1&maximumRecords=100&cql.serverChoice=SEARCH-TERM");	
			
		
		echo $res;
		
		
		
		
		
	function http_get($url) 
	{ 

	    $url_stuff = parse_url($url); 
	    $port = isset($url_stuff['port']) ? $url_stuff['port'] : 80; 
	
	    $fp = fsockopen($url_stuff['host'], $port); 
	
	    $query  = 'GET ' . $url_stuff['path'] . " HTTP/1.0\n"; 
	    $query .= 'Host: ' . $url_stuff['host']; 
	    $query .= "\n\n"; 
	
	    fwrite($fp, $query); 
	
	    while ($tmp = fread($fp, 1024)) 
	    { 
	        $buffer .= $tmp; 
	    } 
	
	    preg_match('/Content-Length: ([0-9]+)/', $buffer, $parts); 
	    return substr($buffer, - $parts[1]); 
	    
	 }
?> 


