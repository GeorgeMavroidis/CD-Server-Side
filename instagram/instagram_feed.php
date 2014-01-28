<?php    

$xml = new SimpleXMLElement('<xml/>');
$file = 'instagram.xml';   
$count = 0;
    // Get class for Instagram
    // More examples here: https://github.com/cosenary/Instagram-PHP-API
    require_once 'instagram.class.php';

   
	$instagram = new Instagram('f2e3a18e1a2045cf96e7c097ba2af292');

    // Set keyword for #hashtag
    $tag = 'omgrobots';
    // Get latest photos according to #hashtag keyword
    $media = $instagram->getTagMedia($tag);
	
    // Set number of photos to show
    $limit = 40;

    // Set height and width for photos
    //$size = '300';

    // Show results
    // Using for loop will cause error if there are less photos than the limit
    foreach(array_slice($media->data, 0) as $data)
    {
		$item = $xml->addChild('instagram');
		$item->addChild('instaHandle', $data->user->username);
		$item->addChild('likes', $data->likes->count);
		$item->addChild('instaImage', $data->images->standard_resolution->url);
		$item->addChild('instaCaption', $data->caption->text);
		$count++;
    }
	
    $result = $instagram->pagination($media);
	foreach(array_slice($result->data, 0) as $data)
    {
		$item = $xml->addChild('instagram');
		$item->addChild('instaHandle', $data->user->username);
		$item->addChild('likes', $data->likes->count);
		$item->addChild('instaImage', $data->images->standard_resolution->url);
		
		$item->addChild('instaCaption', $data->caption->text);
		$count++;
    }
	
	$res = $instagram->pagination($result);
	foreach(array_slice($res->data, 0) as $data)
    {
		$item = $xml->addChild('instagram');
		$item->addChild('instaHandle', $data->user->username);
		$item->addChild('likes', $data->likes->count);
		$item->addChild('instaImage', $data->images->standard_resolution->url);
		$item->addChild('instaCaption', $data->caption->text);
		
		$count++;
    }
	
	$res2 = $instagram->pagination($res);
	foreach(array_slice($res2->data, 0) as $data)
    {
		$item = $xml->addChild('instagram');
		$item->addChild('instaHandle', $data->user->username);
		$item->addChild('likes', $data->likes->count);
		$item->addChild('instaImage', $data->images->standard_resolution->url);
		$item->addChild('instaCaption', $data->caption->text);
		
		$count++;
    }
	
print($xml->asXML());

file_put_contents($file, $xml->asXML());
?>