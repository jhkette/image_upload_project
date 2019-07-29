<?php 

$id = $_GET['image'];
$image = new Controlview($config, $phrases);
$image -> printMainImage($id);

?>