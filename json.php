<?php

// get data from model using id as a parmater. Use control view to manipulate data then instantiate class and encode  data from a public function. 
//  The code below is just a demo



class JSONtest { public $name;
public $age;
public function __construct(){
          $this->name = 'Joe';
$this->age = 25; }
}
$object = new JSONtest();
$json = json_encode($object);
echo $json;


$books = array( 1 => 'Harry Potter', 2 => 'Heidi'); $authors = array(1 => 'Joe Bloggs', 2 => 'Mr Anon'); // Send appropriate header
header('Content-type: application/json');
// Generate output based on query string params
if ($_GET['type'] == 'books') { echo json_encode($books);
} elseif ($_GET['type'] == 'authors') { echo json_encode($authors);
}


?>