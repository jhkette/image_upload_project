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




/* DB variables */
/* DB variables */
// $config['DB_HOST'] = 'mysqlsrv.dcs.bbk.ac.uk';
// $config['DB_NAME'] = 'jkette01db';
// $config['DB_USER'] = 'jkette01';
// $config['DB_PASS'] = 'bbkmysql';


$config['DB_HOST'] = 'localhost';
$config['DB_USER'] = 'root';
$config['DB_PASS'] = 'Gue55wh0';
$config['DB_NAME'] = 'fmaproject';



/* Set the default timezone ;*/
date_default_timezone_set('Europe/London');

?>
