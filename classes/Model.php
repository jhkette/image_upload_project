<?php
class Model extends Database
{
    protected function getIndex()
    {
        $this->connect();
        $this->disconnect();
    }

    public function getImageData($id){
        $data =[];
        $this->connect();
        // escape mysqli string
        $id = $mysqli->real_escape_string($id);
        $sql = "SELECT file_main, title, description_p FROM photos WHERE id = $id";
    
        $results = $this->conn->query($sql);
        if ($results === false) {
            echo 'error';
            $this->disconnect();
        } else {
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            $results -> free();
            $this->disconnect();
            return $data;
        }
    }

    protected function getUpload()
    {
        $this->connect();

        $this->disconnect();
    }

    public function addPost($data)
    {   
        // USE LIST MAYBE??... TO SHORTEN 
        $title = mysqli_real_escape_string($data['title']);
        $description = mysqli_real_escape_string($data['description']);
        $filename = mysqli_real_escape_string($data['filename']);
        $height = mysqli_real_escape_string($data['height']);
        $width = mysqli_real_escape_string($data['width']);
        $imgmain = mysqli_real_escape_string($data['file_main']);
        $imgthumb = mysqli_real_escape_string($data['file_thumb']);
        $this->connect();
        $sql = "INSERT INTO photos (file_info, file_main, file_thumb, title, description_p, width, height ) VALUES('$filename', '$imgmain', '$imgthumb', '$title', '$description',  '$height',  '$width')";
        $insert = $this->conn->query($sql);
        if ($insert === false) {
            // echo $this->language['error_data'];
            $this->disconnect();
        } else {
            // $insert -> free();
            $this->disconnect();

            header('Location: /');
        }
     
    }

    public function getAllPhotos(){
        $this->connect();
        $sql = "SELECT id, title, description_p, file_thumb
        FROM photos
        ORDER BY id DESC";
        $data;
        $results = $this->conn->query($sql);

        if ($results === false) {
            echo $this->language['error_data'];
            $this->disconnect();
        } else {
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            $results -> free();
            $this->disconnect();
            return $data;
        }

    }
}

?>
