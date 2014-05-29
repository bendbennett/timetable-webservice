<?php
/**
 * @group Integration
 * @group Models
 * @group ModulesModelIntegration
 */


class Timetabling_Model_ModulesIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $modulesXsd;
    private $modulesContributedToBySchoolStaffXsd;
    private $modulesCourseXsd;
    private $modulesStudentsXsd;

    private $modules;
    private $year;

    public function setUp()
    {
        parent::setUp();

        $this->modulesXsd = TEST_PATH . '/modules/timetabling/models/ModulesXsdFiles/Modules.xsd';
        $this->modulesContributedToBySchoolStaffXsd = TEST_PATH . '/modules/timetabling/models/ModulesXsdFiles/ModulesContributedToBySchoolStaff.xsd';
        $this->modulesCourseXsd = TEST_PATH . '/modules/timetabling/models/ModulesXsdFiles/ModulesCourse.xsd';
        $this->modulesStudentsXsd = TEST_PATH . '/modules/timetabling/models/ModulesXsdFiles/ModulesStudents.xsd';

        $this->modules = new Timetabling_Model_Modules($this->retrieveData, $this->logger);
        $this->year = YEAR; //defined in phpunit.xml
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /*
     * /:year/modules
     */
    public function testGetModules_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModules($this->year));

        $xml->schemaValidate($this->modulesXsd);
    }

    /*
     * /:year/modules/school/:guid
     */
    public function testGetModulesBySchool_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModulesBySchool($this->year, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->modulesXsd);
    }

    public function testGetCoursesBySchool_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
        $schoolsXml = simplexml_load_string($schools->getSchools($this->year));

        foreach ($schoolsXml as $school)
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->modules->getModulesBySchool($this->year, $school->Guid));

            $xml->schemaValidate($this->modulesXsd);
        }
    }

    /*
     * /:year/modules/school-staff/:guid
     */
    public function testGetModulesContributedToBySchoolStaff_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModulesContributedToBySchoolStaff($this->year, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->modulesContributedToBySchoolStaffXsd);
    }

    public function testGetModulesContributedToBySchoolStaff_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
        $schoolsXml = simplexml_load_string($schools->getSchools($this->year));

        foreach ($schoolsXml as $school)
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->modules->getModulesContributedToBySchoolStaff($this->year, $school->Guid));

            $xml->schemaValidate($this->modulesContributedToBySchoolStaffXsd);
        }
    }

    /*
     * /:year/modules/course/:guid
     */
    public function testGetModulesByCourse_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModulesByCourse($this->year, '43F3A2E1E9A3706895857EF9A5EA386'));

        $xml->schemaValidate($this->modulesCourseXsd);
    }

    public function testGetModulesByCourse_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        //haven't implemented full integration tests for this endpoint - too slow
        /*
        $courses = new Timetabling_Model_Courses($this->retrieveData, $this->logger);
        $coursesXml = simplexml_load_string($courses->getCourses($this->year));

        foreach ($coursesXml->School as $school)
        {
            foreach ($school->Course as $course)
            {
                $xml = new DOMDocument();
                $xml->loadXML($this->modules->getModulesByCourse($this->year, $course->Guid));

                $xml->schemaValidate($this->modulesCourseXsd);
            }
        }
        */

        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModulesByCourse($this->year, '643F3A2E1E9A3706895857EF9A5EA386'));

        $xml->schemaValidate($this->modulesCourseXsd);
    }

    /*
     * /:year/modules/students/:guid
     */
    public function testGetModulesStudents_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModulesStudents($this->year, '43F3A2E1E9A3706895857EF9A5EA386'));

        $xml->schemaValidate($this->modulesStudentsXsd);
    }

    public function testGetModulesStudents_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        //haven't implemented full integration tests for this endpoint - too slow

        $xml = new DOMDocument();
        $xml->loadXML($this->modules->getModulesStudents($this->year, '643F3A2E1E9A3706895857EF9A5EA386'));

        $xml->schemaValidate($this->modulesStudentsXsd);
    }

}