<?php

/**
 * @group Controllers
 * @group StaffControllerIntegration
 * @group Integration
 */

class StaffIntegrationTest extends AbstractControllerTestCase
{

	public function setUp()
	{
		parent::setUp();

		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin('Plugin_AuthPlugin');

		$this->request->setHeader('Content-Type', 'application/xml');
	}

	public function testCorrectDispathForStaffControllerIndexAction()
	{
		$this->dispatch('/'.YEAR.'/staff');
		$this->assertRoute('staff', $message = 'staff');
		$this->assertController('staff');
		$this->assertAction('index');
	}

	public function testCorrectDispathForStaffControllerSchoolAction()
	{
		$this->dispatch('/'.YEAR.'/staff/school/GUID0120202XKXLXKXK');
		$this->assertRoute('staff-school', $message = 'staff-school');
		$this->assertController('staff');
		$this->assertAction('school');
	}

	public function testCorrectDispathForStaffSControllerExchangeAction()
	{
		$_SERVER = array('SERVER_NAME' => 'nameOfServer', 'REQUEST_URI' => 'request/containing/year/', );
		
		$this->dispatch('/'.YEAR.'/staff/exchange');
		$this->assertRoute('staff-exchange', $message = 'staff-exchange');
		$this->assertController('staff');
		$this->assertAction('exchange');
	}

}
