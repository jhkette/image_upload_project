<?php
require_once './helpers/imageresize.php';
require_once './helpers/printtemplate.php';

class Controlview extends Model
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    // Function to get index page information
    public function getIndex()
    {
        // $headerhtml = './templates/header.html';
        // $header = file_get_contents($headerhtml);
        // $values = array('[+title+]', '[+heading+]');
        // // $replacements = array($this->phrases['home_title'], $this->phrases['home_heading'], 'current');
        // $content = '';
        // $content .= printTemplate($values, $replacements, $header);
        $data = $this->getAllPhotos();
        $list = './templates/thumbnail.html';
        $tpl = file_get_contents($list);
        $values = ['[+id+]','[+title+]', '[+description+]', '[+name+]'];
        $content = printTemplateArray($values, $data, $tpl);

        // $footer = './templates/footer.html';
        // $content .= file_get_contents($footer);

        return $content;
    }
    public function getImage($id){
        echo 'AN IMAGE my image id is'.  $id;
        
    }

    protected function getForm()
    {
        $content = '';
        $headerhtml = './templates/header.html';
        $header = file_get_contents($headerhtml);
        $content .= $header;
        return $content;
    }

    public function submitForm()
    {
        if (isset($_POST['singlefileupload'])) {
            
            // these two variable are used throuout file upload 
            // and database update method
            $uploadedFile = $_FILES['userfile']['tmp_name'];
            $filename = $_FILES['userfile']['name'];
             
            // sanitise string
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // if the file is uploaded
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
               
                list($width, $height, $type, $attr) = getimagesize($uploadedFile);
                // this is needed to create new filenames for main and thumb image directo
                $fileonly = pathinfo($filename);
                
                
                img_resize(
                    $uploadedFile,
                    $this->config['thumbs'] .
                        $fileonly['filename'].'_small.jpg',
                    200,
                    200
                );
                img_resize(
                    $uploadedFile,
                    $this->config['main'] .
                        $fileonly['filename'] .
                        '_main.jpg',
                    600,
                    600
                );
                $updir = $this->config['upload_dir'];
                $upfilename = basename($_FILES['userfile']['name']);
                $newname = $updir . $upfilename;

                $uploadedFile = $_FILES['userfile']['tmp_name'];
                
                $data['filename'] = $filename;
                $data['width'] = $width;
                $data['height'] = $height;
                $data['description'] = $_POST['description'];
                $data['title'] = $_POST['title'];
                $data['file_main'] = $fileonly['filename'] . '_main.jpg';
                $data['file_thumb'] = $fileonly['filename'] . '_small.jpg';
               
                if (move_uploaded_file($uploadedFile, $newname)) {
                    // we are only updating database if the file is uploaded succssfully.
                    // the data is added in the model class method 'addpost'
                    $this->addPost($data);
                   
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

    // this needs to be changed - tidy else ifs so they make sense - we need
    // to just check main aspects of form before it is submitted
    public function validateForm()
    {
        if (isset($_POST['singlefileupload'])) {
            $data = [];
            
            
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
            $uploadedFile = $_FILES['userfile']['tmp_name'];
            list($width, $height, $type, $attr) = getimagesize($uploadedFile);
          
            if($type != IMAGETYPE_JPEG){
                $data['image_err'] = 'This file is not the correct mime type. only jpg file should be uploaded';
            }
            elseif ($ext != "jpg") {
                $data['image_err'] = 'This is not the correct file extension';
            }
            elseif(!is_numeric($height)){
                $data['image_err'] = 'This is not a file that can be processed';
            }
          
            else{
                // image is ok so assign null to image_err value 
                $data['image_err'] = null;
            }
            }
            else{
                $data['image_err'] = 'Please upload an image';
            }

          
                // if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {

                if (empty($_POST['title'])) {
                    $data['title_err'] = 'Please enter title';
                } else {
                    $data['title'] = $_POST['title'];
                }

                if (empty($_POST['description'])) {
                    $data['description_err'] = 'Please enter description';
                } else {
                    $data['description'] = $_POST['description'];
                }

                // }
         
            return $data;
        }
    }

    public function printForm()
    {
        echo $this->getForm();
    }

    public function printIndex()
    {
        echo $this->getIndex();
    }
}
?>
