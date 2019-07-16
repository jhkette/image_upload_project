<?php 
$id = $_GET['image'];
$image = new Controlview($config);



$image -> printMainImage($id);

?>