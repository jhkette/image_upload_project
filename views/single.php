<?php
// require_once './includes/config.php';
/**
 * Building Web Applications using MySQL and PHP (W1)
 *
 * HOE - Uploading Files
 *
 * This file contains the file upload form, which submits to the same page
 *
 */

// Include the config file (this is where the upload directory is defined)
// Note: file is included with absolute path to avoid strange behaviour
// with __FILE__ when used in the include file


$form = new Controlview($config);

$data = $form -> validateForm();

$form -> printForm();

require './includes/imageform.php';

$form -> submitForm();




print_r($data);


// Check if the form has been submitted...



?>
