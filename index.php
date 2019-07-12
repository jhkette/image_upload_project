 <?php
 require_once './bootstrap.php';

 if (!isset($_GET['page']) &&(!isset($_GET['image']))) {
     $id = 'home'; // display home page
 } elseif(isset($_GET['page']) &&(!isset($_GET['image']))) {
     $id = $_GET['page']; // else requested page
 }
if(!isset($_GET['image'])){
 switch ($id) {
     case 'home':
         include 'views/home.php';
         break;
     case 'upload':
         include 'views/single.php';
         break;
     case 'test':
         include 'views/test.php';
         break;
     default:
         include 'views/404.php';
 }

}


 if (isset($_GET['image'])) {

    $photo = $_GET['image']; // else requested page
    
    include 'views/image.php';
  
    
}


 ?> 
