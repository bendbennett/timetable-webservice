<?php

class StaffController extends Controller_Controller
{
	private $staff;


	public function init()
	{
		parent::init();
		$this->staff = new Timetabling_Model_Staff($this->datasource, $this->logger);
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
		$xml = $this->staff->getStaff($this->year);
		$this->postprocess($xml);
	}


	public function schoolAction()
	{
		$this->preprocess();
		$xml = $this->staff->getStaffBySchool($this->year, $this->guid);
		$this->postprocess($xml);
	}
	
	
	public function exchangeAction()
	{
		$this->preprocess(true, false);
		$xml = $this->staff->getStaffForExchange($this->year, $this->getRequest()->getParam('apiKey'));
		$this->postprocess($xml);		
	}

}



