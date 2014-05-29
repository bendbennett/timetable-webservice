<?php

/**
 * @group Controllers
 * @group ModulesControllerUnit
 * @group Unit
 */

class ModulesUnitTest extends AbstractControllerTestCase
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

		$modulesController = new ModulesController($this->request, $this->response);
		// the config member is an instance of the Zend_config_Ini object
		$this->assertNotNull($modulesController->config);
		$this->assertInstanceOf('Zend_Config_Ini', $modulesController->config);

		$this->assertNotNull($modulesController->params);
		$this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $modulesController->params);
		$this->assertInstanceOf('Helper_ActionHelper', $modulesController->params);

		$this->assertNotNull($modulesController->year);
		$this->assertInternalType('string', $modulesController->year);

		$this->assertNotNull($modulesController->modules);
		$this->assertNotNull($modulesController->datasource);
		$this->assertInstanceOf('Datasource_RetrieveData', $modulesController->datasource);
	}

	public function testModulesIndexIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		//look at the method signature of getMock to see how calling constructor can be avoided
		//http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
		$mockedModules = $this->getMock('Timetabling_Model_Modules', array('getModules'), array(), '', false);
		$mockedModules->expects($this->once())->method('getModules');

		$this->getRequest()->setParam('year', '2010');

		$modulesController = new ModulesController($this->request, $this->response);
		$modulesController->params = $mockedParams;
		$modulesController->modules = $mockedModules;

		$modulesController->indexAction();
	}

	public function testModulesSchoolIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedModules = $this->getMock('Timetabling_Model_Modules', array('getModulesBySchool'), array(), '', false);
		$mockedModules->expects($this->once())->method('getModulesBySchool');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$modulesController = new ModulesController($this->request, $this->response);
		$modulesController->params = $mockedParams;
		$modulesController->modules = $mockedModules;

		$modulesController->schoolAction();
	}

	public function testModulesContributedToBySchoolStaffIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedModules = $this->getMock('Timetabling_Model_Modules', array('getModulesContributedToBySchoolStaff'), array(), '', false);
		$mockedModules->expects($this->once())->method('getModulesContributedToBySchoolStaff');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$modulesController = new ModulesController($this->request, $this->response);
		$modulesController->params = $mockedParams;
		$modulesController->modules = $mockedModules;

		$modulesController->schoolstaffAction();
	}

	public function testModulesByCourseIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedModules = $this->getMock('Timetabling_Model_Modules', array('getModulesByCourse'), array(), '', false);
		$mockedModules->expects($this->once())->method('getModulesByCourse');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$modulesController = new ModulesController($this->request, $this->response);
		$modulesController->params = $mockedParams;
		$modulesController->modules = $mockedModules;

		$modulesController->courseAction();
	}
	
	public function testModulesStudentsIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		$mockedModules = $this->getMock('Timetabling_Model_Modules', array('getModulesStudents'), array(), '', false);
		$mockedModules->expects($this->once())->method('getModulesStudents');
		$this->getRequest()->setParam('year', '2010');
		$this->getRequest()->setParam('guid', 'FD8DCCC4E0CC813F3522E0C30F3D54C3');

		$modulesController = new ModulesController($this->request, $this->response);
		$modulesController->params = $mockedParams;
		$modulesController->modules = $mockedModules;

		$modulesController->studentsAction();
	}
	
}