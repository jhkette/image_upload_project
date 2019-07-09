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
        $formfile = './templates/form.html';
        $form = file_get_contents($formfile);
        $content .=  $form;
        $footerfile = './templates/footer.html';
        $footer = file_get_contents($footerfile);
        $content .= $footer;

        return $content;


    }


    public function printForm ()
    {
        echo $this -> getForm();
    }
   
}
?>
