<?php
	include("simple_html_dom.php");
	include("clear_list.php");
	
	
//$xml = new SimpleXMLElement('<xml/>');
    $curl = curl_init();
	$url = "http://georgemavroidis.com/cd/Parse/PHP/events2013.html";
    curl_setopt ($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
	
	$html = new simple_html_dom();
	$html->load($result);
	
	$data = array();
	$base_url = "https://my.usfirst.org/myarea/index.lasso";
	//Find All links
	foreach($html->find('a') as $element) {
		  //echo $element->href . '<br>';
		  array_push($data, $element->href);
	}
	//Offset the first 7 links and then make an array of urls
	$useless_offset = 7;
	$new_url_array = array();
	for($i = $useless_offset; $i < count($data); $i++){
		$new_url = $data[$i];
		$new_url = str_replace("amp;", '', $new_url);
		$new_url = str_replace("\n", '', $new_url);
		$new_url = str_replace("andnbsp;", '', $new_url);
		array_push($new_url_array, trim($new_url));
	}



//var_dump( $new_url_array[0]);
foreach($new_url_array as $link){
	specific_regional($link);
	echo $link;
}

function specific_regional($regional_link){
	$file = '2013list.xml';

	$xml = simplexml_load_file($file);
	//$xml = new SimpleXMLElement('<xml/>');
	
	$regional_curl = curl_init();
	$url = $regional_link;
	curl_setopt ($regional_curl, CURLOPT_URL,$url);
	curl_setopt($regional_curl, CURLOPT_VERBOSE, true);
	curl_setopt($regional_curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($regional_curl, CURLOPT_SSL_VERIFYPEER, false);
	$regional_result = curl_exec ($regional_curl);
    curl_close ($regional_curl);
	
	$regional_html = new simple_html_dom();
	$regional_html->load($regional_result);
	
	$regional_data = array();
	foreach($regional_html->find('td') as $element) {
     //echo $element->plaintext. '<br>';
	  array_push($regional_data, trim($element->plaintext));
	}
	$last_singular = "";
	$start_matches = FALSE;
	$match_data_count = 0;
	$match_data = array();
	
	foreach($regional_data as $singular) {
			if($last_singular == "Event" && $match_data_count == 0){
				$start_matches = TRUE;
			}
			if (strpos($singular,'Capacity') !== false) {
				$start_matches = FALSE;
			}
			if($start_matches){
				$singular = str_replace(",", '', $singular);
				$singular = str_replace(".", '', $singular);
				$singular = str_replace("&", 'and', $singular);
				$singular = str_replace("andnbsp;", '', $singular);
				array_push($match_data, trim($singular));
				$match_data_count++;	
			}
			$last_singular = $singular;
			
	}
	
	$code_array = array();
	foreach($regional_html->find('a') as $element) {
	  array_push($code_array, trim($element->href));
	}
	$code = fetch_code($code_array[count($code_array)-2]);
	$where = str_replace("&nbsp", '', $match_data[6]);
	
	$item = $xml->addChild('regional');
	$item->addChild('event', $match_data[0]);
	$item->addChild('when', str_replace(" ", '', $match_data[4]));
	$item->addChild('where', $where);
	$item->addChild('teams',end($match_data));
	$item->addChild('code',$code);
	
	
	var_dump($match_data);
	$file = '2013list.xml';
	file_put_contents($file, $xml->asXML());
	
}
function fetch_code($url){
	$find = explode('/', $url);
	$returned_code = $find[5];
	return $returned_code;	
}



?>