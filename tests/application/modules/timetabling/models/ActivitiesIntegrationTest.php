<?php
/**
 * @group Integration
 * @group Models
 * @group ActivitiesModelIntegration
 */

class Timetabling_Model_ActivitiesIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $activitiesSchoolModulesXsd;
    private $activitiesSchoolStaffXsd;
    private $activitiesCourseXsd;
    private $activitiesModuleXsd;
    private $activitiesStaffXsd;
    private $activitiesStaffExchangeXsd;
    private $activitiesStudentXsd;

    private $activities;

    public function setUp()
    {
        parent::setUp();

        $this->activitiesSchoolModulesXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesSchoolModules.xsd';
        $this->activitiesSchoolStaffXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesSchoolStaff.xsd';
        $this->activitiesCourseXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesCourse.xsd';
        $this->activitiesModuleXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesModule.xsd';
        $this->activitiesStaffXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesStaff.xsd';
        $this->activitiesStaffExchangeXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesStaffExchange.xsd';
        $this->activitiesStudentXsd = TEST_PATH . '/modules/timetabling/models/ActivitiesXsdFiles/ActivitiesStudent.xsd';

        $this->activities = new Timetabling_Model_Activities($this->retrieveData, $this->logger);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /*
     * tests for getActivitiesForModulesAdministeredBySchool()
     * only testing 1 School (Biomedsci) as tests run toooooooo slowly to iterate through all Schools
     * can use the same methodology as used in ModulesIntegrationTest to grab all Schools and iterate through if desired
     *
     * /:year/activities/school-modules/:guid
     */
    public function testGetActivitiesForModulesAdministeredBySchool_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesForModulesAdministeredBySchool(YEAR, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->activitiesSchoolModulesXsd);
    }

    public function testGetActivitiesForModulesAdministeredBySchool_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        /*
        get all Schools and iterate through School codes - takes too long so haven't implemented complete integration tests for
        any of the Activities endpoints, just looking at 1 School, Module, Course etc

        $this->schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
        $schoolsXml = simplexml_load_string($this->schools->getSchools(YEAR));

        foreach ($schoolsXml as $school)
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->activities->getActivitiesForModulesAdministeredBySchool(YEAR, $school->Guid));

            $xml->schemaValidate($this->activitiesSchoolModulesXsd);
        }
        */

        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesForModulesAdministeredBySchool(YEAR, 'B9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->activitiesSchoolModulesXsd);
    }

    /*
     * /:year/activities/school-staff/:guid
     */
    public function testGetActivitiesForSchoolStaff_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesContributedToBySchoolStaff(YEAR, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->activitiesSchoolStaffXsd);
    }

    public function testGetActivitiesForSchoolStaff_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesForModulesAdministeredBySchool(YEAR, 'B9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->activitiesSchoolStaffXsd);
    }

    /*
     * /:year/activities/course/:guid
     */
    public function testGetActivitiesForCourse_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesByCourse(YEAR, '43F3A2E1E9A3706895857EF9A5EA388'));

        $xml->schemaValidate($this->activitiesCourseXsd);
    }

    public function testGetActivitiesForCourse_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesByCourse(YEAR, '643F3A2E1E9A3706895857EF9A5EA388'));

        $xml->schemaValidate($this->activitiesCourseXsd);
    }

    /*
     * /:year/activities/module/:guid
     */
    public function testGetActivitiesForModule_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesByModule(YEAR, '11101'));

        $xml->schemaValidate($this->activitiesModuleXsd);
    }

    public function testGetActivitiesForModule_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesByModule(YEAR, 'B11101'));

        $xml->schemaValidate($this->activitiesModuleXsd);
    }

    /*
     * /:year/activities/staff/:guid
     */
    public function testGetActivitiesForStaff_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesByStaff(YEAR, '4484AB775513FEEBD040BBC0946375F'));

        $xml->schemaValidate($this->activitiesStaffXsd);
    }

    public function testGetActivitiesForStaff_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesByStaff(YEAR, '84484AB775513FEEBD040BBC0946375F'));

        $xml->schemaValidate($this->activitiesStaffXsd);
    }

    /*
     * /:year/activities/staff-exchange/:guid
     */
    public function testGetActivitiesForStaffExchange_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesForStaffExchange(YEAR, '00025162'));

        $xml->schemaValidate($this->activitiesStaffExchangeXsd);
    }

    public function testGetActivitiesForStaffExchange_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->activities->getActivitiesForStaffExchange(YEAR, '400025162'));

        $xml->schemaValidate($this->activitiesStaffExchangeXsd);
    }

}

?>