<?php

class Timetabling_Model_Modules extends Timetabling_Model_Model
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

	public function getModules($year)
	{
		$xml = $this->getData($year, 'getModules');
		return $xml;
	}

	public function getModulesBySchool($year, $guid)
	{
		$xml = $this->getData($year, 'getModulesBySchool', $guid);
		return $xml;
	}

	public function getModulesContributedToBySchoolStaff($year, $guid)
	{
		$xml = $this->getData($year, 'getModulesContributedToBySchoolStaff', $guid);
		return $xml;
	}

	public function getModulesByCourse($year,$guid)
	{
		$xml = $this->getData($year, 'getModulesByCourse', $guid);
		return $xml;
	}
	
	public function getModulesStudents($year,$guid)
	{
		$xml = $this->getData($year, 'getModulesStudents', $guid);
		return $xml;
	}

}

