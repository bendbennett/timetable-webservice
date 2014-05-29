<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	echo Zend_Controller_Action::_getParam('year');
        // action body
        //$this->url(array('year' => 'martel'), 'user') ;
    }
    
    public function testAction()
    {
    	
    }


}

