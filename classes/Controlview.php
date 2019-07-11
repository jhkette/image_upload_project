<?php
require_once './helpers/imageresize.php';


class Controlview extends Model


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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING); 
            $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION); 
            if ($ext != "jpg") {
                echo 'only jpg file should be uploaded';
            } elseif ($_FILES['userfile']['type'] != "image/jpeg") {
                echo 'Not the correct mime type ';
            } else {
                if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                    if(empty($_POST['title'])){
                        $data['title_err'] = 'Please enter title';
                    }
                    if(empty($_POST['description'])){
                        $data['description_err'] = 'Please enter description';     
                    }
                    
                    if(isset($data['title_err']) || isset($data['description_err'])){
                        return $data;
                    }  
                    $data['description'] = $_POST['description'];
                    $data['title'] = $_POST['title'];
                   
                    $uploadedFile = $_FILES['userfile']['tmp_name'];    
                    $updir = $this->config['upload_dir'];
                    $filename = $_FILES['userfile']['name'];
                    list($width, $height, $type, $attr) = getimagesize($uploadedFile);
                    $data['filename'] = $filename;
                    $data['width'] = $width;
                    $data['height'] = $height;

                    
                 
                    $fileonly = pathinfo($filename);
                    img_resize($uploadedFile, $this->config['thumbs'].$fileonly['filename'].'_small.jpg', 200, 200);
                    echo'<h1>' .$filename . '</h1>';
                    $upfilename = basename($_FILES['userfile']['name']);
                    img_resize($uploadedFile, $this->config['upload_dir'].$fileonly['filename'].'_main.jpg', 600, 600);
                    $data['file_main'] = $fileonly['filename'].'_main.jpg';
                    $data['file_thumb'] = $fileonly['filename'].'_thumb.jpg';

                    $newname = $updir . $upfilename;
                 
                  
                    $tmpname = $_FILES['userfile']['tmp_name'];
                  
                    if (move_uploaded_file($tmpname, $newname)) {
                        $this->addPost($data); 
                        echo 'File successfully uploaded';
                      header('Location: /');
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
    

   public function validateForm(){
    if (isset($_POST['singlefileupload'])) {
        $data = [];
        $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
        
        if ($ext != "jpg") {
            $data['ext'] = 'only jpg file should be uploaded';
        } elseif ($_FILES['userfile']['type'] != "image/jpeg") {
            $data['mime'] = 'Not the correct mime type ';
        } else {
            
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
            

                if(empty($_POST['title'])){
                    $data['title_err'] = 'Please enter title';
                }else{
                    $data['title'] = $_POST['title'];
                }

                if(empty($_POST['description'])){
                    $data['description_err'] = 'Please enter description';     
                }else{
                    $data['description'] = $_POST['description'];
                }

            }
        }
        return $data;
    }

   }


    public function printForm ()
    {
        echo $this -> getForm();
    }
   
}
?>
