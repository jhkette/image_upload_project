<?php
// checks for cookie - the default language is en. if cookit value is fr language is changed
// to French


if(!isset($_SESSION['language'])) {
    $lang = array(
        "language" => "en"
    );  
} else {
    //   ensure cookie value is the value we have assigned to it - filter data 
    if (($_SESSION['language']== 'fr') ||  ($_SESSION['language'] == 'en')){ 
        $lang = array( 
             "language" => htmlentities($_SESSION['language'])
            );
        }
}
?>