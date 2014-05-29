<?php
/**
 * @group Integration
 * @group Models
 * @group SchoolsModelIntegration
 */

class Timetabling_Model_SchoolsIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $schoolsXsd;

    private $schools;

    public function setUp()
    {
        parent::setUp();

        $this->schoolsXsd = TEST_PATH . '/modules/timetabling/models/SchoolsXsdFiles/Schools.xsd';

        $this->schools = new Timetabling_Model_Schools($this->retrieveData, $this->logger);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /*
     * /:year/schools
     */
    public function testGetSchools_returnsXml_whichAdheresToXsd_whenActivitiesReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->schools->getSchools(YEAR));

        $xml->schemaValidate($this->schoolsXsd);
    }

}

?>