<?php
/**
 * @group Unit
 * @group Models
 * @group ActivitiesModelUnit
 */

class Timetabling_Model_ActivitiesUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedRetrieveData;
	private $mockedLogger;
	private $activities;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->activities = new Timetabling_Model_Activities($this->mockedRetrieveData, $this->mockedLogger);

		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
	{
		$this->assertInstanceOf('Datasource_RetrieveData', $this->activities->retrieveData);
	}

	public function testgetActivitiesByModuleCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesByModule(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetActivitiesByCourseCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesByCourse(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetActivitiesByStaffCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesByStaff(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetActivitiesForModulesAdministeredBySchool()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesForModulesAdministeredBySchool(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetActivitiesContributedToBySchoolStaffCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesContributedToBySchoolStaff(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetActivitiesForStaffExchangeCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesForStaffExchange(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}
	
	public function testgetActivitiesByStudentCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->activities->getActivitiesByStudent(2011,'1234');
	}
	
}

?>