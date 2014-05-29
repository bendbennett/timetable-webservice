<?php

/**
 * @group Unit
 * @group Models
 * @group ModulesModelUnit
 */

class Timetabling_Model_ModulesUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedRetrieveData;
	private $mockedLogger;
	private $modules;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->modules = new Timetabling_Model_Modules($this->mockedRetrieveData, $this->mockedLogger);
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
	{
		$this->assertInstanceOf('Datasource_RetrieveData', $this->modules->retrieveData);
	}

	public function testGetModulesCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->modules->getModules(2011);
	}

	public function testgetModulesBySchoolCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->modules->getModulesBySchool(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetModulesContributedToBySchoolStaffCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->modules->getModulesContributedToBySchoolStaff(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetModulesByCourseCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->modules->getModulesByCourse(2011,'97B5F9CA044211C5A1339ACC29A390CC');
	}

	public function testgetModulesStudentsCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->modules->getModulesStudents(2011,'97B5F9CA044211C5A1339ACC29A390CC');
	}	
}

?>

