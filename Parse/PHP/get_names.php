<?php
	include("simple_html_dom.php");
	
	$team;
	$run = TRUE;
	if(isset($_GET['team'])){
		$team = $_GET['team'];
	}else{
		$run = FALSE;	
	}
if($run){
	$xml = new SimpleXMLElement('<xml/>');
    $curl = curl_init();
	
	$base_url = "http://www.thebluealliance.com/team/";
	$url = $base_url.$team;
    curl_setopt ($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
	
	$html = new simple_html_dom();
	$html->load($result);

$data = array();

foreach($html->find('h2') as $element) {
      echo $element->plaintext;
		array_push($data, trim($element->plaintext));
}
$match_data_count = 0;
$team_data = array();

foreach($data as $singular) {
	array_push($team_data, $singular);
}

	/*for($i = 0; $i < count($match_data); $i+=10){
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
		
$file = 'standings/'.$year.'/'.$code.'.xml';
*/
//foreach ($results->statuses as $result) {
  	
//}

//print($xml->asXML());

//file_put_contents($file, $xml->asXML());

//echo "parsed";
}
?>