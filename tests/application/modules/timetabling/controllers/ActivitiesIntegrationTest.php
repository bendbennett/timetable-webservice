<?php

/**
 * @group Controllers
 * @group ActivitiesControllerIntegration
 * @group Integration
 */

class ActivitiesIntegrationTest extends AbstractControllerTestCase
{
	public function setUp()
	{
		parent::setUp();

		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin('Plugin_AuthPlugin');

		$this->request->setHeader('Content-Type', 'application/xml');
	}

	public function testCorrectDispatchForActivitiesCourseController()
	{
		$this->dispatch('/'.YEAR.'/activities/course/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_course', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('course');
	}

	public function testCorrectDispatchForActivitiesModuleController()
	{
		$this->dispatch('/'.YEAR.'/activities/module/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_module', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('module');
	}

	public function testCorrectDispatchForActivitiesStaffController()
	{
		$this->dispatch('/'.YEAR.'/activities/staff/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_staff', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('staff');
	}

	public function testCorrectDispatchForActivitiesSchoolController()
	{
		$this->dispatch('/'.YEAR.'/activities/school-modules/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_school', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('schoolmodules');
	}

	public function testCorrectDispatchForActivitiesStaffSchoolController()
	{
		$this->dispatch('/'.YEAR.'/activities/school-staff/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_school-staff', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('schoolstaff');
	}

	public function testCorrectDispatchForActivitiesStaffExchangeController()
	{
		$this->dispatch('/'.YEAR.'/activities/staff-exchange/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_staff-exchange', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('staffexchange');
	}

	public function testCorrectDispatchForActivitiesStudentController()
	{
        Zend_Controller_Front::getInstance()->getRouter()->addConfig(new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes_devOnly.ini'), 'route');

		$this->dispatch('/'.YEAR.'/activities/student/GUID0120202XKXLXKXK');
		$this->assertRoute('activities_student', $message = 'the route was followed');
		$this->assertController('activities');
		$this->assertAction('student');
	}
}

