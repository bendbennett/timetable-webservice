<?php

/**
 * @group Unit
 * @group Models
 * @group ModelModel
 */

class Timetabling_Model_ModelUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedLogger;
	private $mockedRetrieveData;
	private $mockedCache;
	private $model;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->mockedCache = $this->getMock('Zend_Cache_Core', array(), array(), '', false);
		Zend_Registry::set('cache', $this->mockedCache);
		$this->model = new ConcreteModel($this->mockedRetrieveData, $this->mockedLogger);
	}

	public function testSetCacheLifetimeCalled_whenSetCacheExpiryTimeInvoked()
	{
		$this->mockedCache->expects($this->once())
		->method('setLifetime');

		$this->model->setCacheExpiryTime();
	}

	public function testSetCacheLifetimeCalledWithSecondsUntilTwoAm__whenSetCacheExpiryTimeInvoked()
	{
		$dayAdvance = 0;

		if (date("G", time()) > 1)
		{
			$dayAdvance = 1;
		}

		$expiryTime = mktime(2, 0, 0, date("m"), (date("d") + $dayAdvance), date("Y"));

		$currentTime = time();
		$numberOfSecondsUntilExpiry = $expiryTime - $currentTime;

		$this->mockedCache->expects($this->once())
		->method('setLifetime')
		->with($numberOfSecondsUntilExpiry);

		$this->model->setCacheExpiryTime();
	}

    /**
     * @expectedException Exception
     */
    public function testCheckGuidForInvalidCharactersThrowsException_whenNonValidCharactersSuppliedInGuid()
    {
        $this->model->guid = '1234%$£%£';

        $this->model->checkGuidForInvalidCharacters;
    }
}