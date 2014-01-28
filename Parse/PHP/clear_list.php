<?
$file = '2013list.xml';

$xml = new SimpleXMLElement('<xml/>');

file_put_contents($file, $xml->asXML());

?>