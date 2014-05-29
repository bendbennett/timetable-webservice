<?php

class Timetabling_Model_Activities extends Timetabling_Model_Model
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

	public function getActivitiesByCourse($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesByCourse', $guid);
		return $xml;
	}

	public function getActivitiesByModule($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesByModule', $guid);
		return $xml;
	}

	public function getActivitiesForModulesAdministeredBySchool($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesForModulesAdministeredBySchool', $guid);
		return $xml;
	}

	public function getActivitiesByStaff($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesByStaff', $guid);
		return $xml;
	}

	public function getActivitiesContributedToBySchoolStaff($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesContributedToBySchoolStaff', $guid);
		return $xml;
	}

	public function getActivitiesForStaffExchange($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesForStaffExchange', $guid);
		return $xml;
	}

	public function getActivitiesByStudent($year, $guid)
	{
		$xml = $this->getData($year, 'getActivitiesByStudent', $guid);
		return $xml;
	}
}



