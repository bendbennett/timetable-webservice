<?php

/**
 * @group Integration
 * @group Models
 * @group CoursesModelIntegration
 */


class Timetabling_Model_CoursesIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $coursesXsd;
    private $coursesContributedToBySchoolStaffXsd;
    private $coursesStudentsXsd;

    private $courses;
    private $year;

    public function setUp()
    {
        parent::setUp();

        $this->coursesXsd = TEST_PATH . '/modules/timetabling/models/CoursesXsdFiles/Courses.xsd';
        $this->coursesContributedToBySchoolStaffXsd = TEST_PATH . '/modules/timetabling/models/CoursesXsdFiles/CoursesContributedToBySchoolStaff.xsd';
        $this->coursesStudentsXsd = TEST_PATH . '/modules/timetabling/models/CoursesXsdFiles/CoursesStudents.xsd';

        $this->courses = new Timetabling_Model_Courses($this->retrieveData, $this->logger);
        $this->year = YEAR; //defined in phpunit.xml
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /*
     * /:year/courses
     */
    public function testGetCourses_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->courses->getCourses($this->year));

        $xml->schemaValidate($this->coursesXsd);
    }

    /*
     * /:year/courses/school/:guid
     */
    public function testGetCoursesBySchool_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->courses->getCoursesBySchool($this->year, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->coursesXsd);
    }

    public function testGetCoursesBySchool_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
        $schoolsXml = simplexml_load_string($schools->getSchools($this->year));

        foreach ($schoolsXml as $school)
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->courses->getCoursesBySchool($this->year, $school->Guid));

            $xml->schemaValidate($this->coursesXsd);
        }
    }

    /*
     * /:year/courses/school-staff/:guid
     */
    public function testGetCoursesContributedToBySchoolStaff_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->courses->getCoursesContributedToBySchoolStaff($this->year, '9FC09C9E24DB1D8B8EFA981A4A102A1'));

        $xml->schemaValidate($this->coursesContributedToBySchoolStaffXsd);
    }

    public function testGetCoursesContributedToBySchoolStaff_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
        $schoolsXml = simplexml_load_string($schools->getSchools($this->year));

        foreach ($schoolsXml as $school)
        {
            $xml = new DOMDocument();
            $xml->loadXML($this->courses->getCoursesContributedToBySchoolStaff($this->year, $school->Guid));

            $xml->schemaValidate($this->coursesContributedToBySchoolStaffXsd);
        }
    }

    /*
     * "/:year/courses/students/:guid"
     */
    public function testGetCoursesStudents_returnsXml_whichAdheresToXsd_whenNoActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->courses->getCoursesStudents($this->year, '43F3A2E1E9A3706895857EF9A5EA386'));

        $xml->schemaValidate($this->coursesStudentsXsd);
    }

    public function testGetCoursesStudents_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
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
                $xml->loadXML($this->courses->getCoursesStudents($this->year, $course->Guid));

                $xml->schemaValidate($this->coursesStudentsXsd);
            }
        }
        */

        $xml = new DOMDocument();
        $xml->loadXML($this->courses->getCoursesStudents($this->year, '643F3A2E1E9A3706895857EF9A5EA386'));

        $xml->schemaValidate($this->coursesStudentsXsd);
    }

}

?>
