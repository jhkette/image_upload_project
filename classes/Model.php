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
}

?>
