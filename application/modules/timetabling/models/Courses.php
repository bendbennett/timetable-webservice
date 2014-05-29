<?php

class Timetabling_Model_Courses extends Timetabling_Model_Model
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

	public function getCourses($year)
	{
		$xml = $this->getData($year, 'getCourses');
		return $xml;
	}

	public function getCoursesBySchool($year, $guid)
	{
		$xml = $this->getData($year, 'getCoursesBySchool', $guid);
		return $xml;
	}

	public function getCoursesContributedToBySchoolStaff($year, $guid)
	{
		$xml = $this->getData($year, 'getCoursesContributedToBySchoolStaff', $guid);
		return $xml;
	}
	
	public function getCoursesStudents($year, $guid)
	{
		$xml = $this->getData($year, 'getCoursesStudents', $guid);
		return $xml;		
	}

}

