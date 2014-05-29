<?php

/**
 * @group Unit
 * @group Models
 * @group SchoolsModel
 */

class Timetabling_Model_SchoolsUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedRetrieveData;
	private $mockedLogger;
	private $school;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->school = new Timetabling_Model_Schools($this->mockedRetrieveData, $this->mockedLogger);
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
	{
		$this->assertInstanceOf('Datasource_RetrieveData', $this->school->retrieveData);
		$this->assertInstanceOf('Resource_Logger', $this->school->logger);
	}

	public function testGetSchoolsCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->school->getSchools(2011);
	}

}

?>