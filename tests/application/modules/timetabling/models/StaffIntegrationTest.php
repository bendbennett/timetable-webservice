<?php
/**
 * @group Integration
 * @group Models
 * @group StaffModelIntegration
 */

class Timetabling_Model_StaffIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $staffXsd;
    private $staffExchange;

    private $staff;
    private $year;

    public function setUp()
    {
        parent::setUp();

        $this->staffXsd = TEST_PATH . '/modules/timetabling/models/StaffXsdFiles/Staff.xsd';
        $this->staffExchange = TEST_PATH . '/modules/timetabling/models/StaffXsdFiles/StaffExchange.xsd';

        $this->staff = new Timetabling_Model_Staff($this->retrieveData, $this->logger);
        $this->year = YEAR; //defined in phpunit.xml
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /*
     * /:year/staff
     */
    public function testGetStaff_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->staff->getStaff($this->year));

        $xml->schemaValidate($this->staffXsd);
    }

    /*
     * /:year/staff/school/:guid
     */
    public function testGetStaffBySchool_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->staff->getStaffBySchool($this->year, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->staffXsd);
    }

    public function testGetStaffBySchool_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
        $schoolsXml = simplexml_load_string($schools->getSchools($this->year));

        foreach ($schoolsXml as $school)
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->staff->getStaffBySchool($this->year, $school->Guid));

            $xml->schemaValidate($this->staffXsd);
        }
    }

    /*
     * /:year/staff/exchange
     */
    public function testGetStaffForExchange_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $fakeServerGlobal = array();
        $fakeServerGlobal['SERVER_NAME'] = 'fakeServer';
        $fakeServerGlobal['REQUEST_URI'] = 'fakeUri';
        $this->staff->server = $fakeServerGlobal;

        $xml = new DOMDocument();
        $xml->loadXML($this->staff->getStaffForExchange($this->year, '1234'));

        $xml->schemaValidate($this->staffExchange);
    }

}

?>