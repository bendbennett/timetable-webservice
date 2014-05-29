<?php

/**
 * @group Unit
 * @group Models
 * @group YearsModelUnit
 */

class Timetabling_Model_YearsUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedRetrieveData;
	private $mockedLogger;
	private $years;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->years = new Timetabling_Model_Years($this->mockedRetrieveData, $this->mockedLogger);

		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
	{
		$this->assertInstanceOf('Datasource_RetrieveData', $this->years->retrieveData);
	}

	public function testGetYearsCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->years->getYears(2011);
	}

}

?>
