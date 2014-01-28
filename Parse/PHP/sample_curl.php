<?php
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, "http://www2.usfirst.org/2013comp/events/ONTO2/matchresults.html");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec ($curl);
    curl_close ($curl);
    print $result;
?>