<?php

/**
 * @group Controllers
 * @group StaffControllerUnit
 * @group Unit
 */

class StaffUnitTest extends AbstractControllerTestCase
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
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$staffController = new StaffController($this->request, $this->response);
		// the config member is an instance of the Zend_config_Ini object
		$this->assertNotNull($staffController->config);
		$this->assertInstanceOf('Zend_Config_Ini', $staffController->config);

		$this->assertNotNull($staffController->params);
		$this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $staffController->params);
		$this->assertInstanceOf('Helper_ActionHelper', $staffController->params);

		$this->assertNotNull($staffController->year);
		$this->assertInternalType('string', $staffController->year);

		$this->assertNotNull($staffController->staff);
		$this->assertNotNull($staffController->datasource);
		$this->assertInstanceOf('Datasource_RetrieveData', $staffController->datasource);
	}

	public function testStaffIndexIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		//look at the method signature of getMock to see how calling constructor can be avoided
		//http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
		$mockedStaff = $this->getMock('Timetabling_Model_Staff', array('getStaff','getStaffBySchool'), array(), '', false);
		$mockedStaff->expects($this->once())->method('getStaff');

		$this->getRequest()->setParam('year', '2010');

		$staffController = new StaffController($this->request, $this->response);
		$staffController->params = $mockedParams;
		$staffController->staff = $mockedStaff;

		$staffController->indexAction();
	}

	public function testStaffSchoolIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedStaff = $this->getMock('Timetabling_Model_Staff', array('getStaffBySchool'), array(), '', false);
		$mockedStaff->expects($this->once())->method('getStaffBySchool');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$staffController = new StaffController($this->request, $this->response);
		$staffController->params = $mockedParams;
		$staffController->staff = $mockedStaff;

		$staffController->schoolAction();
	}

	public function testStaffExchangeIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedStaff = $this->getMock('Timetabling_Model_Staff', array('getStaffForExchange'), array(), '', false);
		$mockedStaff->expects($this->once())->method('getStaffForExchange');
		$this->getRequest()->setParam('year', '2011');

		$staffController = new StaffController($this->request, $this->response);
		$staffController->params = $mockedParams;
		$staffController->staff = $mockedStaff;

		$staffController->exchangeAction();
	}
}