<?php

/**
 * @group Unit
 * @group Models
 * @group DigestModelUnit
 */

class Timetabling_Model_DigestUnitTest extends PHPUnit_Framework_TestCase
{
    private $mockedRetrieveData;
    private $mockedLogger;
    private $digest;

    public function setUp()
    {
        $this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
        $this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
        $this->digest = new Timetabling_Model_Digest($this->mockedRetrieveData, $this->mockedLogger);

        Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
    }

    public function tearDown()
    {
        Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
    }

    public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
    {
        $this->assertInstanceOf('Datasource_RetrieveData', $this->digest->retrieveData);
    }

    public function testGetDigestCallsRetrieveDataOnce()
    {
        $this->mockedRetrieveData->expects($this->once())->method('getData');
        $this->digest->getDigest();
    }

}

?>
