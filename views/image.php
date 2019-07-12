<?php 
$id = $_GET['image'];
echo 'hello i am an image';
$image = new Controlview($config);
$image -> getImage($id); 

?>