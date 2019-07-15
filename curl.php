<?php

// THIS IS THE `CLIENT' SCRIPT

// Get cURL resource

// Set some options - we are passing in a useragent too here
// curl_setopt_array($curl, array(
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_URL => 'http://localhost:8080/index.php?json=67',
//     CURLOPT_USERAGENT => 'Sample cURL Request'
// ));

$my_curl = curl_init();
$url = 'http://localhost:8080/index.php?json=67';
// Send the request & save response to $resp
curl_setopt($my_curl, CURLOPT_URL, $url);
curl_setopt($my_curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($my_curl);
if ($result) {
    echo $result;
} else {
echo 'cURL failed'; }
curl_close($my_curl);




?>