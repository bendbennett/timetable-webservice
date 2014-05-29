<?php

/**
 * @group Controllers
 * @group SchoolsControllerIntegration
 * @group Integration
 */

class SchoolsIntegrationTest extends AbstractControllerTestCase
{

	public function setUp()
	{
		parent::setUp();

		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin('Plugin_AuthPlugin');

		$this->request->setHeader('Content-Type', 'application/xml');
	}

	public function testCorrectDispatch()
	{
		$this->dispatch('/'.YEAR.'/schools');
		$this->assertRoute('schools', $message = 'schools');
		$this->assertController('schools');
		$this->assertAction('index');
	}

}
