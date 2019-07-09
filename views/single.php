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

$form -> printForm();

?>
<h1>Upload a file:</h1>	
<form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8'); ?>" method="post">
    <div>
        <label for="fileinput">Upload a file:</label>
        <!-- "name" of input (userfile) will be the "key" in $_FILES -->
        <input name="userfile" type="file" id="fileinput" />
    </div>
    <div>
        <input type="submit" value="Upload File" name="singlefileupload" />
    </div>
</form>
<?php

$form -> submitForm();

// Check if the form has been submitted...



?>
