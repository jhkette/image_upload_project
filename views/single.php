<?php
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

include_once './includes/config.php';
// Include the HTML header
include_once './includes/head.html';

// Check if the form has been submitted...
if (isset($_POST['singlefileupload'])) {
	print_r($_FILES['userfile']);
    $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);

	if ($ext != "jpg") {
			echo  'only text file should be uploaded';
	}
	elseif($_FILES['userfile']['type'] != "image/jpeg"){
		echo  'Not the correct mime type ';
	}
	else{
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	$updir = $config['upload_dir'];
	$upfilename = basename($_FILES['userfile']['name']);
	$newname = $updir.$upfilename;
	$tmpname = $_FILES['userfile']['tmp_name'];
	if (move_uploaded_file($tmpname, $newname)) {
	echo 'File successfully uploaded';
	}


	else {
	echo 'File upload failed';
		$error = $_FILES['userfile']['error'];
		if($error == UPLOAD_ERR_INI_SIZE){
			echo 'file upload failed size exceeded';
		}
		else if($error == UPLOAD_ERR_FORM_SIZE){
			echo 'file upload faoiles form size exceeded';
		}
		else if($error == UPLOAD_ERR_PARIAL){
			echo 'File upload failed - partial uplaod';
		}
		else if($error == UPLOAD_ERR_NO_FILE){
			echo 'No file uploade';
		}
		else{
			echo 'Error code' . $error;
		}


	}
	}
}

}




?>

    <body>


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
// Include the HTML footer
include_once $config['app_dir'].'/includes/footer.html';
?>
