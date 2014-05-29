<?php

class Timetabling_Model_Digest extends Timetabling_Model_Model
{

    public function __construct($retrieveData, $logger)
    {
        parent::__construct($retrieveData, $logger);
        $this->setCacheExpiryTime();
    }

    public function __set($name,$value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getDigest()
    {
        $xml = $this->getData(null, 'getDigest');
        return $xml;
    }

}
