<?php
require_once './bootstrap.php';





// //step1
// $cSession = curl_init(); 
// //step2
// curl_setopt($cSession,CURLOPT_URL,"http://titan.dcs.bbk.ac.uk/~jkette01/upload/index.php?json=2");
// curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
// curl_setopt($cSession,CURLOPT_HEADER, false); 
// //step3
// $result=curl_exec($cSession);


// //step4
// curl_close($cSession);
// //step5
// echo $result;

// $my_curl = curl_init();
// $url = 'http://titan.dcs.bbk.ac.uk/~jkette01/upload/index.php?json=2'; 
// curl_setopt($my_curl, CURLOPT_URL, $url); 
// curl_setopt($my_curl, CURLOPT_RETURNTRANSFER, true); 
// $result = curl_exec($my_curl);
// // Get the error codes and messages 
// if(curl_errno($my_curl)) {
//     echo 'Code: ' . curl_errno($my_curl);
// echo 'Message: ' . curl_error($my_curl); } else {
//     echo $result;
// }
// Get array of info about the transfer

$model = new Model($config, $phrases);
$data = $model->getPhotoJson(149);

$object = new Jsondata($data);
$json = json_encode($object);
echo $json;




?>