<?php

class YearsController extends Controller_Controller
{
	private $years;
	
	
	public function init()
	{
		parent::init();
		$this->years = new Timetabling_Model_Years($this->datasource, $this->logger);
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
		$this->preprocess(false, false);
		$xml = $this->years->getYears();
		$this->postprocess($xml);
	}


}
