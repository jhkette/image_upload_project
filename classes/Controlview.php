<?php
require_once './helpers/imageresize.php';
require_once './helpers/printtemplate.php';

class Controlview extends Model
{
    // Function to get index page information
    public function getIndex()
    {
        $content = '';
        $header = './templates/header.html';
        $content .= file_get_contents($header);
        $data = $this->getAllPhotos();
        $list = './templates/thumbnail.html';
        $tpl = file_get_contents($list);
        $values = ['[+id+]', '[+title+]', '[+description+]', '[+name+]'];
        $content .= printTemplateArray($values, $data, $tpl);
        $footer = './templates/footer.html';
        $content .= file_get_contents($footer);

        return $content;
    }

    public function getImage($id)
    {
        $content = '';
        $header = './templates/header.html';
        $html = file_get_contents($header);
        $content .= $html;
        $data = $this->getImageData($id);
        $list = './templates/mainimage.html';
        $tpl = file_get_contents($list);
        $values = ['[+name+]','[+title+]','[+description+]','[+download+]','[+id+]'];
        $content = printTemplateArray($values, $data, $tpl);
        $footer = './templates/footer.html';
        $content .= file_get_contents($footer);
        return $content;
    }

    protected function getHeaderForm()
    {
        $content = '';
        $headerhtml = './templates/header.html';
        $header = file_get_contents($headerhtml);
        $content .= $header;
        return $content;
    }

    protected function getFooterForm()
    {
        $content = '';
        $footer = './templates/footer.html';
        $content = file_get_contents($footer);

        return $content;
    }
    public function submitForm()
    {
        if (isset($_POST['singlefileupload'])) {
            // if the file is uploaded
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                /* these two variable are used throuout file upload
                 and database update method so assigning them to variables here. */
                $uploadedFile = $_FILES['userfile']['tmp_name'];
                $filename = $_FILES['userfile']['name'];

               
                // sanitise string
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                list($width, $height, $type, $attr) = getimagesize(
                    $uploadedFile
                );
                // this is needed to create new filenames for main and thumb image directo
                $fileonly = pathinfo($filename);

                img_resize(
                    $uploadedFile,
                    $this->config['thumbs'] .
                        $fileonly['filename'] .
                        '_small.jpg',
                    150,
                    150
                );
                img_resize(
                    $uploadedFile,
                    $this->config['main'] . $fileonly['filename'] . '_main.jpg',
                    600,
                    600
                );
                // define data array indexes to send to model method 'addPost'
                $data = [
                    'filename' => $filename,
                    'width' => $width,
                    'height' => $height,
                    'description' => trim($_POST['description']),
                    'title' => trim($_POST['title']),
                    'file_main' => $fileonly['filename'] . '_main.jpg',
                    'file_thumb' => $fileonly['filename'] . '_small.jpg'
                ];

                $updir = $this->config['upload_dir'];
                $upfilename = basename($_FILES['userfile']['name']);
                $newname = $updir . $upfilename;

                // https://stackoverflow.com/questions/933081/try-catch-statement-in-php-where-the-file-does-not-upload
                //try doing above ...

                if (move_uploaded_file($uploadedFile, $newname)) {
                    /* we are only updating database if the file is uploaded succssfully.
                     the data is added in the model class method 'addpost' */
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
            // the file is uploaded - peform checks on it
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION); // get extension
                $uploadedFile = $_FILES['userfile']['tmp_name']; // get tmp file namae
                $filename = $_FILES['userfile']['name'];  // get actual file name
                $fileCheck = $this->checkFileName($filename); // check database for file name (this is a method in model)
                list($width, $height, $type, $attr) = getimagesize($uploadedFile);

                if ($type != IMAGETYPE_JPEG) {
                    $data['image_err'] =
                        'This file is not the correct mime type. only jpg file should be uploaded';
                } elseif ($ext != "jpg") {
                    $data['image_err'] =
                        'This is not the correct file extension';
                } elseif (!is_numeric($height)) {
                    $data['image_err'] =
                        'This is not a file that can be processed';
                } elseif(sizeof($fileCheck) != 0){
                    $data['image_err'] = 'This image name is already in use';
                } 
                else {
                    // image is ok so assign null to image_err value
                    $data['image_err'] = null;
                }
            }
            // the image is not uploaded - instruct user to upload it
            else {
                $data['image_err'] = 'Please upload an image';
            }
            if (empty($_POST['title'])) {
                $data['title_err'] = 'Please enter title';
            } else {
                $data['title'] = htmlentities($_POST['title']);
            }

            if (empty($_POST['description'])) {
                $data['description_err'] = 'Please enter description';
            } else {
                $data['description'] = htmlentities($_POST['description']);
            }
            return $data;
        }
    }

    protected function json($id)
    {
        // check that the id passed as an argument is a number
        if (is_numeric($id)) {
            $data = $this->getPhotoJson($id);
            // if you query an id that does not exist
            // it will be a valid query - but will return an empty array so a message is needed
            if (empty($data)) {
                return 'This photo is not in the database.';
            } else {
                // I'm using try catch block here in case there is any particular
                // problem with json_encode -ing the data. 
                try {
                    $newdata = json_encode($data);
                    if (json_last_error() == JSON_ERROR_NONE) {
                        // No errors occurred
                        return $newdata;
                    } else {
                        throw new Exception(json_last_error() . 'Error encoding JSON');
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }
        } else {
            return 'This is an invalid parameter.';
        }
    }



    public function header()
    {
        echo $this->getHeaderForm();
    }

    public function footer()
    {
        echo $this->getFooterForm();
    }

    public function printIndex()
    {
        echo $this->getIndex();
    }

    public function printMainImage($id)
    {
        echo $this->getImage($id);
    }

    // check this do you need to echo
    public function printjson($id)
    {
        echo $this->json($id);
    }
}
?>
