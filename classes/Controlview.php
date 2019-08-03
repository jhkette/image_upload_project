<?php
require_once './helpers/imageresize.php';
require_once './helpers/printtemplate.php';

class Controlview extends Model
{
    /** 
    * This function gets all the html and data to display index page - and returns html in form of a string
    * @return string $content - cotains index page html
    */

    public function getIndex()
    {
        $content = '';
        $header = file_get_contents('./templates/header.html');
        $v = array('[+title+]');
        $r = array($this->phrases['index_title']);
        $content .= printTemplate($v, $r, $header); // get header using helper function
        $values = array('[+heading+]');
        $replacements = array($this->phrases['index_heading']);
        $banner = file_get_contents('./templates/bannerthumb.html');
        $content .= printTemplate($values, $replacements, $banner);   // get banner using helper function
        // send flash success message if file has just been uploaded
        if (isset($_SESSION['upload-file'])) {
            $messageHTML = file_get_contents('./templates/upload.html');
            $message = array('[+message+]');
            $rep = array($this->phrases['success']);
            $content .= printTemplate($message, $rep,  $messageHTML);
        }
        $content .= file_get_contents('./templates/container.html'); 
        $data = $this->getAllPhotos();  // get photos data from model 
        $tpl = file_get_contents('./templates/thumbnail.html');
        $values = ['[+id+]', '[+title+]', '[+description+]', '[+name+]'];
        $content .= printTemplateArray($values, $data, $tpl);  // get main body content using helper function
         
        $content .= file_get_contents('./templates/footer-home.html');

        return $content;
    }

    /** 
    * This function gets all the html and data to display image detail page - and returns html in form of a string
    * @param int $id - the id of the relevant image
    * @return string $content - cotains image page html
    */

    public function getImage($id)
    {
        $content = '';
        $header = file_get_contents('./templates/header.html');
        $data = $this->getImageData($id);

        $v = array('[+title+]');
        if (isset($data[0])) {
            $r = array('PicUpload: ' . $data[0]['title']); // the title will be the image description unless id is not in database
        } else {
            $r = ['PicUpload: Unknown image'];
        }
        /* if the $id is not a valid id in the database I am presenting an error. */
        if (!is_numeric($id)){
            $content .= printTemplate($v, $r, $header);
            $content .='<p class="image-error">'. $this->phrases['photo-number']. '<p>';
            return $content;
        }
        /*If id is a number but not in database - there will not be an sql error - but I am still presenting a message
        to communicate that this photo is not in the database */
        if (empty($data)) {
            $content .= printTemplate($v, $r, $header);
            $content .= '<p class="image-error">'. $this->phrases['photo-absent']. '<p>';
            return $content;
            
        }
        $content .= printTemplate($v, $r, $header);
        $tpl = file_get_contents('./templates/mainimage.html');
        $values = ['[+name+]','[+title+]','[+description+]','[+download+]','[+id+]'];
        $content .= printTemplateArray($values, $data, $tpl);
        $content .= file_get_contents('./templates/footer.html');
        return $content;
    }

    /** 
    * This function gets all the html and data to display the 404 page - and returns html in form of a string
    * @return string $content - contains 404 page html
    */

    public function get404()
    {
        $content = '';
        $header = file_get_contents('./templates/header.html');
        $v = array('[+title+]');
        $r = array($this->phrases['404_title']);
        $content .= printTemplate($v, $r, $header);
        $values = array('[+heading+]');
        $replacements = array($this->phrases['404_heading']);
        $banner = file_get_contents('./templates/banner.html');
        $content .= printTemplate($values, $replacements, $banner);
        $content .= file_get_contents('./templates/footer.html');

        return $content;
    }

    /** 
    * These two function get all the html and data to display the header and footer - and returns html in form of a string
    * @return string $content - cotains 404 page html
    */

    protected function getHeaderForm()
    {
        $content = '';
        $header = file_get_contents('./templates/header.html');
        $v = array('[+title+]');
        $r = array($this->phrases['upload_title']);
        $content .= printTemplate($v, $r, $header);
        $banner = file_get_contents('./templates/banner1.html');
        $values = array('[+heading+]');
        $replacements = array($this->phrases['upload_heading']);
        $content .= printTemplate($values, $replacements, $banner);
        return $content;
    }

    protected function getFooterForm()
    {
        $content = file_get_contents('./templates/footer.html');
        return $content;
    }
    
    /** 
    * This function validates form - validating image and text inputs
    * @return array $data - data to present errors or represent inputted data
    * if error errors don't exist submit form is called
    */

