 <?php
 require_once './bootstrap.php';

 if (!isset($_GET['page'])) {
     $id = 'home'; // display home page
 } else {
     $id = $_GET['page']; // else requested page
 }

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
 ?> 
