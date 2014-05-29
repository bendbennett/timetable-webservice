<?php

/**
 * @group Unit
 * @group Models
 * @group StaffModelUnit
 */

class Timetabling_Model_StaffUnitTest extends PHPUnit_Framework_TestCase
{
	private $mockedRetrieveData;
	private $mockedLogger;
	private $staff;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->staff = new Timetabling_Model_Staff($this->mockedRetrieveData, $this->mockedLogger);

		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function tearDown()
	{
		Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
	}

	public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
	{
		$this->assertInstanceOf('Datasource_RetrieveData', $this->staff->retrieveData);
	}

	public function testGetStaffCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->staff->getStaff(2011);
	}

	public function testGetStaffBySchoolCallsRetrieveDataOnce()
	{
		$this->mockedRetrieveData->expects($this->once())->method('getData');
		$this->staff->getStaffBySchool(2011,'4A62723013D6636D02C83FB2FAF2BFAC');
	}

	public function testGetStaffForExchangeCallsRetrieveDataOnce()
	{
		$this->staff->server = array('SERVER_NAME' => 'nameOfServer', 'REQUEST_URI' => 'request/containing/year/', );
		$this->mockedRetrieveData->expects($this->once())->method('getData')->will($this->returnValue('<root />'));
		$this->staff->getStaffForExchange(2011, 'xyz');
	}
}

?>
