<?php
ini_set('mssql.charset', 'UTF-8');

date_default_timezone_set('Europe/London');

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', '../application');

// Define application environment
// Note/this is being read from httpd.conf
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array('../ZendFramework/library/', get_include_path(),)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap()->run();
