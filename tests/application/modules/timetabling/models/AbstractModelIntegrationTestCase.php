<?php

abstract class AbstractModelIntegrationTestCase extends PHPUnit_Framework_TestCase
{
	protected $config;
	protected $logger;
	protected $retrieveData;

	public function setUp()
	{
		$this->config = Zend_Registry::get('config');
		$this->logger = Zend_Registry::get('logger');
		$this->retrieveData = new Datasource_Timetabling($this->config, $this->logger);
	}
	
	public static function setUpBeforeClass()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public static function tearDownAfterClass()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}
	
}