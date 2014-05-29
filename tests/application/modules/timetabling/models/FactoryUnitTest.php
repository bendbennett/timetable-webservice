<?php

/**
 * @group Unit
 * @group Models
 * @group FactoryModelUnit
 */

class Timetabling_Model_FactoryUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedFactory;
	private $mockedLogger;
	private $mockedconfig;
	private $config;

	public function testcreateRetrieveDataCreatesADatasource_RetrieveDataObject()
	{
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->mockedconfig = $this->getMock('Config');
		$this->config = Zend_Registry::get('config');
		$class = Timetabling_Model_Factory::createRetrieveData($this->config, $this->mockedLogger);

		$this->assertInstanceOf('Datasource_RetrieveData',$class);
	}


}

?>
