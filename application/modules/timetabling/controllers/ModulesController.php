<?php

class ModulesController extends Controller_Controller
{

	private $modules;


	public function init()
	{
		parent::init();
		$this->modules = new Timetabling_Model_Modules($this->datasource, $this->logger);
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
		$this->preprocess(true, false);
		$xml = $this->modules->getModules($this->year);
		$this->postprocess($xml);
	}


	public function schoolAction()
	{
		$this->preprocess();
		$xml = $this->modules->getModulesBySchool($this->year, $this->guid);
		$this->postprocess($xml);		
	}
	

	public function schoolstaffAction()
	{
		$this->preprocess();
		$xml = $this->modules->getModulesContributedToBySchoolStaff($this->year, $this->guid);
		$this->postprocess($xml);	
	}
	

	public function courseAction()
	{
		$this->preprocess();
		$xml = $this->modules->getModulesByCourse($this->year, $this->guid);
		$this->postprocess($xml);			
	}

	public function studentsAction()
	{
		$this->preprocess();
		$xml = $this->modules->getModulesStudents($this->year, $this->guid);
		$this->postprocess($xml);			
	}
	
}





