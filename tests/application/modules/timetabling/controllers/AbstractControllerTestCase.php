<?php

abstract class AbstractControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
	public function setUp()
	{
		$this->bootstrap = new Zend_Application('production', APPLICATION_PATH . '/configs/application.ini');
		parent::setUp();

		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	// overload this method to allow any errors in the frontController to be displayed during testing
	public function dispatch($url = null)
	{
		// redirector should not exit
		$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
		$redirector->setExit(false);

		// json helper should not exit
		$json = Zend_Controller_Action_HelperBroker::getStaticHelper('json');
		$json->suppressExit = true;

		$request = $this->getRequest();

		if (null !== $url)
		{
			$request->setRequestUri($url);
		}

		$request->setPathInfo(null);

		$this->getFrontController()
		->setRequest($request)
		->setResponse($this->getResponse())
		->throwExceptions(true)
		->returnResponse(false);

		$this->getFrontController()->dispatch();
	}

}