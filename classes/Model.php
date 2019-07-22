<?php
class Model extends Database
{
    protected function getImageData($id)
    {
        $data = [];
        $this->connect();

        try {
            // escape mysqli string
            $id = mysqli_real_escape_string($this->conn, $id);
            $sql = "SELECT file_main, title, description_p, file_info, id FROM photos WHERE id = $id";

            $results = $this->conn->query($sql);

            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            $results->free();
            $this->disconnect();
            return $data;
        } catch (mysqli_sql_exception $ex) {
            $this->disconnect();
            echo 'mysql error' . $ex->getMessage();
        } catch (Exception $ex) {
            $this->disconnect();
            echo 'General exception raised' . $ex->getMessage();
        }
    }

    protected function addPost($data)
    {
        $this->connect();

        $title = mysqli_real_escape_string($this->conn, $data['title']);
        $description = mysqli_real_escape_string(
            $this->conn,
            $data['description']
        );
        $filename = mysqli_real_escape_string($this->conn, $data['filename']);
        $height = mysqli_real_escape_string($this->conn, $data['height']);
        $width = mysqli_real_escape_string($this->conn, $data['width']);
        $imgmain = mysqli_real_escape_string($this->conn, $data['file_main']);
        $imgthumb = mysqli_real_escape_string($this->conn, $data['file_thumb']);
        try {
            $sql = "INSERT INTO photos (file_info, file_main, file_thumb, title, description_p, width, height ) 
            VALUES('$filename', '$imgmain', '$imgthumb', '$title', '$description',  '$height',  '$width')";
            $insert = $this->conn->query($sql);
            $this->disconnect();
            header('Location: /');
        } catch (mysqli_sql_exception $ex) {
            echo 'mysql error' . $ex->getMessage();
        } catch (Exception $ex) {
            echo 'General exception raised' . $ex->getMessage();
        }
    }

    protected function getAllPhotos()
    {
        $this->connect();
        try {
            $sql = "SELECT id, title, description_p, file_thumb
            FROM photos
            ORDER BY id DESC";
            $data;
            $results = $this->conn->query($sql);
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            $results->free();
            $this->disconnect();
            return $data;
        } catch (mysqli_sql_exception $ex) {
            $this->disconnect();
            echo 'mysql error' . $ex->getMessage();
        } catch (Exception $ex) {
            $this->disconnect();
            echo 'General exception raised' . $ex->getMessage();
        }
    }

    protected function getPhotoJson($id)
    {
        $data = [];

        $this->connect();
        // escape mysqli string

        $id = mysqli_real_escape_string($this->conn, $id);
        try {
            $sql = "SELECT file_info, title, description_p, height, width 
            FROM photos 
            WHERE id = $id";
            $results = $this->conn->query($sql);
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            $results->free();
            $this->disconnect();
            return $data;
        } catch (mysqli_sql_exception $ex) {
            $this->disconnect();
            echo 'mysql error' . $ex->getMessage();
        } catch (Exception $ex) {
            $this->disconnect();
            echo 'General exception raised' . $ex->getMessage();
        }
    }
    protected function checkFileName($file)
    {
        $data = [];

        $this->connect();
        // escape mysqli string
        $file = mysqli_real_escape_string($this->conn, $file);

        try {
            $sql = "SELECT file_info as fileI
            FROM photos 
            WHERE file_info = '$file'";
            $results = $this->conn->query($sql);

            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            $results->free();
            $this->disconnect();
            return $data;
        } catch (mysqli_sql_exception $ex) {
            $this->disconnect();
            echo 'mysql error' . $ex->getMessage();
        } catch (Exception $ex) {
            $this->disconnect();
            echo 'General exception raised' . $ex->getMessage();
        }
    }
}

?>
