<?
ini_set('max_execution_time', 300000); //300 seconds = 5 minutes
$number_of_files = count(glob("regionals/2013/*.txt"));
$files = glob("regionals/2013/*.txt");
$off = 60;
$end = 75;

for($i = $off; $i < $end; $i++){
	$filename = $files[$i];
	//echo $filename;
    $data = file_get_contents($filename);
	$data_to_array = explode(",", $data);
	//echo $filename;
	file_put_contents("regionals/2013/".$filename, "");
	$count = 0;
	foreach ($data_to_array as $team){
		$count++;
		$curl = curl_init();
		$url = "http://georgemavroidis.com/cd/Parse/PHP/get_names.php?team=".$team;
		curl_setopt ($curl, CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
		$result = curl_exec ($curl);
		curl_close ($curl);	
		
		//echo $result."<br>";
		if($count == count($data_to_array)){
			file_put_contents("regionals/2013/".$filename, $result, FILE_APPEND);
		}else{
			file_put_contents("regionals/2013/".$filename, $result.",", FILE_APPEND);
		}
	}
	echo $filename." and teams = ".$count."<br>";
	
}




/*for($i = 3794; $i<5352; $i++){
	$curl = curl_init();
	$url = "http://georgemavroidis.com/cd/Parse/PHP/get_names.php?team=".$i;
    curl_setopt ($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);	
	
	echo $result."<br>";	
	file_put_contents("team_names.txt", $result.",", FILE_APPEND);
}
*/
?>
