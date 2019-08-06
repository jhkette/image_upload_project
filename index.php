 <?php require_once './bootstrap.php';

/*  Joseph Ketterer
Building Web Applications using MySQL and PHP 
*/

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
     $id = 'home'; // if no get value display home page
 } 
 if (isset($_GET['page'])) {
     $id = $_GET['page']; // id = page if  GET value == 'page'. This is then used to control nav
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
