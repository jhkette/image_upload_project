 <?php require_once './bootstrap.php';


if(isset($_POST['submit'])) {
    if(isset($_POST['language'])) {
        $language = htmlentities(trim($_POST['language']));
        if(( $language == 'fr')||($language == 'en')){
            $cookie_name = "language";
            $cookie_value = $language;
            setcookie($cookie_name,  $language, time() + 3600, '/');
            header("Refresh:0");
        }
    }
}






 if (!isset($_GET['page']) && !isset($_GET['image']) && !isset($_GET['json'])) {
     $id = 'home'; // display home page
 } 
 if (isset($_GET['page']) && !isset($_GET['image']) && !isset($_GET['json'])) {
     $id = $_GET['page']; // else requested page
 }


if ((!isset($_GET['image'])) && (!isset($_GET['json'])))  {
     switch ($id) {
         case 'home':
             include 'views/home.php';
             break;
         case 'upload':
             include 'views/upload.php';
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
