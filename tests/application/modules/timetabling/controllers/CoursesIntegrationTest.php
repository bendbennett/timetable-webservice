<?php

/**
 * @group Controllers
 * @group CoursesControllerIntegration
 * @group Integration
 */

class CoursesIntegrationTest extends AbstractControllerTestCase
{
	
	public function setUp()
	{
		parent::setUp();
		
		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin('Plugin_AuthPlugin');

		$this->request->setHeader('Content-Type', 'application/xml');
	}
	
	public function testCorrectDispatchForCoursesIndexController()
	{
		$this->dispatch('/'.YEAR.'/courses');
		$this->assertRoute('courses', $message = 'courses');
		$this->assertController('courses');
		$this->assertAction('index');
	}

	public function testCorrectDispatchForCoursesSchoolController()
	{
		$this->dispatch('/'.YEAR.'/courses/school/GUID0120202XKXLXKXK');
		$this->assertRoute('courses_school', $message = 'courses_school');
		$this->assertController('courses');
		$this->assertAction('school');
	}
	
	public function testCorrectDispatchForCoursesStaffSchoolController()
	{
		$this->dispatch('/'.YEAR.'/courses/school-staff/GUID0120202XKXLXKXK');
		$this->assertRoute('courses_school-staff', $message = 'courses_school-staff');
		$this->assertController('courses');
		$this->assertAction('schoolstaff');
	}
	
	public function testCorrectDispatchForCoursesStudentsController()
	{
        Zend_Controller_Front::getInstance()->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes_devOnly.ini'), 'route');

		$this->dispatch('/'.YEAR.'/courses/students/GUID0120202XKXLXKXK');
		$this->assertRoute('courses_students', $message = 'courses_students');
		$this->assertController('courses');
		$this->assertAction('students');
	}
	
}