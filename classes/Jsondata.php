<?php

class Jsondata 
{
  public $height;
  public $width;
  public $filename;
  public $title;
  public $description;
  
  /**
  * @param Array $data
  */

  public function __construct($data){
      $this->height = $data[0]['height'];
      $this->width = $data[0]['width'];
      $this->filename = $data[0]['file_info'];
      $this->title = $data[0]['title'];
      $this->description = $data[0]['description_p'];      
  }


}


?>