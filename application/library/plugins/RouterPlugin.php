<?php

/**
 *
 * interrogates APPLICATION_ENV to determine config (e.g., development, testing, production) and then adds
 * additional routes for dev-only environment
 */
class Plugin_RouterPlugin extends Zend_Controller_Plugin_Abstract
{
    private $applicationEnv;


    public function __construct($applicationEnv)
    {
        $this->applicationEnv = $applicationEnv;
    }


    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        if ($this->applicationEnv == "development")
        {
            Zend_Controller_Front::getInstance()->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes_devOnly.ini'), 'route');
        }
    }

}