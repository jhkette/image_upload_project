<?php
try {
    // init bootstrapping phase
    $config_file_path = "./includes/config.php";
    if (!file_exists($config_file_path))
    {
      throw new Exception("Configuration file not found.");
    }
    // continue execution of the bootstrapping phase
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

require  $config_file_path;
require './includes/cookie.php';

try {
    // if the config array is empty or it doesn't exist - the programme cannot run - so I am throwing an exception. 
    if (empty($config) || (!$config))
    {
      throw new Exception("Config variables not found");
    }
    // continue execution of the bootstrapping phase
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

// autoload classes
function autoloader($class)
{
    require_once './classes/' . $class . '.php';
}
// call autoloader function
spl_autoload_register('autoloader');
