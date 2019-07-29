<?php header('Content-type: application/json');
$id = $_GET['json'];
$json = new Controlview($config, $phrases);
$json -> printjson($id);

?>