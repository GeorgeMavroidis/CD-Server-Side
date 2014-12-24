<?php
	include("simple_html_dom.php");
	
	$team;
	$year;
	$comment;
	
	$run = TRUE;
	if(isset($_GET['team']) && isset($_GET['year']) && isset($_GET['comment'])){
		$team = $_GET['team'];
		$year = $_GET['year'];
		$comment  = $_GET['comment'];
	}else{
		$run = FALSE;	
	}
if($run){
					
$file = 'comments/'.$year.'/'.$team.'.txt';
$comment = str_replace("__space__"," ",$comment);
file_put_contents($file, ",".$comment, FILE_APPEND);
//echo $comment;
echo "parsed";
}
?>