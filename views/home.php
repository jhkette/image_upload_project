<?php



$form = new Controlview($config, $phrases);
$form -> printIndex();

unset($_SESSION['upload-file']);
?>
