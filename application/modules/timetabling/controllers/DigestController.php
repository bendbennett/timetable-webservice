<?php

class DigestController extends Controller_Controller
{
    private $digest;


    public function init()
    {
        parent::init();
        $this->digest = new Timetabling_Model_Digest($this->datasource, $this->logger);
    }


    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public function __get($name)
    {
        return $this->$name;
    }


    public function indexAction()
    {
        $this->preprocess(false, false);
        $xml = $this->digest->getDigest();
        $this->postprocess($xml);
    }

}
