<?php

class Timetabling_Model_StudentsProcessor
{
    private $biomedsciStudentData;
    private $saturnStudentData;

    public function __construct($biomedsciStudentData, $saturnStudentData)
    {
        $this->biomedsciStudentData = $biomedsciStudentData;
        $this->saturnStudentData = $saturnStudentData;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getStudentIdNameUsernameAndTableAssignmentForModule($year, $guid)
    {
        $xmlTables = $this->biomedsciStudentData->getStudentIdsAndTableAssignmentForModule($year, $guid);
        $tablesDoc = new SimpleXMLElement($xmlTables);

        $xmlNames = $this->saturnStudentData->getStudentIdNameAndUsername($year, $guid);
        $namesDoc = new SimpleXMLElement($xmlNames);

        foreach ($namesDoc->Student as $student)
        {
            $tablesStudentIdNodeArray = $tablesDoc->Student->xpath("//*[contains(text(), '$student->StudentId')]");

            if (!array_key_exists(0, $tablesStudentIdNodeArray)) continue;

            $tablesStudentIdParentNode = $tablesStudentIdNodeArray[0]->xpath("parent::*");
            $student->addChild('TableId', $tablesStudentIdParentNode[0]->TableId);
        }

        return $namesDoc->asXML();
    }

}