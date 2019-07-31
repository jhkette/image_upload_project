<?php

// THIS IS THE `CLIENT' SCRIPT

// Get cURL resource

// Set some options - we are passing in a useragent too here
// curl_setopt_array($curl, array(
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_URL => 'http://localhost:8080/index.php?json=67',
//     CURLOPT_USERAGENT => 'Sample cURL Request'
// ));




//step1
$cSession = curl_init(); 
//step2
curl_setopt($cSession,CURLOPT_URL,"http://titan.dcs.bbk.ac.uk/~jkette01/upload/index.php?json=2");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
//step3
$result=curl_exec($cSession);


//step4
curl_close($cSession);
//step5
echo $result;



?>