<?php

abstract class Controller_Controller extends Zend_Controller_Action
{
	protected $config;
	protected $params;
	protected $year;
	protected $guid;
	protected $datasource;
	protected $logger;
	protected $yearsModel;
	protected $yearsXml;


    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public function __get($name)
    {
        return $this->$name;
    }


	public function init()
	{
		$this->config = Zend_Registry::get('config');
		$this->params = $this->getHelper('ActionHelper');
		//year might not be set in request, need to trap for this
		$this->year = $this->getRequest()->getParam('year');
		//need to use a factory for this and then return a mocked object for testing
		//this should be in action() below - create factory and drop in
		$this->logger = Zend_Registry::get('logger');
		$this->datasource = Timetabling_Model_Factory::createRetrieveData($this->config, $this->logger);
		$this->yearsModel = Timetabling_Model_Factory::createYearsModel($this->datasource, $this->logger);
		$this->yearsXml = $this->yearsModel->getYears();
		$this->getHelper('viewRenderer')->setNoRender();
	}


	protected function preprocess($prepareYear=true, $prepareGuid=true)
	{
		$this->params->switchContext();

		if ($prepareYear)
		{
			$this->params->checkYearIsNotNull($this->year);
			//check year is an integer
			$this->params->checkYearIsNumeric($this->year);
			//check year is in the valid year list
			$this->params->checkYearValid($this->year, $this->yearsXml);
		}

		if ($prepareGuid)
		{
			//year might not be set in request, need to trap for this
			$this->guid = Zend_Controller_Action::_getParam('guid');
			//check guid is formatted correctly
			$this->params->checkGuidFormat($this->guid);
		}
	}


	protected function postprocess($xml)
	{
		//convert to json if appropriate
		$preparedData = $this->params->prepareData($xml);
		echo $preparedData;
	}

}