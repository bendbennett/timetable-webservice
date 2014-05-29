<?php
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

class Test_Resource_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     *
     * Enter description here ...
     * @var Zend_Application
     */
    protected $application;

    public function setUp()
    {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap()
    {
        $this->application =
            new Zend_Application(APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
    }

}