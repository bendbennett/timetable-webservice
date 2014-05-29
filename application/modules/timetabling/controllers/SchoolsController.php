<?php

class SchoolsController extends Controller_Controller
{
	private $schools;


	public function init()
	{
		parent::init();
		$this->schools = new Timetabling_Model_Schools($this->datasource, $this->logger);
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
		$xml = $this->schools->getSchools($this->year);
		$this->postprocess($xml);
	}


}