    public function validateForm()
    {
        if (isset($_POST['singlefileupload'])) {
            $data = [];
            // the file is uploaded - peform checks on it
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                $ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION); // get extension
                $uploadedFile = $_FILES['userfile']['tmp_name']; // get tmp file namae
                $filename = $_FILES['userfile']['name']; // get actual file name
                $fileCheck = $this->checkFileName($filename); // check database for file name (this is a method in model class)
                list($width, $height, $type, $attr) = getimagesize($uploadedFile);
                if ($type != IMAGETYPE_JPEG) {
                    //type is from getimagesize array - it is the mime type
                    $data['image_err'] = $this->phrases['jpg-error'];
                } elseif ($ext != "jpeg" && $ext != "jpg") {
                    // this is from pathinfoextension. 'jpg' files can also have an extension 'jpeg'
                    $data['image_err'] =$this->phrases['jpg-ext'];
                } elseif (!is_numeric($height)) {
                    // cheking height returns a number - this again helps ensure it is an image.
                    $data['image_err'] = $this->phrases['process-err'];
                } elseif (sizeof($fileCheck) != 0) {
                    // checking the filename has not already been used.
                    $data['image_name_err'] = $this->phrases['name-err'];
                } elseif(ctype_space($filename)){
                    $data['image_err'] = $this->phrases['space-err'];
                }
                else {
                    // image is ok so assign null to image_err value
                    $data['image_err'] = null;
                }
            }
            // the image is not uploaded - instruct user to upload it
            else {
                $data['image_err'] = $this->phrases['image-err'];
            }
            if (empty($_POST['title'])) {
                $data['title_err'] = $this->phrases['title-err'];
            } else {
                $data['title'] = htmlentities($_POST['title']);
            }
            if (empty($_POST['description'])) {
                $data['description_err'] =  $this->phrases['description-err'];
            } else {
                $data['description'] = htmlentities($_POST['description']);
            }
            return $data;
        }
    }


    /* Function that submits form and adds data to database by calling addPost($data) method in model */

    public function submitForm()
    {
        if (isset($_POST['singlefileupload'])) {
            // if the file is uploaded
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                /* these three variable are used throughout file upload
                 and database update method so assigning them to variables here. */
                $uploadedFile = $_FILES['userfile']['tmp_name'];
                $filename = basename($_FILES['userfile']['name']); //get filenamse
                $fileonly = pathinfo($filename);  // this is needed to create new filenames for main and thumb image directory

                list($width, $height, $type, $attr) = getimagesize($uploadedFile);
              
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
                $newname = $updir . $filename; // concatenate upload director and filename
                $small = img_resize($uploadedFile,$this->config['thumbs'] . $fileonly['filename'] . '_small.jpg',150,150);
                $medium = img_resize($uploadedFile,$this->config['main'] . $fileonly['filename'] . '_main.jpg',600,600);

                $move = move_uploaded_file($uploadedFile, $newname);
                if ($move && $medium && $small) {
                    // session variable created for flash messaging - communicates to user file has been uploaded
                    $_SESSION['upload-file'] = true;

                    /* we are only updating database if the file is uploaded succssfully and if image resize has returned
                     a true value. The data (from the array above) is added in the model class method 'addpost' */
                    $this->addPost($data);
                } else {
                    echo  $this->phrases['ffailed'];
                    $error = $_FILES['userfile']['error'];
                    if ($error == UPLOAD_ERR_INI_SIZE) {
                        echo $this->phrases['filesize'];
                    } elseif ($error == UPLOAD_ERR_FORM_SIZE) {
                        echo $this->phrases['fileform'];
                    } elseif ($error == UPLOAD_ERR_PARTIAL) {
                        echo $this->phrases['filepartial'];
                    } elseif ($error == UPLOAD_ERR_NO_FILE) {
                        echo $this->phrases['filenofile'];
                    } else {
                        echo $this->phrases['filecode'];
                    }
                }
            }
        }
    }

    /** 
    * This function gets all the html and data to create a json object. It create the object by creating
    * a new instance of the Jsondata class. 
    * @param int $id - the id of the relevant image
    * @return object $json - object containing image data
    */

    protected function json($id)
    { // check that the id passed as an argument is a number
        if (is_numeric($id)) {
            $data = $this->getPhotoJson($id);
            /* if you query an id that does not exist
             it will be a valid query - but will return an empty array so a message is needed */
            if (empty($data)) {
                return $this->phrases['json-find'];
            } else {
                /* I'm using try catch block here in case there is any particular
                 problem with json_encode -ing the data. */
                try {
                    $object = new Jsondata($data);
                    $json = json_encode($object);
                    if (json_last_error() == JSON_ERROR_NONE) {
                        return $json;  // No errors occurred
                    } else {
                        throw new Exception(
                            json_last_error() . $this->phrases['json-err']
                        );
                    }
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }
        } else {
            return $this->phrases['json-find'];
        }
    }

    /* The following methods are public and are called to echo out html in
    each relevant view */

    // prints header
    public function header()
    {
        echo $this->getHeaderForm();
    }
     // prints footer
    public function footer()
    {
        echo $this->getFooterForm();
    }
    // prints index page
    public function printIndex()
    {
        echo $this->getIndex();
    }
    // prints 404 page
    public function print404()
    {
        echo $this->get404();
    }
    /**
    * @param int $id - the id of the relevant image
    * @return string string containing html which is printed
    */
    public function printMainImage($id)
    {
        echo $this->getImage($id);
    }

    /**
    * @param int $id - the id of the relevant image
    * @return object $json - object containing image data
     */
    public function printJson($id)
    {
        echo $this->json($id);
    }
}
?>
