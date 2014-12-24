<?php
$file = fopen("transit/1A_Week.csv","r");
print_r(fgetcsv($file));
fclose($file);
?>