<?php
// Toggle the display of all errors
error_reporting(E_ALL);
// Connect configuration
include('config.php');

// Connect to the database
//$dbObject = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

// Connect the core site
include(SITE_PATH . 'core' . DS . 'core.php');

