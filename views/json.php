<?php 
header('Content-type: application/json');
$id = $_GET['json'];
$json = new Controlview($config);
$json -> printjson($id);



?>