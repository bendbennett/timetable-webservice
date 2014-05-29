<?php

class Timetabling_Model_Students extends Timetabling_Model_Model
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

    public function getStudentIdsAndTableAssignmentForModule($year, $guid)
    {
        $xml = $this->getData($year, 'getStudentIdsAndTableAssignmentForModule', $guid);
        return $xml;
    }

    public function getStudentIdNameAndUsername($year, $guid)
    {
        $twoDigitYear = substr($year, 2, 4);
        $xml = $this->getData($year, 'queryForStudentIdNameAndUserName', $guid.'|'.$twoDigitYear);
        return $xml;
    }

}
