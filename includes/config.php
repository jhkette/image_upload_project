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




/* DB variables */
$config['DB_HOST'] = 'mysqlsrv.dcs.bbk.ac.uk';
$config['DB_NAME'] = 'jkette01db';
$config['DB_USER'] = 'jkette01';
$config['DB_PASS'] = 'bbkmysql';

/* Set the default timezone ;*/
date_default_timezone_set('Europe/London');

?>
