<?php

/**
 * @group Controllers
 * @group ModulesControllerIntegration
 * @group Integration
 */

class ModulesIntegrationTest extends AbstractControllerTestCase
{

	public function setUp()
	{
		parent::setUp();

		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin('Plugin_AuthPlugin');

		$this->request->setHeader('Content-Type', 'application/xml');
	}

	public function testCorrectDispatchForModulesIndexController()
	{
		$this->dispatch('/'.YEAR.'/modules');
		$this->assertRoute('modules', $message = 'modules');
		$this->assertController('modules');
		$this->assertAction('index');
	}

	public function testCorrectDispatchForModulesSchoolController()
	{
		$this->dispatch('/'.YEAR.'/modules/school/GUID0120202XKXLXKXK');
		$this->assertRoute('modules_school', $message = 'modules_school');
		$this->assertController('modules');
		$this->assertAction('school');
	}
	
	public function testCorrectDispatchForModulesStaffSchoolController()
	{
		$this->dispatch('/'.YEAR.'/modules/school-staff/GUID0120202XKXLXKXK');
		$this->assertRoute('modules_school-staff', $message = 'modules_school-staff');
		$this->assertController('modules');
		$this->assertAction('schoolstaff');
	}
	
	public function testCorrectDispatchForModulesCoursesController()
	{
		$this->dispatch('/'.YEAR.'/modules/course/GUID0120202XKXLXKXK');
		$this->assertRoute('modules_course', $message = 'modules_course');
		$this->assertController('modules');
		$this->assertAction('course');
	}
	
	public function testCorrectDispatchForModulesStudentsController()
	{
        Zend_Controller_Front::getInstance()->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes_devOnly.ini'), 'route');

		$this->dispatch('/'.YEAR.'/modules/students/GUID0120202XKXLXKXK');
		$this->assertRoute('modules_students', $message = 'modules_students');
		$this->assertController('modules');
		$this->assertAction('students');
	}

}