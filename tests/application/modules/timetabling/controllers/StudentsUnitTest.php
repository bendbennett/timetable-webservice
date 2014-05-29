<?php

/**
 * @group Controllers
 * @group StudentsControllerUnit
 * @group Unit
 */

class StudentsUnitTest extends AbstractControllerTestCase
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

        $studentsController = new StudentsController($this->request, $this->response);
        // the config member is an instance of the Zend_config_Ini object
        $this->assertNotNull($studentsController->config);
        $this->assertInstanceOf('Zend_Config_Ini', $studentsController->config);

        $this->assertNotNull($studentsController->params);
        $this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $studentsController->params);
        $this->assertInstanceOf('Helper_ActionHelper', $studentsController->params);

        $this->assertNotNull($studentsController->year);
        $this->assertInternalType('string', $studentsController->year);

        $this->assertNotNull($studentsController->students);
        $this->assertNotNull($studentsController->studentsTwo);
        $this->assertNotNull($studentsController->biomedsciDatasource);
        $this->assertInstanceOf('Datasource_Biomedsci', $studentsController->biomedsciDatasource);
        $this->assertNotNull($studentsController->saturnDatasource);
        $this->assertInstanceOf('Datasource_Saturn', $studentsController->saturnDatasource);
        $this->assertNotNull($studentsController->studentsProcessor);
        $this->assertInstanceOf('Timetabling_Model_StudentsProcessor', $studentsController->studentsProcessor);
    }

    public function testStudentsModuleTableAssignmentIsCalledAsExpected()
    {
        $mockedParams = $this->getMock('Helper_ActionHelper');
        $mockedParams->expects($this->once())->method('switchContext');
        $mockedParams->expects($this->once())->method('prepareData');

        $mockedStudentsProcessor = $this->getMock('Timetabling_Model_StudentsProcessor', array('getStudentIdNameUsernameAndTableAssignmentForModule'), array(), '', false);
        $mockedStudentsProcessor->expects($this->once())
            ->method('getStudentIdNameUsernameAndTableAssignmentForModule')
            ->will($this->returnValue('<Student></Student>'));

        $this->getRequest()->setParam('year', '2010');

        $studentsController = new StudentsController($this->request, $this->response);
        $studentsController->params = $mockedParams;

        $studentsController->studentsProcessor = $mockedStudentsProcessor;

        $studentsController->moduletableassignmentAction();
    }
}
