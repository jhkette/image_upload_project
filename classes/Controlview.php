<?php

class Controlview 
{
    // Function to get index page information
    protected function getIndex()
    {

    }


    protected function getForm()

    {   
        $content ='';
        $headerhtml = './templates/header.html';
        $header = file_get_contents($headerhtml);
        $content .=  $header;
      

        return $content;


    }


    public function printForm ()
    {
        echo $this -> getForm();
    }
   
}
?>
