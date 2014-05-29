<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/*
	 * includes controller directory to allow usage of abstract Controller class from which other Timetabling controllers inherit.
	 */
	protected function _initAutoload()
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array('namespace' => '', 'basePath'  => APPLICATION_PATH));

		$moduleLoader->addResourceTypes(array(	'datasource' => array('namespace' => 'Datasource', 'path' => 'library/datasources'),
												'plugin' => array('namespace' => 'Plugin', 'path' => 'library/plugins'),
												'controller' => array('namespace' => 'Controller', 'path' => 'modules/timetabling/controllers')));
	}


	protected function _initConfig()
	{
		$config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV);
		Zend_Registry::set('config', $config);

        //mssql config to avoid text truncation in student data
        ini_set("mssql.textlimit" , "2147483647");
        ini_set("mssql.textsize" , "2147483647");
	}


	protected function _initRoutes()
	{
		Zend_Controller_Front::getInstance()->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini'), 'route');
	}


	protected function _initHelperPath()
	{
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/modules/timetabling/controllers/helpers', 'Helper_');
	}

	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Plugin_AuthPlugin());
        $front->registerPlugin(new Plugin_RouterPlugin(APPLICATION_ENV));
	}

}

