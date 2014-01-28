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
	$url = "http://www2.usfirst.org/".$year."comp/events/".$code."/ScheduleQual.html";
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

foreach($data as $singular) {
		if($last_singular == "Blue 3" && $match_data_count == 0){
			$start_matches = TRUE;
		}
		if (strpos($singular,'Match') !== false) {
			$start_matches = FALSE;
		}
		if($start_matches){
			array_push($match_data, $singular);
			$match_data_count++;	
		}
		$last_singular = $singular;
		
}
for($i = 0; $i < count($match_data); $i+=8){
	$item = $xml->addChild('qualification');
	$item->addChild('time', $match_data[$i]);
	$item->addChild('match', $match_data[$i+1]);
	$item->addChild('red1', $match_data[$i+2]);
	$item->addChild('red2',$match_data[$i+3]);
	$item->addChild('red3',$match_data[$i+4]);
	$item->addChild('blue1', $match_data[$i+5]);
	$item->addChild('blue2',$match_data[$i+6]);
	$item->addChild('blue3',$match_data[$i+7]);
}
				
$file = 'schedule/'.$year.'/'.$code.'.xml';

//foreach ($results->statuses as $result) {
  	
//}

//print($xml->asXML());

file_put_contents($file, $xml->asXML());

echo "parsed";
}
?>