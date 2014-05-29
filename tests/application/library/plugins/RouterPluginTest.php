<?php
/**
 * @group Unit
 * @group Plugins
 * @group RouterPluginUnit
 */

class RouterPluginTest extends PHPUnit_Framework_TestCase
{
    private $router;

    public function setUp()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->resetInstance();
        $this->router = $front->getRouter();
    }

    public function testDevOnlyRoutesIncluded_whenApplicationEnvIsDev()
    {
        $routerPlugin = new Plugin_RouterPlugin('development');
        $mockRequest = $this->getMock('Zend_Controller_Request_Http');
        $routerPlugin->routeStartup($mockRequest);

        $this->assertTrue($this->router->hasRoute('courses_students'));
        $this->assertTrue($this->router->hasRoute('modules_students'));
        $this->assertTrue($this->router->hasRoute('activities_student'));
    }

    public function testDevOnlyRoutesNotIncluded_whenApplicationEnvIsNotDev()
    {
        $routerPlugin = new Plugin_RouterPlugin('production');
        $mockRequest = $this->getMock('Zend_Controller_Request_Http');
        $routerPlugin->routeStartup($mockRequest);

        $this->assertFalse($this->router->hasRoute('courses_students'));
        $this->assertFalse($this->router->hasRoute('modules_students'));
        $this->assertFalse($this->router->hasRoute('activities_student'));
    }

}