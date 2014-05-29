<?php

/**
 * @group Unit
 * @group Models
 * @group StudentsProcessorModelUnit
 */

class Timetabling_Model_StudentsProcessorUnitTest extends PHPUnit_Framework_TestCase
{
    private $mockedStudents;
    private $mockedStudentsTwo;
    private $studentsProcessor;

    public function setUp()
    {
        //look at the method signature of getMock to see how calling constructor can be avoided
        //http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
        $this->mockedStudents = $this->getMock('Timetabling_Model_Students', array('getStudentIdsAndTableAssignmentForModule'), array(), '', false);
        $this->mockedStudentsTwo = $this->getMock('Timetabling_Model_Students', array('getStudentIdNameAndUsername'), array(), '', false);

        $this->studentsProcessor = new Timetabling_Model_StudentsProcessor($this->mockedStudents, $this->mockedStudentsTwo);

        Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
    }

    public function tearDown()
    {
        Zend_Registry::get('cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
    }

    public function testGetStudentIdNameUsernameAndTableAssignmentForModuleCallsDatasourcesOnceEach()
    {
        $this->mockedStudents->expects($this->once())
            ->method('getStudentIdsAndTableAssignmentForModule')
            ->with($this->equalTo(2011), $this->equalTo('ABCD'))
            ->will($this->returnValue('<Student></Student>'));

        $this->mockedStudentsTwo->expects($this->once())
            ->method('getStudentIdNameAndUsername')
            ->with($this->equalTo(2011), $this->equalTo('ABCD'))
            ->will($this->returnValue('<Student></Student>'));

        $this->studentsProcessor->getStudentIdNameUsernameAndTableAssignmentForModule(2011, 'ABCD');
    }

}