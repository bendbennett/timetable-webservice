<?php

class StudentsController extends Controller_Controller
{

    private $students;
    private $studentsTwo;
    private $biomedsciDatasource;
    private $saturnDatasource;
    private $studentsProcessor;


    public function init()
    {
        parent::init();

        $this->biomedsciDatasource = new Datasource_Biomedsci($this->config, $this->logger);
        $this->students = new Timetabling_Model_Students($this->biomedsciDatasource, $this->logger);

        $this->saturnDatasource = new Datasource_Saturn($this->config, $this->logger);
        $this->studentsTwo = new Timetabling_Model_Students($this->saturnDatasource, $this->logger);

        $this->studentsProcessor = new Timetabling_Model_StudentsProcessor($this->students, $this->studentsTwo);
    }


    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public function __get($name)
    {
        return $this->$name;
    }


    public function moduletableassignmentAction()
    {
        $this->preprocess();
        $xml = $this->studentsProcessor->getStudentIdNameUsernameAndTableAssignmentForModule($this->year, $this->guid);
        $this->postprocess($xml);
    }

}
