<?php

class Timetabling_Model_Schools extends Timetabling_Model_Model
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

	public function getSchools($year)
	{
		$xml = $this->getData($year, 'getSchools');
		return $xml;
	}

}

