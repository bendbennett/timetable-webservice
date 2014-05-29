<?php
class Timetabling_Controller_Abstract extends Zend_Controller_Action{

	protected $config;
	protected $params;
	protected $datasource;
	protected $logger;
	protected $year;
	protected $xml;
	protected $guid;
	
	public function init()
	{
		$this->config = Zend_Registry::get('config');
		$this->params = $this->getHelper('ActionHelper');
		$this->year = $this->getRequest()->getParam('year');
		$this->logger = Zend_Registry::get('logger');
		$this->datasource = Timetabling_Model_Factory::createRetrieveData($this->config, $this->logger);
		$this->getHelper('viewRenderer')->setNoRender();
	}


	public function __set($name, $value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		return $this->$name;
	}
	public function checkParams(){
		//content-type might not be xml or json, need to trap for this
		$this->params->switchContext();
		//check year is an integer
		$this->params->checkYearIsNotNull($this->year);
		//check year is an integer
		$this->params->checkYearIsNumeric($this->year);
		//check year is in the valid yer list
		$this->params->checkYearValid($this->year,$this->datasource,$this->logger);
		
	}
	public function returnData(){
		//convert to json if appropriate
		$preparedData = $this->params->prepareData($this->xml);
		echo $preparedData;
	}
	public function guidCheck(){
		$this->guid = Zend_Controller_Action::_getParam('guid');
		//check guid is formatted correctly
		$this->params->checkGuidformat($this->guid);
	}
	
}