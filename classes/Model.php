<?php
class Model extends Database
{ 
    protected function getIndex(){
        $this->connect();
        $this->disconnect();
    }

}

?>