<?php
//Set constants
define ('DS', DIRECTORY_SEPARATOR); // Separator for file paths
$sitePath = realpath(dirname(__FILE__) . DS) . DS;
define ('SITE_PATH', $sitePath); // Path to the root folder of the site

// To connect to the database
define('DB_USER', 'admin');
define('DB_PASS', 'password');
define('DB_HOST', 'localhost');
define('DB_NAME', 'employee');