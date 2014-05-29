<?php

/**
 * @group Integration
 * @group Models
 * @group StudentsProcessorModelIntegration
 */

class Timetabling_Model_StudentsProcessorIntegrationTest extends AbstractModelIntegrationTestCase
{

    private $studentIdNameUsernameAndTableAssignmentXsd;
    private $students;
    private $studentsTwo;
    private $studentsProcessor;

    public function setUp()
    {
        parent::setUp();

        $this->studentIdNameUsernameAndTableAssignmentXsd = TEST_PATH . '/modules/timetabling/models/StudentsXsdFiles/StudentIdNameUsernameAndTableAssignment.xsd';

        $retrieveData = new Datasource_Biomedsci($this->config, $this->logger);
        $this->students = new Timetabling_Model_Students($retrieveData, $this->logger);

        $retrieveData = new Datasource_Saturn($this->config, $this->logger);
        $this->studentsTwo = new Timetabling_Model_Students($retrieveData, $this->logger);

        $this->studentsProcessor = new Timetabling_Model_StudentsProcessor($this->students, $this->studentsTwo);
    }

    public function testStudentIdAndTableAssignmentXmlConformsToStudentIdAndTableAssignmentXsd()
    {
        //haven't implemented full integration tests for this endpoint - too slow

        $xml = new DOMDocument();
        $xml->loadXML($this->studentsProcessor->getStudentIdNameUsernameAndTableAssignmentForModule(YEAR, 'A11CRH'));

        $xml->schemaValidate($this->studentIdNameUsernameAndTableAssignmentXsd);
    }

}
