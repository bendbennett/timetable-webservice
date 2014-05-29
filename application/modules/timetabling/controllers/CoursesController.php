<?php

class CoursesController extends Controller_Controller
{

	private $courses;


	public function init()
	{
		parent::init();
		$this->courses = new Timetabling_Model_Courses($this->datasource, $this->logger);
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
		$xml = $this->courses->getCourses($this->year);
		$this->postprocess($xml);		
	}


	public function schoolAction()
	{		
		$this->preprocess();
		$xml = $this->courses->getCoursesBySchool($this->year, $this->guid);
		$this->postprocess($xml);	
	}


	public function schoolstaffAction()
	{
		$this->preprocess();
		$xml = $this->courses->getCoursesContributedToBySchoolStaff($this->year, $this->guid);
		$this->postprocess($xml);
	}
	
	
	public function studentsAction()
	{
		$this->preprocess();
		$xml = $this->courses->getCoursesStudents($this->year, $this->guid);
		$this->postprocess($xml);		
	}
	

}



