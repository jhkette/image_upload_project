<?php
require_once './helpers/imageresize.php';
require_once './helpers/printtemplate.php';

class Controlview extends Model
{
    // Function to get index page information
    public function getIndex()
    {
        $content = '';
        // print header
        $headerHtml = './templates/header.html';
        $header = file_get_contents($headerHtml);
        $v = array('[+title+]');
        $r = array($this->phrases['index_title']);
        $content .= printTemplate($v, $r, $header);
        // send flash success message if file has just been uploaded
        if (isset($_SESSION['upload-file'])) {
            $messagefile = './templates/upload.html';
            $messageHTML = file_get_contents($messagefile);
            $message = array('[+message+]');
            $rep = array($this->phrases['success']);
            $content .= printTemplate($message, $rep,  $messageHTML);
        }
        // print banner
        $values = array('[+heading+]');
        $replacements = array($this->phrases['index_heading']);
        $bannerfile = './templates/banner.html';
        $banner = file_get_contents($bannerfile);
        $content .= printTemplate($values, $replacements, $banner);
        // get photos from db and main body content
        $data = $this->getAllPhotos();
        $list = './templates/thumbnail.html';
        $tpl = file_get_contents($list);
        $values = ['[+id+]', '[+title+]', '[+description+]', '[+name+]'];
        $content .= printTemplateArray($values, $data, $tpl);
         // print footer
        $footer = './templates/footer.html';
        $content .= file_get_contents($footer);

        return $content;
    }

    public function getImage($id)
    {
        $content = '';
        $headerHtml = './templates/header.html';
        $header = file_get_contents($headerHtml);

        $data = $this->getImageData($id);

        $v = array('[+title+]');
        if (isset($data[0])) {
            $r = array('PicUpload: ' . $data[0]['description_p']); // the title will be the image description unless id is not in database
        } else {
            $r = ['PicUpload: Unknown image'];
        }
        /* if the $id is not valid a id in the database I am presenting an error. Were this in production
         I would just present this message and log the catch error (from the model class method getImageData) to a text file. 
         As it is I am presenting both the printed error and catch message. */
        if (!is_numeric($id)) {
            $content .= printTemplate($v, $r, $header);
            $content .=
                '<p class="image-error">This is not an image we have in our collection<p>';
            echo $content;
            return; 
        }
        /*If id is a number but not in database - there will not be an sql error - but I am still presenting a message
        to communicate that this photo is not in the database */
        if (empty($data)) {
            $content .= printTemplate($v, $r, $header);
            $content .=
                '<p class="image-error">This is not an image we have in our collection<p>';
            echo $content;
            return;
        }
        $content .= printTemplate($v, $r, $header);

        $list = './templates/mainimage.html';
        $tpl = file_get_contents($list);
        $values = ['[+name+]','[+title+]','[+description+]',
            '[+download+]',
            '[+id+]'
        ];
        $content .= printTemplateArray($values, $data, $tpl);
        $footer = './templates/footer.html';
        $content .= file_get_contents($footer);
        return $content;
    }

    public function get404()
    {
        $content = '';
        $headerHtml = './templates/header.html';
        $header = file_get_contents($headerHtml);
        $v = array('[+title+]');
        $r = array($this->phrases['404_title']);
        $content .= printTemplate($v, $r, $header);
        $values = array('[+heading+]');
        $replacements = array($this->phrases['404_heading']);
        $bannerfile = './templates/banner.html';
        $banner = file_get_contents($bannerfile);
        $content .= printTemplate($values, $replacements, $banner);
        $footer = './templates/footer.html';
        $content .= file_get_contents($footer);

        return $content;
    }

