<?
ini_set('max_execution_time', 300000); //300 seconds = 5 minutes

$number_of_files = count(glob("regionals/*.txt"));
$files = glob("regionals/*.txt");
$off = 91;
$end = 93;
for($i = $off; $i < $end; $i++){
	$filename = $files[$i];
    $data = file_get_contents($filename);
	$data_to_array = explode(",", $data);
	$count = 0;
	file_put_contents("regionals/names/".$filename, "");
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
			file_put_contents("regionals/names/".$filename, $result, FILE_APPEND);
		}else{
			file_put_contents("regionals/names/".$filename, $result.",", FILE_APPEND);
		}
	}
	echo $filename." count = ".$count." <br>";
	
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
