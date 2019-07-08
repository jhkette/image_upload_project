<?php 
require_once './includes/config.php';


// autoload classes
function autoloader($class){
    require_once './classes/'.$class.'.php';
}
// call autoloader function
spl_autoload_register('autoloader');

?>