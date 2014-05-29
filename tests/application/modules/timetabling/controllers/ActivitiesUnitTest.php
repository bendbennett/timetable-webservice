<?php

/**
 * @group Controllers
 * @group ActivitiesControllerUnit
 * @group Unit
 */

class ActivitiesUnitTest extends AbstractControllerTestCase
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

		$activitiesController = new ActivitiesController($this->request, $this->response);
		// the config member is an instance of the Zend_config_Ini object
		$this->assertNotNull($activitiesController->config);
		$this->assertInstanceOf('Zend_Config_Ini', $activitiesController->config);

		$this->assertNotNull($activitiesController->params);
		$this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $activitiesController->params);
		$this->assertInstanceOf('Helper_ActionHelper', $activitiesController->params);

		$this->assertNotNull($activitiesController->year);
		$this->assertInternalType('string', $activitiesController->year);

		$this->assertNotNull($activitiesController->activities);
		$this->assertNotNull($activitiesController->datasource);
		$this->assertInstanceOf('Datasource_RetrieveData', $activitiesController->datasource);
	}

	//look at the method signature of getMock to see how calling constructor can be avoided
	//http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock

	public function testActivitiesForModulesAdministeredBySchoolIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedActivities = $this->getMock('Timetabling_Model_Activities', array('getActivitiesForModulesAdministeredBySchool'), array(), '', false);
		$mockedActivities->expects($this->once())->method('getActivitiesForModulesAdministeredBySchool');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$activitiesController = new ActivitiesController($this->request, $this->response);
		$activitiesController->params = $mockedParams;
		$activitiesController->activities = $mockedActivities;

		$activitiesController->schoolmodulesAction();
	}

	public function testActivitiesContributedToBySchoolStaffIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())
		->method('switchContext');
		$mockedParams->expects($this->once())
		->method('prepareData');

		$mockedActivities = $this->getMock('Timetabling_Model_Activities', array('getActivitiesContributedToBySchoolStaff'), array(), '', false);
		$mockedActivities->expects($this->once())
		->method('getActivitiesContributedToBySchoolStaff');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$activitiesController = new ActivitiesController($this->request, $this->response);
		$activitiesController->params = $mockedParams;
		$activitiesController->activities = $mockedActivities;

		$activitiesController->schoolstaffAction();
	}

	public function testActivitiesByCourseIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())
		->method('switchContext');
		$mockedParams->expects($this->once())
		->method('prepareData');

		$mockedActivities = $this->getMock('Timetabling_Model_Activities', array('getActivitiesByCourse'), array(), '', false);
		$mockedActivities->expects($this->once())
		->method('getActivitiesByCourse');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$activitiesController = new ActivitiesController($this->request, $this->response);
		$activitiesController->params = $mockedParams;
		$activitiesController->activities = $mockedActivities;

		$activitiesController->courseAction();
	}

	public function testActivitiesByModuleIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())
		->method('switchContext');
		$mockedParams->expects($this->once())
		->method('prepareData');

		$mockedActivities = $this->getMock('Timetabling_Model_Activities', array('getActivitiesByModule'), array(), '', false);
		$mockedActivities->expects($this->once())
		->method('getActivitiesByModule');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$activitiesController = new ActivitiesController($this->request, $this->response);
		$activitiesController->params = $mockedParams;
		$activitiesController->activities = $mockedActivities;

		$activitiesController->moduleAction();
	}

	public function testActivitiesForStaffExchangeIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())
		->method('switchContext');
		$mockedParams->expects($this->once())
		->method('prepareData');

		$mockedActivities = $this->getMock('Timetabling_Model_Activities', array('getActivitiesForStaffExchange'), array(), '', false);
		$mockedActivities->expects($this->once())
		->method('getActivitiesForStaffExchange');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$activitiesController = new ActivitiesController($this->request, $this->response);
		$activitiesController->params = $mockedParams;
		$activitiesController->activities = $mockedActivities;

		$activitiesController->staffexchangeAction();
	}

	public function testActivitiesByStudentIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())
		->method('switchContext');
		$mockedParams->expects($this->once())
		->method('prepareData');

		$mockedActivities = $this->getMock('Timetabling_Model_Activities', array('getActivitiesByStudent'), array(), '', false);
		$mockedActivities->expects($this->once())
		->method('getActivitiesByStudent');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', '1234');

		$activitiesController = new ActivitiesController($this->request, $this->response);
		$activitiesController->params = $mockedParams;
		$activitiesController->activities = $mockedActivities;

		$activitiesController->studentAction();
	}

}
