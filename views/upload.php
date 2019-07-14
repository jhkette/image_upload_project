<?php


$form = new Controlview($config);
// instantiate data variable
$data = [];

$form->printForm();
    if (isset($_POST['singlefileupload'])) {
        $data = $form->validateForm();
    }

require './includes/imageform.php';
if (empty($data['description_err']) &&  
    empty($data['title_err']) &&
    empty($data['image_err'])){ 
    // only submit form if there are no errors
    $form->submitForm(); 
}



?>
