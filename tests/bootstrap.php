<?php

//prevents issues with "headers already sent" errors
ob_start();
ini_set('mssql.charset', 'UTF-8');
error_reporting( E_ALL | E_STRICT );
date_default_timezone_set('Europe/London');

define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('APPLICATION_PATH',  BASE_PATH.'/application/');
define('TEST_PATH', realpath(dirname(__FILE__).'/application/'));

//defined in phpunit.xml
//define('APPLICATION_ENV',  'development');

set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), '../ZendFramework/library/',
APPLICATION_PATH.'modules/timetabling/controllers',
TEST_PATH.'/modules/timetabling/controllers/',
TEST_PATH.'/modules/timetabling/models/',
TEST_PATH.'/library/datasources/')));


require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->suppressNotFoundWarnings(false);
$loader->setFallbackAutoloader(true);

$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap();

$loaderResource = new Zend_Loader_Autoloader_Resource(array('namespace' => '', 'basePath'  => APPLICATION_PATH));
$loaderResource->addResourceType('helper', 'modules/timetabling/controllers/helpers', 'Helper');

$loaderResource = new Zend_Loader_Autoloader_Resource(array('namespace' => 'Test', 'basePath'  => TEST_PATH));
$loaderResource->addResourceType('resource', 'resources', 'Resource');


