<?php

class Controlview extends Model
{
    // Function to get index page information
    protected function getIndex()
    {

    }


    protected function getForm()
    { 
        $headerhtml = './templates/header.html';
        $header = file_get_contents($headerhtml);

    }
   
}
?>
