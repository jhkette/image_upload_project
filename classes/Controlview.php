<?php
require_once './includes/functions.php';


class Controlview 


{
    private $config;

    public function __construct($config)
    {
       
        $this->config = $config;
    }
    // Function to get index page information
    protected function getIndex()
    {

    }


    protected function getForm()

    {   
        $content ='';
        $headerhtml = './templates/header.html';
        $header = file_get_contents($headerhtml);
        $content .=  $header;
      

        return $content;


    }
    public function submitForm ()
    {   
    
        if (isset($_POST['singlefileupload'])) {
            print_r($_POST);
            print_r($_FILES['userfile']);
            $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        
            if ($ext != "jpg") {
                echo 'only text file should be uploaded';
            } elseif ($_FILES['userfile']['type'] != "image/jpeg") {
                echo 'Not the correct mime type ';
            } else {
                if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                    $uploadedFile = $_FILES['userfile']['tmp_name']; 
                    echo $uploadedFile;
                    // print_r($sourceProperties = getimagesize($uploadedFile));

                   
                   
                    $updir = $this->config['upload_dir'];
                    $filename = $_FILES['userfile']['name'];
                    $fileonly = pathinfo($filename);
                    img_resize($uploadedFile, $this->config['thumbs'].$fileonly['filename'].'_small.jpg', 200, 200);
                    echo'<h1>' .$filename . '</h1>';
                    $upfilename = basename($_FILES['userfile']['name']);
                   
                    
                    $newname = $updir . $upfilename;
                 
                  
                    $tmpname = $_FILES['userfile']['tmp_name'];
                  
                    if (move_uploaded_file($tmpname, $newname)) {
                        echo 'File successfully uploaded';
                    } else {
                        echo 'File upload failed';
                        $error = $_FILES['userfile']['error'];
                        if ($error == UPLOAD_ERR_INI_SIZE) {
                            echo 'file upload failed size exceeded';
                        } elseif ($error == UPLOAD_ERR_FORM_SIZE) {
                            echo 'file upload faoiles form size exceeded';
                        } elseif ($error == UPLOAD_ERR_PARIAL) {
                            echo 'File upload failed - partial uplaod';
                        } elseif ($error == UPLOAD_ERR_NO_FILE) {
                            echo 'No file uploade';
                        } else {
                            echo 'Error code' . $error;
                        }
                    }
                }
            }
        }
    }
   


    public function printForm ()
    {
        echo $this -> getForm();
    }
   
}
?>
