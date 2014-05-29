<?php

abstract class Timetabling_Model_Abstract
{
	private $cache;

	protected function setCacheExpiryTime()
	{
		$dayAdvance = 0;

		if (date("G", time()) > 3)
		{
			$dayAdvance = 1;
		}

		$expiryTime = mktime(4, 0, 0, date("m"), date("d") + $dayAdvance, date("Y"));

		$currentTime = time();
		$numberOfSecondsUntilExpiry = $expiryTime - $currentTime;

		$this->cache = Zend_Registry::get('cache');
		$this->cache->setLifetime($numberOfSecondsUntilExpiry);
	}

	protected function getData($year, $dataCall, $guid=null)
	{
		$xml = "";
		$args = null;
		$guidForQuery = $guid;

		if (!is_null($guid))
		{
			$guidForQuery = preg_replace('/[^A-Z0-9|]+/', "", $guid);
			$args = array($guidForQuery);
		}

		$guidForCache = str_replace('|', '_', $guidForQuery);

		if (!$xml = $this->cache->load($dataCall.$year.$guidForCache))
		{
			$xml = $this->retrieveData->getData($year, $dataCall, $args);
			$this->cache->save($xml, $dataCall.$year.$guidForCache);
		}

		return $xml;
	}

}