    protected function getHeaderForm()
    {
        $content = '';
        $headerHtml = './templates/header.html';
        $header = file_get_contents($headerHtml);
        $v = array('[+title+]');
        $r = array($this->phrases['upload_title']);

        $content .= printTemplate($v, $r, $header);
        $banner = './templates/banner1.html';
        $values = array('[+heading+]');
        $replacements = array($this->phrases['upload_heading']);
        $bannerfile = './templates/banner.html';
        $banner = file_get_contents($bannerfile);
        $content .= printTemplate($values, $replacements, $banner);
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

                list($width, $height, $type, $attr) = getimagesize($uploadedFile);
                // this is needed to create new filenames for main and thumb image directo
                $fileonly = pathinfo($filename);

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

                $updir = $this->config['upload_dir']; //upload directory
                $upfilename = basename($_FILES['userfile']['name']); // get filename
                $newname = $updir . $upfilename;
                $small = img_resize(
                    $uploadedFile,
                    $this->config['thumbs'] .
                        $fileonly['filename'] .
                        '_small.jpg',
                    150,
                    150
                );
                $medium = img_resize(
                    $uploadedFile,
                    $this->config['main'] . $fileonly['filename'] . '_main.jpg',
                    600,
                    600
                );
                $move = move_uploaded_file($uploadedFile, $newname);
                if ($move && $medium[0] && $small[0]) {
                    // session variable created for flash messaging - communicates to user file has been uploaded
                    $_SESSION['upload-file'] = true;

                    /* we are only updating database if the file is uploaded succssfully and if image resize has returned
                     a true value. The data (from the array above) is added in the model class method 'addpost' */
                    $this->addPost($data);
                } else {
                    echo 'File upload failed';
                    $error = $_FILES['userfile']['error'];
                    if ($error == UPLOAD_ERR_INI_SIZE) {
                        echo 'file upload failed size exceeded';
                    } elseif ($error == UPLOAD_ERR_FORM_SIZE) {
                        echo 'file upload faoiles form size exceeded';
                    } elseif ($error == UPLOAD_ERR_PARTIAL) {
                        echo 'File upload failed - partial uplaod';
                    } elseif ($error == UPLOAD_ERR_NO_FILE) {
                        echo 'No file upload';
                    } else {
                        echo 'Error code' . $error;
                    }
                }
            }
        }
    }

    public function validateForm()
    {
        if (isset($_POST['singlefileupload'])) {
            $data = [];
            // the file is uploaded - peform checks on it
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $ext = pathinfo(
                    $_FILES['userfile']['name'],
                    PATHINFO_EXTENSION
                ); // get extension
                $uploadedFile = $_FILES['userfile']['tmp_name']; // get tmp file namae
                $filename = $_FILES['userfile']['name']; // get actual file name
                $fileCheck = $this->checkFileName($filename); // check database for file name (this is a method in model class)
                list($width, $height, $type, $attr) = getimagesize(
                    $uploadedFile
                );

                if ($type != IMAGETYPE_JPEG) {
                    //type is from getimagesize array - it is the mime type
                    $data['image_err'] =
                        'This file is not the correct mime type. only jpg file should be uploaded';
                } elseif ($ext != "jpeg" && $ext != "jpg") {
                    // this is from pathinfoextension. 'jpg' files can also have an extension 'jpeg'
                    $data['image_err'] =
                        'This is not the correct file extension';
                } elseif (!is_numeric($height)) {
                    // cheking height returns a number - this again helps ensure it is an image.
                    $data['image_err'] =
                        'This is not a file that can be processed';
                } elseif (sizeof($fileCheck) != 0) {
                    // checking the filename has not already been used.
                    $data['image_err'] = 'This image name is already in use';
                } else {
                    // image is ok so assign null to image_err value
                    $data['image_err'] = null;
                }
            }

            // FILTER_SANITIZE_STRING USE THIS MB
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
            /* if you query an id that does not exist
             it will be a valid query - but will return an empty array so a message is needed */
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
                        throw new Exception(
                            json_last_error() . 'Error encoding JSON'
                        );
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

    public function print404()
    {
        echo $this->get404();
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
