<?php

class Timetabling_Model_Staff extends Timetabling_Model_Model
{
	private $server;
	
	public function __construct($retrieveData, $logger)
	{
		parent::__construct($retrieveData, $logger);
		$this->setCacheExpiryTime();
		
		$this->server = $_SERVER;
	}

	public function __set($name,$value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		return $this->$name;
	}

	public function getStaff($year)
	{
		$xml = $this->getData($year, 'getStaff');
		return $xml;
	}

	public function getStaffBySchool($year,$guid)
	{
		$xml = $this->getData($year, 'getStaffBySchool', $guid);
		return $xml;
	}

	public function getStaffForExchange($year, $apiKey)
	{
		$prependString = 'https://'.$this->server['SERVER_NAME'].substr($this->server["REQUEST_URI"], 0, strpos($this->server["REQUEST_URI"], $year)).$year.'/';
		$appendString = '?apiKey='.urlencode($apiKey);

		$xml = $this->getData($year, 'getStaffForExchange');
		$modifiedXml = $this->modifyXml($xml, 'calendarpath', $prependString, $appendString);

		return $modifiedXml;
	}

	private function modifyXml($xml, $nodeToUpdate, $prependString, $appendString)
	{
		$dom = new DOMDocument();
		$dom->loadXML($xml);

		$nodes = $dom->getElementsByTagName($nodeToUpdate);

		foreach ($nodes as $node)
		{
			$node->nodeValue = $prependString.$node->textContent.$appendString;
		}
	
		$modifiedXml = $dom->saveXML();
		
		return $modifiedXml;
	}
	
}


