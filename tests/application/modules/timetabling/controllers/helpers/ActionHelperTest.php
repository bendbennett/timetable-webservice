<?php

/**
 * @group ActionHelper
 */

class ActionHelperTest extends PHPUnit_Framework_TestCase
{
	private $params;
	private $controller;
	private $mockedRetrieveData;
	private $mockedLogger;

	public function setUp()
	{
		$this->mockedRetrieveData = $this->getMock('Datasource_Timetabling', array('getData'), array(), '', false);
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->params = new Helper_ActionHelper();
		$this->params->response = new Test_Resource_Response();
		$this->controller = new Test_Resource_ControllerTestCase();
	}

	/**
	 * @expectedException Exception
	 */
	public function testCheckYearIsNotNullThrowsException_whenYearIsNullOrWhitespaceOrEmptyString()
	{
		$year = null;
		$this->params->checkYearIsNotNull($year);
	}

	/**
	 * @expectedException Exception
	 */
	public function testCheckYearIsNotNullThrowsException_whenYearIsWhitespace()
	{
		$year = '   ';
		$this->params->checkYearIsNotNull($year);
	}

	/**
	 * @expectedException Exception
	 */
	public function testCheckYearIsNotNullThrowsException_whenYearIsEmptyString()
	{
		$year = '';
		$this->params->checkYearIsNotNull($year);
	}

	/**
	 * @expectedException Exception
	 */
	public function testcheckGuidFormatThrowsException_whenGuidIsNull()
	{
		$guid = null;
		$this->params->checkGuidFormat($guid);
	}

	/**
	 * @expectedException Exception
	 */
	public function testcheckGuidFormatThrowsException_whenGuidIsWhiteSpace()
	{
		$guid = '   ';
		$this->params->checkGuidFormat($guid);
	}

	/**
	 * @expectedException Exception
	 */
	public function testcheckGuidFormatThrowsException_whenGuidIsEmpty()
	{
		$guid = '';
		$this->params->checkGuidFormat($guid);
	}

	/**
	 * @expectedException Exception
	 */
	public function testcheckGuidFormatThrowsException_whenGuidIsContainsAnythingOtherThanCapitalisedAlphaNumerics()
	{
		$guid = 'abc123';
		$this->params->checkGuidFormat($guid);
	}

	/**
	 * @expectedException Exception
	 */
	public function testCheckYearIsNumericThrowsException_whenYearIsString()
	{
		$year = 'weqwe';
		$this->params->checkYearIsNumeric($year);
	}

	/**
	 * @expectedException Exception
	 */
	public function testCheckYearIsNumericThrowsException_whenYearIsStringContainingNumbers()
	{
		$year = '2010ahfdsjkhfjkds';
		$this->params->checkYearIsNumeric($year);
	}

	public function testSwitchContextSetsHeaderToJson_whenWhenRequestHeaderContentTypeIsApplicationJson()
	{
		$this->controller->request->setHeader('Content-Type', 'application/json');
		$this->params->request = $this->controller->getRequest();
		$this->params->switchContext();
		$responseHeaders = $this->params->response->getHeaders();
		$responseContentType = '';
		
		foreach ($responseHeaders as $key => $value)
		{
			if ($value['name'] == 'Content-Type')
			{
				$responseContentType = $value['value'];
				break;
			}
		}

		$this->assertEquals('application/json', $responseContentType);
	}

	public function testSwitchContextSetsHeaderToXml_whenRequestHeaderContentTypeIsApplicationXml()
	{
		$this->controller->request->setHeader('Content-Type', 'application/xml');
		$this->params->request = $this->controller->getRequest();
		$this->params->switchContext();
		$responseHeaders = $this->params->response->getHeaders();
		$responseContentType = '';

		foreach ($responseHeaders as $key => $value)
		{
			if ($value['name'] == 'Content-Type')
			{
				$responseContentType = $value['value'];
				break;
			}
		}

		$this->assertEquals($responseContentType, 'application/xml');
	}

	/**
	 * @expectedException Exception
	 */	
	public function testSwitchContextThrowsException_whenContentTypeIsNeitherXmlOrJson()
	{
		$this->controller->request->setHeader('Content-Type', 'application/html');
		$this->params->request = $this->controller->getRequest();
		$this->params->switchContext();
	}

	public function testFunctionPrepareDataWhenContentTypeIsApplicationXml()
	{
		$this->controller->request->setHeader('Content-Type', 'application/xml');
		$this->params->request = $this->controller->getRequest();
		$this->params->switchContext();
		$returnData = $this->params->prepareData('<root></root>');
		$this->assertEquals('<root></root>',$returnData);
	}

	public function testFunctionPrepareDataWhenContentTypeIsApplicationJson()
	{
		$this->controller->request->setHeader('Content-Type', 'application/json');
		$this->params->request = $this->controller->getRequest();
		$this->params->switchContext();
		$returnData = $this->params->prepareData('<root><school>Nurses</school></root>');
		$this->assertEquals('{"root":{"school":"Nurses"}}',$returnData);
	}


    public function testFunctionPrepareDataWhenFormatisSettoJson()
    {
        $this->controller->request->setParam('format',"json");
        $this->params->request = $this->controller->getRequest();
        $this->params->switchContext();
        $returnData = $this->params->prepareData('<root><school>Nurses</school></root>');
        $this->assertEquals('{"root":{"school":"Nurses"}}',$returnData);
    }

}

?>