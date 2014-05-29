<?php

/**
 * @group Controllers
 * @group YearsControllerUnit
 * @group Unit
 */

class YearsUnitTest extends AbstractControllerTestCase
{

	public function setUp()
	{
		parent::setUp();
	}

	public function testInstanceVariablesAreNotNullAndOfExpectedType()
	{
		$yearsController = new YearsController($this->request, $this->response);
		// the config member is an instance of the Zend_config_Ini object
		$this->assertNotNull($yearsController->config);
		$this->assertInstanceOf('Zend_Config_Ini', $yearsController->config);

		$this->assertNotNull($yearsController->params);
		$this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $yearsController->params);
		$this->assertInstanceOf('Helper_ActionHelper', $yearsController->params);

		$this->assertNotNull($yearsController->years);
		$this->assertNotNull($yearsController->datasource);
		$this->assertInstanceOf('Datasource_RetrieveData', $yearsController->datasource);
	}

	public function testYearsIndexIsCalledAsExpected()
	{
		$mockedParams = $this->getMock('Helper_ActionHelper');
		$mockedParams->expects($this->once())->method('switchContext');
		$mockedParams->expects($this->once())->method('prepareData');

		//look at the method signature of getMock to see how calling constructor can be avoided
		//http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
		$mockedYears = $this->getMock('Timetabling_Model_Years', array('getYears','getYearsBySchool'), array(), '', false);
		$mockedYears->expects($this->once())->method('getYears');

		$yearsController = new YearsController($this->request, $this->response);
		$yearsController->init();
		$yearsController->params = $mockedParams;
		$yearsController->years = $mockedYears;

		$yearsController->indexAction();
	}

}
