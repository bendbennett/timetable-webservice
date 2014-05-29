<?php

    /**
     * @group Controllers
     * @group StudentsControllerIntegration
     * @group Integration
     */

class StudentsIntegrationTest extends AbstractControllerTestCase
{

    public function setUp()
    {
        parent::setUp();

        $front = Zend_Controller_Front::getInstance();
        $front->unregisterPlugin('Plugin_AuthPlugin');

        $this->request->setHeader('Content-Type', 'application/xml');
    }

    public function testCorrectDispatchForStudentsModuleTableAssignmentController()
    {
        $this->dispatch('/'.YEAR.'/students/module-table-assignment/AB1234');
        $this->assertRoute('students_module-table-assignment', $message = 'students_module-table-assignment');
        $this->assertController('students');
        $this->assertAction('moduletableassignment');
    }

}