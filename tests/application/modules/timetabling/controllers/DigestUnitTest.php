<?php

/**
 * @group Controllers
 * @group DigestControllerUnit
 * @group Unit
 */

class DigestUnitTest extends AbstractControllerTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testInstanceVariablesAreNotNullAndOfExpectedType()
    {
        $digestController = new DigestController($this->request, $this->response);
        // the config member is an instance of the Zend_config_Ini object
        $this->assertNotNull($digestController->config);
        $this->assertInstanceOf('Zend_Config_Ini', $digestController->config);

        $this->assertNotNull($digestController->params);
        $this->assertInstanceOf('Zend_Controller_Action_Helper_Abstract', $digestController->params);
        $this->assertInstanceOf('Helper_ActionHelper', $digestController->params);

        $this->assertNotNull($digestController->digest);
        $this->assertNotNull($digestController->datasource);
        $this->assertInstanceOf('Datasource_RetrieveData', $digestController->datasource);
    }

    public function testDigestIndexIsCalledAsExpected()
    {
        $mockedParams = $this->getMock('Helper_ActionHelper');
        $mockedParams->expects($this->once())->method('switchContext');
        $mockedParams->expects($this->once())->method('prepareData');

        //look at the method signature of getMock to see how calling constructor can be avoided
        //http://stackoverflow.com/questions/279493/phpunit-avoid-constructor-arguments-for-mock
        $mockedDigest = $this->getMock('Timetabling_Model_Digest', array('getDigest'), array(), '', false);
        $mockedDigest->expects($this->once())->method('getDigest');

        $digestController = new DigestController($this->request, $this->response);
        $digestController->init();
        $digestController->params = $mockedParams;
        $digestController->digest = $mockedDigest;

        $digestController->indexAction();
    }

}
