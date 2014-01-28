
<?php

$xml = new SimpleXMLElement('<xml/>');

$file = 'tweets.xml';
require_once 'lib/twitteroauth.php';
 
define('CONSUMER_KEY', 'Wd0OgAQpht1DxCUntkWezA');
define('CONSUMER_SECRET', 'jUnwseE0ArfUowyNGIkT2fXeqEfcbh5Xex7YYOPPo0s');
define('ACCESS_TOKEN', '98267363-Zr9ncziKIkgDw8CyD2pJAKNFiw3QD9QYI5uQhOHxn');
define('ACCESS_TOKEN_SECRET', 'Xj44oXfzyqbS8kD1BzFCreOm9FssmqOFSDDYtRvimHBnz');
 
$toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
 
$results = $toa->get('https://api.twitter.com/1.1/search/tweets.json?q=%23omgrobots&count=200');

foreach ($results->statuses as $result) {
  	$item = $xml->addChild('twitter');
	$item->addChild('twithandle', $result->user->screen_name);
	$item->addChild('twitdate', $result->created_at);
	$item->addChild('twitprofileImage', $result->user->profile_image_url);
	$item->addChild('twittext',$result->text);
	//echo $result->user->screen_name . ":<br> " . $result->created_at. "<br>".$result->user->profile_image_url." <br> <title>".$result->text . "</title><br><br>\n";
  	
}
/*$results = $toa->get('https://api.twitter.com/1.1/search/tweets.json?q=%40uofg&count=50');

foreach ($results->statuses as $result) {
  echo $result->user->screen_name . ":<br> " . $result->created_at. "<br>".$result->user->profile_image_url." <br> ". " <br>". $result->text . "<br><br>\n";
  
}*/

//header('Content-type: text/xml');
print($xml->asXML());

file_put_contents($file, $xml->asXML());
?>
