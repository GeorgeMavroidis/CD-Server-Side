<?php
$t=time();
echo($t);

file_put_contents('counter.txt', $t);
?>