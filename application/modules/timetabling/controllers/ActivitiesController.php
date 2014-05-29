<?php

class ActivitiesController extends Controller_Controller
{

	private $activities;


	public function init()
	{
		parent::init();
		$this->activities = new Timetabling_Model_Activities($this->datasource, $this->logger);
	}


	public function __set($name, $value)
	{
		$this->$name = $value;
	}


	public function __get($name)
	{
		return $this->$name;
	}


	public function schoolmodulesAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesForModulesAdministeredBySchool($this->year, $this->guid);
		$this->postprocess($xml);
	}


	public function schoolstaffAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesContributedToBySchoolStaff($this->year, $this->guid);
		$this->postprocess($xml);
	}


	public function courseAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesByCourse($this->year, $this->guid);
		$this->postprocess($xml);
	}


	public function moduleAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesByModule($this->year, $this->guid);
		$this->postprocess($xml);
	}


	public function staffAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesByStaff($this->year, $this->guid);
		$this->postprocess($xml);
	}


	public function staffexchangeAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesForStaffExchange($this->year, $this->guid);
		$this->postprocess($xml);
	}


	public function studentAction()
	{
		$this->preprocess();
		$xml = $this->activities->getActivitiesByStudent($this->year, $this->guid);
		$this->postprocess($xml);
	}

}











