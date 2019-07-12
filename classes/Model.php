<?php
class Model extends Database
{
    protected function getIndex()
    {
        $this->connect();
        $this->disconnect();
    }

    protected function getUpload()
    {
        $this->connect();

        $this->disconnect();
    }

    public function addPost($data)
    {
        $title = $data['title'];
        $description = $data['description'];
        $filename = $data['filename'];
        $height = $data['height'];
        $width = $data['width'];
        $imgmain = $data['file_main'];
        $imgthumb = $data['file_thumb'];
        $this->connect();
        $sql = "INSERT INTO photos (file_info, file_main, file_thumb, title, description_p, width, height ) VALUES('$filename', '$imgmain', '$imgthumb', '$title', '$description',  '$height',  '$width')";
        $insert = $this->conn->query($sql);
        if ($insert === false) {
            // echo $this->language['error_data'];
            $this->disconnect();
        } else {
            echo '<h1>Data added</h1>';
            // $insert -> free();
            $this->disconnect();

            header('Location: /');
        }
     
    }

    public function getAllPhotos(){
        $this->connect();
        $sql = "SELECT id, title, description_p, file_thumb
        FROM photos";
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
