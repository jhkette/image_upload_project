 <?php
 require_once './bootstrap.php';

 if (!isset($_GET['page']) && !isset($_GET['image'])) {
     $id = 'home'; // display home page
 } 
 if (isset($_GET['page']) && !isset($_GET['image'])) {
     $id = $_GET['page']; // else requested page
 }

 if (!isset($_GET['image'])) {
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
     include 'views/image.php';
 }
 ?> 
