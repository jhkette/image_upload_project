<?php
class Model extends Database
{
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

            header('Location: /');
        } catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
        } catch (Exception $ex) {
            echo  $this->phrases['general-exception'] . $ex->getMessage();
        } finally {
            $stmt->close();
            $this->disconnect();
        }
    }

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
