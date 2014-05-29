<?php
/**
 * @group Integration
 * @group Models
 * @group StudentsModelIntegration
 */

class Timetabling_Model_StudentsIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $studentIdAndTableAssignmentXsd;
    private $studentIdNameAndUsernameXsd;

    private $students;
    private $year;

    public function setUp()
    {
        parent::setUp();

        $this->studentIdAndTableAssignmentXsd = TEST_PATH . '/modules/timetabling/models/StudentsXsdFiles/StudentIdAndTableAssignment.xsd';
        $this->studentIdNameAndUsernameXsd = TEST_PATH . '/modules/timetabling/models/StudentsXsdFiles/StudentIdNameAndUsername.xsd';

        $this->year = YEAR; //defined in phpunit.xml
    }

    public function testStudentIdAndTableAssignmentXmlConformsToStudentIdAndTableAssignmentXsd()
    {
        //haven't implemented full integration tests for this endpoint - too slow

        $this->retrieveData = new Datasource_Biomedsci($this->config, $this->logger);
        $this->students = new Timetabling_Model_Students($this->retrieveData, $this->logger);

        $xml = new DOMDocument();
        $xml->loadXML($this->students->getStudentIdsAndTableAssignmentForModule($this->year, 'A11CRH'));

        $xml->schemaValidate($this->studentIdAndTableAssignmentXsd);
    }

    public function testStudentIdNameAndUsernameXmlConformsToStudentIdNameAndUsernameXsd()
    {
        //haven't implemented full integration tests for this endpoint - too slow

        $this->retrieveData = new Datasource_Saturn($this->config, $this->logger);
        $this->students = new Timetabling_Model_Students($this->retrieveData, $this->logger);

        $xml = new DOMDocument();
        $xml->loadXML($this->students->getStudentIdNameAndUsername($this->year, 'A11CRH'));

        $xml->schemaValidate($this->studentIdNameAndUsernameXsd);
    }

}
