<?
include("simple_html_dom.php");

    $curl = curl_init();
	$url = "https://my.usfirst.org/myarea/index.lasso?page=searchresults&sort_events=name&-session=myarea:0A7D788702fb600C93jMVX3BC566#FRC_events";
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
	$new_url = $base_url.$data[$i];
	$new_url = str_replace("amp;", '', $new_url);
	$new_url = str_replace("\n", '', $new_url);
	array_push($new_url_array, trim($new_url));
}

	//$file = 'regional_links.txt';
	//file_put_contents($file, implode(',', $new_url_array));


?>