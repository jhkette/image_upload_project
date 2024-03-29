<?php
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
define('URLROOT', 'http://localhost:3000');

// Set mysqli reporting for try 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/**
 * Absolute path to application root directory (one level above current dir)
 * Tip: using dynamically generated absolute paths makes the app more portable.
 */
$config['app_dir'] = dirname(dirname(__FILE__));
 
/**
 * Absolute path to directories where uploaded files will be stored
 */
$config['upload_dir'] = $config['app_dir'] . '/images/uploads/';
$config['thumbs'] = $config['app_dir'] . '/images/thumbs/';
$config['main'] = $config['app_dir'] . '/images/main/';


$config['DB_HOST'] = 
$config['DB_NAME'] = 
$config['DB_USER'] = 
$config['DB_PASS'] = 








/* Set the default timezone ;*/
date_default_timezone_set('Europe/London');

?>
