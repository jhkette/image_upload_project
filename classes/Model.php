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


    public function addPost($data){
        $this->connect();
        $this->db->query('INSERT INTO photos (id, title, description_p, width, height ) VALUES(:title, :user_id, :body)');
        // Bind values
       

        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
        
    }

}

?>
