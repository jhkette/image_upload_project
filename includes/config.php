<?php
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
define('URLROOT', 'http://localhost:3000');
/**
 * Building Web Applications using MySQL and PHP (W1)
 *
 * HOE - Uploading Files: configuration settings
 *
 */

/**
 * Absolute path to application root directory (one level above current dir)
 * Tip: using dynamically generated absolute paths makes the app more portable.
 */
$config['app_dir'] = dirname(dirname(__FILE__));
 
/**
 * Absolute path to directory where uploaded files will be stored
 * Using an absolute path to the upload dir can help circumvent security restrictions on some servers
 */
$config['upload_dir'] = $config['app_dir'] . '/uploads/';
$config['thumbs'] = $config['app_dir'] . '/thumbs/';
$config['main'] = $config['app_dir'] . '/main/';




/* DB variables */
$config['DB_HOST'] = 'localhost';
$config['DB_USER'] = 'root';
$config['DB_PASS'] = 'Gue55wh0';
$config['DB_NAME'] = 'fmaproject';


/* Set the default timezone ;*/
date_default_timezone_set('Europe/London');

?>
