<?php

// THIS IS THE `CLIENT' SCRIPT

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://127.0.0.1/birkbeck/HOE10/test.php?type=fruit',
    CURLOPT_USERAGENT => 'Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);

// Get the error codes and messages
if(curl_errno($curl)) {
    echo 'Code: ' . curl_errno($curl);
    echo 'Message: ' . curl_error($curl);
} else {
    // Decode the response & process it
    $data = json_decode($resp, true);
    foreach($data as $id => $value) {
        echo '<p>ID: '.$id.', Value: '.$value.'</p>';
    }
}

// Get array of info about the transfer
$info = curl_getinfo($curl);

// Close request to clear up some resources
curl_close($curl);

?>