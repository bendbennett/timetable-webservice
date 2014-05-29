<?php
/**
 * @group Integration
 * @group Models
 * @group YearsModelIntegration
 */

class Timetabling_Model_YearsIntegrationTest extends AbstractModelIntegrationTestCase
{
    private $yearsXsd;

	private $years;

	public function setUp()
	{
		parent::setUp();

        $this->yearsXsd = TEST_PATH . '/modules/timetabling/models/YearsXsdFiles/Years.xsd';

		$this->years = new Timetabling_Model_Years($this->retrieveData, $this->logger);
	}

	public function tearDown()
	{
		parent::tearDown();
	}

    /*
     * /years
     */
    public function testGetYears_returnsXml_whichAdheresToXsd_whenYearsReturned()
    {
        $xml = new DOMDocument();
        $xml->loadXML($this->years->getYears());

        $xml->schemaValidate($this->yearsXsd);
    }
}

