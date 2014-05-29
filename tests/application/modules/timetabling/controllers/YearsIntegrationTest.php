<?php

/**
 * @group Controllers
 * @group YearsControllerIntegration
 * @group Integration
 */

class YearsIntegrationTest extends AbstractControllerTestCase
{

	public function setUp()
	{
		parent::setUp();

		$front = Zend_Controller_Front::getInstance();
		$front->unregisterPlugin('Plugin_AuthPlugin');

		$this->request->setHeader('Content-Type', 'application/xml');
	}

	public function testCorrectDispatchForYearsIndexController()
	{
		$this->dispatch('/years');
		$this->assertRoute('years', $message = 'years');
		$this->assertController('years');
		$this->assertAction('index');
	}

}