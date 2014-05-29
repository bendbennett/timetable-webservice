<?php

/**
 * @group Controllers
 * @group SchoolsControllerUnit
 * @group Unit
 */

class SchoolsUnitTest extends AbstractControllerTestCase
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

		$schoolsController = new SchoolsController($this->request, $this->response);
		// the config member is an instance of the Zend_config_Ini object
		$this->assertNotNull($schoolsController->config);
		$this->assertInstanceOf('Zend_Config_Ini', $schoolsController->config);

		$this->assertNotNull($schoolsController->params);
		$this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $schoolsController->params);
		$this->assertInstanceOf('Helper_ActionHelper', $schoolsController->params);

		$this->assertNotNull($schoolsController->year);
		$this->assertInternalType('string', $schoolsController->year);

		$this->assertNotNull($schoolsController->schools);
		$this->assertNotNull($schoolsController->datasource);
		$this->assertInstanceOf('Datasource_RetrieveData', $schoolsController->datasource);
	}


	public function testInstanceObjectsAreCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		//look at the method signature of getMock to see how calling constructor can be avoided
		//http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
		$mockedSchools = $this->getMock('Timetabling_Model_Schools', array(), array(), '', false);
		$mockedSchools->expects($this->once())->method('getSchools');

		$this->getRequest()->setParam('year', '2010');

		$schoolsController = new SchoolsController($this->request, $this->response);
		$schoolsController->params = $mockedParams;
		$schoolsController->schools = $mockedSchools;

		$schoolsController->indexAction();
	}

}
