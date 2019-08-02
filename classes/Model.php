<?php
/* This class that contains methods that either insert or returns data from
the database. These methods get used in the control view class to add relevant data to each view */

class Model extends Database
{   
    /** 
    * @param Int $id - id of photo
    * @return array $data - array of data about photo
    * This function gets the data associated with a particular image. The id is used as a paramater
    * to locate the entry in the database
    */
    
    protected function getImageData($id)
    {
        $data = [];
        $this->connect();
        try {
            $stmt = $this->conn->prepare(
                "SELECT file_main, title, description_p, file_info, id FROM photos WHERE id = ?"
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $results = $stmt->get_result();
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
        } catch (Exception $ex) {
            echo 'General exception raised' . $ex->getMessage();
        } finally {
            $stmt->close(); // frees up memory relating to prepared statement and results
            $this->disconnect();
        }
    }

    /** 
    * This function adds data to create an entry for a photo in a database.
    * @param array $data - an array of data with relevant info about photo
    */

    protected function addPost($data)
    {
        // https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php
        $this->connect();

        $title = $data['title'];
        $description = $data['description'];

        $filename = $data['filename'];
        $height = $data['height'];
        $width = $data['width'];
        $imgmain = $data['file_main'];
        $imgthumb = $data['file_thumb'];
        try {
            $stmt = $this->conn->prepare("INSERT INTO 
            photos (file_info, file_main, file_thumb, title, description_p, width, height ) 
            VALUES(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                'sssssii',
                $filename,
                $imgmain,
                $imgthumb,
                $title,
                $description,
                $width,
                $height
            );
            $stmt->execute();

            header('Location: index.php');
        } catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
        } catch (Exception $ex) {
            echo  $this->phrases['general-exception'] . $ex->getMessage();
        } finally {
            $stmt->close();
            $this->disconnect();
        }
    }

    /** 
    * This function gets relevant data associated with all images in the collection
    * and returns an associative array
    * @return array $data - array of data about all photos in collection
    */

    protected function getAllPhotos()
    {
        $this->connect();
        try {
            $sql = "SELECT id, title, description_p, file_thumb
            FROM photos
            ORDER BY id DESC";
            $data = [];
            $results = $this->conn->query($sql);
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
        } catch (Exception $ex) {
            echo $this->phrases['general-exception'] . $ex->getMessage();
        } finally {
            $results->free();
            $this->disconnect();
        }
    }
    
    /** 
    * This function gets the data associated with a particular image and is subsequently used
    * to create a json object.
    * @param int $id - id of photo
    * @return array $data - array of data about photo
    */

    protected function getPhotoJson($id)
    {
        $data = [];
        $this->connect();
        try {
            $stmt = $this->conn->prepare("SELECT file_info, title, description_p, height, width 
            FROM photos 
            WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $results = $stmt->get_result();
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
        } catch (Exception $ex) {
            echo $this->phrases['general-exception'] . $ex->getMessage();
        } finally {
            $stmt->close(); // frees up memory relating to prepared statement and results
            $this->disconnect();
        }
    }
    /** 
    * This method is used to check the file name - to see the file provided
    * as a parameter exists in the database 
    * @param string $file - filename of photo
    * @return array $data - associateive array containing filename
    */
    protected function checkFileName($file)
    {
        $data = [];
        $this->connect();
        try {
            $stmt = $this->conn->prepare("SELECT file_info as fileI
            FROM photos 
            WHERE file_info = ?");
            $stmt->bind_param('s', $file);
            $stmt->execute();
            $results = $stmt->get_result();
            while ($row = $results->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } 
        catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
        } 
        catch (Exception $ex) {
            echo $this->phrases['general-exception'] . $ex->getMessage();
        } 
        finally {
            $stmt->close();
            $this->disconnect();
        }
    }
}

?>
