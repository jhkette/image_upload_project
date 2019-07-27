 <?php require_once './bootstrap.php';


if(isset($_POST['submit'])) {
    if(isset($_POST['language'])) {
        $language = htmlentities(trim($_POST['language']));
        if(( $language == 'fr')||($language == 'en')){
            $_SESSION['language'] = $language;
            header("Refresh:0");
        }
    }
}

 if (!isset($_GET['page']) && !isset($_GET['image']) && !isset($_GET['json'])) {
     $id = 'home'; // display home page
 } 
 if (isset($_GET['page'])) {
     $id = $_GET['page']; // get page if other get variable are not set
 }


if (isset($id)) { // check id variable which controls main nav isset
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

/* image and json need seperate get variables as they are going to be
associated with an id number - used to fetch relevant data from database */
 if (isset($_GET['image'])) {
     include 'views/image.php';
 }

 if (isset($_GET['json'])) {
    include 'views/json.php';
}


 ?> 
