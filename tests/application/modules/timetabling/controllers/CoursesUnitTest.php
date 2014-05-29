<?php

/**
 * @group Controllers
 * @group CoursesControllerUnit
 * @group Unit
 */

class CoursesUnitTest extends AbstractControllerTestCase
{

	public function setUp()
	{
		parent::setUp();
	}

	public function testInstanceVariablesAreNotNullAndOfExpectedType()
	{
		//$this->year = $this->getRequest()->getParam('year') is used in actual SchoolsController
		//so have to populate this as there is no request object under test conditions
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', '4A62723013D6636D02C83FB2FAF2BFAC');

		$coursesController = new CoursesController($this->request, $this->response);
		// the config member is an instance of the Zend_config_Ini object
		$this->assertNotNull($coursesController->config);
		$this->assertInstanceOf('Zend_Config_Ini', $coursesController->config);

		$this->assertNotNull($coursesController->params);
		$this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $coursesController->params);
		$this->assertInstanceOf('Helper_ActionHelper', $coursesController->params);

		$this->assertNotNull($coursesController->year);
		$this->assertInternalType('string', $coursesController->year);

		$this->assertNotNull($coursesController->courses);
		$this->assertNotNull($coursesController->datasource);
		$this->assertInstanceOf('Datasource_RetrieveData', $coursesController->datasource);
	}

	public function testCoursesIndexIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		//look at the method signature of getMock to see how calling constructor can be avoided
		//http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
		$mockedCourses = $this->getMock('Timetabling_Model_Courses', array('getCourses','getCoursesBySchool'), array(), '', false);
		$mockedCourses->expects($this->once())->method('getCourses');

		$this->getRequest()->setParam('year', '2010');

		$coursesController = new CoursesController($this->request, $this->response);
		$coursesController->params = $mockedParams;
		$coursesController->courses = $mockedCourses;

		$coursesController->indexAction();

	}

	public function testCoursesSchoolIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedCourses = $this->getMock('Timetabling_Model_Courses', array('getCoursesBySchool'), array(), '', false);
		$mockedCourses->expects($this->once())->method('getCoursesBySchool');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$coursesController = new CoursesController($this->request, $this->response);
		$coursesController->params = $mockedParams;
		$coursesController->courses = $mockedCourses;

		$coursesController->schoolAction();
	}

	public function testCoursesContributedToBySchoolStaffIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedCourses = $this->getMock('Timetabling_Model_Courses', array('getCoursesContributedToBySchoolStaff'), array(), '', false);
		$mockedCourses->expects($this->once())->method('getCoursesContributedToBySchoolStaff');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$coursesController = new CoursesController($this->request, $this->response);
		$coursesController->params = $mockedParams;
		$coursesController->courses = $mockedCourses;

		$coursesController->schoolstaffAction();
	}
	
	public function testCoursesStudentsIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedCourses = $this->getMock('Timetabling_Model_Courses', array('getCoursesStudents'), array(), '', false);
		$mockedCourses->expects($this->once())->method('getCoursesStudents');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$coursesController = new CoursesController($this->request, $this->response);
		$coursesController->params = $mockedParams;
		$coursesController->courses = $mockedCourses;

		$coursesController->studentsAction();
	}
	
}