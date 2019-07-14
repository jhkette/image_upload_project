 <?php
 require_once './bootstrap.php';

 if (!isset($_GET['page']) && !isset($_GET['image']) && !isset($_GET['json'])) {
     $id = 'home'; // display home page
 } 
 if (isset($_GET['page']) && !isset($_GET['image']) && !isset($_GET['json'])) {
     $id = $_GET['page']; // else requested page
 }

//  if (isset(!$_GET['page']) && !isset($_GET['image']) && isset($_GET['json'])) {
//     $id = $_GET['']; // else requested page
// }

 if (isset($_GET['page'])) {
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

 if (isset($_GET['json'])) {
    include 'views/json.php';
}
 ?> 
