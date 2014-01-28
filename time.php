<?php

$File = "counter.txt"; 
 //This is the text file we keep our count in, that we just made

 $handle = fopen($File, 'r+') ; 
 //Here we set the file, and the permissions to read plus write

 $data = fread($handle, 512) ; 
 //Actully get the count from the file
 print $data; 
 
?>