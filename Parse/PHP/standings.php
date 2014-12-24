<?php
	include("simple_html_dom.php");
	
	$code;
	$year;
	$run = TRUE;
	if(isset($_GET['code']) && isset($_GET['year'])){
		$code = $_GET['code'];
		$year = $_GET['year'];
	}else{
		$run = FALSE;	
	}
if($run){
	$xml = new SimpleXMLElement('<xml/>');
    $curl = curl_init();
	
	$url = "http://www2.usfirst.org/".$year."comp/events/".$code."/rankings.html";
    curl_setopt ($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
	
	$html = new simple_html_dom();
	$html->load($result);

$data = array();
foreach($html->find('td') as $element) {
      //echo $element->plaintext . '<br>';
		array_push($data, trim($element->plaintext));
}
$last_singular = "";
$start_matches = FALSE;
$elims = FALSE;
$match_data_count = 0;
$match_data = array();
$elims_data_count = 0;
$elims_data = array();
$flagged = FALSE;
foreach($data as $singular) {
		if($last_singular == "BP"){
				$flagged = TRUE;
		}
		if($last_singular == "Played" && $match_data_count == 0){
			$start_matches = TRUE;
		}
		if (strpos($singular,'QS') !== false) {
			$start_matches = FALSE;
		}
		if($start_matches){
			$singular = str_replace(",", '', $singular);
			$singular = str_replace("&", 'and', $singular);
			$singular = str_replace("andnbsp;", '', $singular);
			array_push($match_data, $singular);
			
			$match_data_count++;	
		}
		$last_singular = $singular;
		
}
if($year == "2014" || $flagged){
	
	for($i = 0; $i < count($match_data); $i+=10){
		$item = $xml->addChild('standings');
		$item->addChild('rank', $match_data[$i]);
		$item->addChild('team', $match_data[$i+1]);
		$item->addChild('one', $match_data[$i+2]);
		$item->addChild('two',$match_data[$i+3]);
		$item->addChild('three',$match_data[$i+4]);
		$item->addChild('four', $match_data[$i+5]);
		$item->addChild('five', $match_data[$i+6]);
		$item->addChild('record',$match_data[$i+7]);
		$item->addChild('dq',$match_data[$i+8]);
		$item->addChild('played',$match_data[$i+9]);
	}
		
}else{
	for($i = 0; $i < count($match_data); $i+=9){
		$item = $xml->addChild('standings');
		$item->addChild('rank', $match_data[$i]);
		$item->addChild('team', $match_data[$i+1]);
		$item->addChild('one', $match_data[$i+2]);
		$item->addChild('two',$match_data[$i+3]);
		$item->addChild('three',$match_data[$i+4]);
		$item->addChild('four', $match_data[$i+5]);
		$item->addChild('record',$match_data[$i+6]);
		$item->addChild('dq',$match_data[$i+7]);
		$item->addChild('played',$match_data[$i+8]);
	}		
}			
$file = 'standings/'.$year.'/'.$code.'.xml';

//foreach ($results->statuses as $result) {
  	
//}

//print($xml->asXML());

file_put_contents($file, $xml->asXML());

echo "parsed";
}
?>