<?php

echo '<h1>this is the home page</h1>';

$form = new Controlview($config);
$data = $form -> getIndex();
print_r($data);

?>
