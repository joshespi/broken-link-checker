<?php
	function check_url($url) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_NOBODY, true);
	    if(strpos($url, 'provo.edu') !== false) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);      
	    }
	    $data = curl_exec($ch);
	    $headers = curl_getinfo($ch);
	    curl_close($ch);
	    return $headers['http_code'];
	}
	$results_file = 'results.txt';
	file_put_contents($results_file, '');
	$links_array = array();
	$scraped_links = file_get_contents('linksfound.txt');
	$parts = explode(' > ', $scraped_links);
	$i = 0;
	while( $i < count($parts)) {
		$file	= $parts[$i];
		$link	= str_replace(' ', '', $parts[++$i]);
		if(filter_var($link, FILTER_VALIDATE_URL)) {
			array_push($links_array, array($file,$link));
		}
					
		$i++;
	}
	file_put_contents($results_file, 'Links Found:' . count($links_array) . PHP_EOL, FILE_APPEND | LOCK_EX);
	
	//print_r($links_array);
	foreach($links_array as $object) {
		$check_url_status = check_url($object[1]);
		if($check_url_status == '200') {
		} elseif ($check_url_status == '405') {
			
		} else {
			$broken_link = 'file-> ' . $object[0] . ' url-> ' . $object[1] . PHP_EOL;
			file_put_contents($results_file, $broken_link, FILE_APPEND | LOCK_EX);
		}	
	}	
?>