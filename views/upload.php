<?php

$form = new Controlview($config, $phrases);
// instantiate data variable
$data = [];

$form->header();
if (isset($_POST['singlefileupload'])) {
    $data = $form->validateForm();
}
/* we need to use php in html for the form. So we cannot simply 'echo' it out. 
Instead I have echoed header and footer and included the form - which is in the includes folder
*/
include './includes/imageform.php';
 /* I'm  only submitting the form if there are no errors. They will be in the 
  data variable which is assigned to the result of validateForm if present */
if (empty($data['description_err']) &&  
    empty($data['title_err']) &&
    empty($data['image_err'])){ 
   
    $form->submitForm(); 
}

$form->footer();

?>
