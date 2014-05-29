<?php

/**
 * @group Unit
 * @group Models
 * @group CoursesModelUnit
 */

class Timetabling_Model_CoursesUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedRetrieveData;
	private $mockedLogger;
	private $courses;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->courses = new Timetabling_Model_Courses($this->mockedRetrieveData, $this->mockedLogger);

		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
	{
		$this->assertInstanceOf('Datasource_RetrieveData', $this->courses->retrieveData);
	}

	public function testGetCoursesCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->courses->getCourses(2011);
	}

	public function testgetCoursesBySchoolCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->courses->getCoursesBySchool(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetCoursesContributedToBySchoolStaffCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->courses->getCoursesContributedToBySchoolStaff(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testgetCoursesStudentsCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->courses->getCoursesStudents(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}
}

?>

