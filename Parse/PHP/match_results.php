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
	$url = "http://www2.usfirst.org/".$year."comp/events/".$code."/matchresults.html";
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
		if($last_singular == "Blue Score" && $match_data_count == 0){
			$start_matches = TRUE;
		}else if($last_singular == "Blue Score"){
			$elims = TRUE;
		}
		if (strpos($singular,'Data') !== false) {
			$start_matches = FALSE;
		}
		if (strpos($singular,'Match') !== false) {
			$elims = FALSE;
		}
		if($start_matches){
			array_push($match_data, $singular);
			$match_data_count++;	
		}
		if($elims){
			array_push($elims_data, $singular);
			$elims_data_count++;	
		}
		$last_singular = $singular;
		
}
for($i = 0; $i < count($match_data); $i+=10){
	$item = $xml->addChild('qualification');
	$item->addChild('time', $match_data[$i]);
	$item->addChild('match', $match_data[$i+1]);
	$item->addChild('red1', $match_data[$i+2]);
	$item->addChild('red2',$match_data[$i+3]);
	$item->addChild('red3',$match_data[$i+4]);
	$item->addChild('blue1', $match_data[$i+5]);
	$item->addChild('blue2',$match_data[$i+6]);
	$item->addChild('blue3',$match_data[$i+7]);
	$item->addChild('redscore',$match_data[$i+8]);
	$item->addChild('bluescore',$match_data[$i+9]);
}
for($i = 0; $i < count($elims_data); $i+=11){
	$item = $xml->addChild('eliminations');
	$item->addChild('time', $elims_data[$i]);
	$item->addChild('description', $elims_data[$i+1]);
	$item->addChild('match', $elims_data[$i+2]);
	$item->addChild('red1',$elims_data[$i+3]);
	$item->addChild('red2',$elims_data[$i+4]);
	$item->addChild('red3', $elims_data[$i+5]);
	$item->addChild('blue1',$elims_data[$i+6]);
	$item->addChild('blue2',$elims_data[$i+7]);
	$item->addChild('blue3',$elims_data[$i+8]);
	$item->addChild('redscore',$elims_data[$i+9]);
	$item->addChild('bluecore',$elims_data[$i+10]);
}
//var_dump($match_data);
				
$file = 'results/'.$year.'/'.$code.'.xml';

//foreach ($results->statuses as $result) {
  	
//}

//print($xml->asXML());

file_put_contents($file, $xml->asXML());

echo "parsed";
}
?>