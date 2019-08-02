<?php
/*This class assigns public variables to values passed in from a 'data
array. This is class in then instantitated and saved as JSON in the control view 
method json() */ 

class Jsondata 
{
  public $filename;
  public $title;
  public $description;  
  public $height;
  public $width;
  
  /** 
  * @param Array $data
  * The constructor function sets public variables which is used to create a JSON object
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