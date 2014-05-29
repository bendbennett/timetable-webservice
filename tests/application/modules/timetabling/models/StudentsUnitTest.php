<?php

/**
 * @group Unit
 * @group Models
 * @group StudentsModelUnit
 */

class Timetabling_Model_StudentsUnitTest extends PHPUnit_Framework_TestCase
{
    private $mockedRetrieveData;
    private $mockedLogger;
    private $students;

    public function setUp()
    {
        $this->mockedRetrieveData = $this->getMock('Datasource_RetrieveData', array('getData'), array(), '', false);
        $this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
        $this->students = new Timetabling_Model_Students($this->mockedRetrieveData, $this->mockedLogger);

        Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
    }

    public function tearDown()
    {
        Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
    }

    public function testCheckMemberVariablesHaveCorrectObjectTypesAssigned()
    {
        $this->assertInstanceOf('Datasource_RetrieveData', $this->students->retrieveData);
    }

    public function testGetStudentIdsAndTableAssignmentForModuleCallsRetrieveDataOnce()
    {
        $this->mockedRetrieveData->expects($this->once())
            ->method('getData')
            ->with($this->equalTo(2011), $this->equalTo('getStudentIdsAndTableAssignmentForModule'), $this->equalTo(array('ABCD')));
        $this->students->getStudentIdsAndTableAssignmentForModule(2011, 'ABCD');
    }

    public function testGetStudentIdNameAndUsernameCallsRetrieveDataOnce_withCorrectArguments()
    {
        $this->mockedRetrieveData->expects($this->once())
            ->method('getData')
            ->with($this->equalTo(2011), $this->equalTo('queryForStudentIdNameAndUserName'), $this->equalTo(array('ABCD|11')));
        $this->students->getStudentIdNameAndUsername(2011,'ABCD');
    }

}
