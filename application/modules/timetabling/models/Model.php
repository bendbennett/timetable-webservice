<?php

abstract class Timetabling_Model_Model
{
    protected $logger;
    protected $retrieveData;
    protected $cache;
    protected $guid;
    protected $args;
    protected $guidForQuery;
    protected $guidForCache;

    protected function __construct($retrieveData, $logger)
    {
        $this->logger = $logger;
        $this->retrieveData = $retrieveData;
        $this->cache = Zend_Registry::get('cache');
        $this->args = null;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    protected function setCacheExpiryTime()
    {
        $dayAdvance = 0;

        if (date("G", time()) > 1)
        {
            $dayAdvance = 1;
        }

        $expiryTime = mktime(2, 0, 0, date("m"), date("d") + $dayAdvance, date("Y"));

        $currentTime = time();
        $numberOfSecondsUntilExpiry = $expiryTime - $currentTime;

        $this->cache->setLifetime($numberOfSecondsUntilExpiry);
    }

    protected function checkGuidForInvalidCharacters()
    {
        if (!is_null($this->guid))
        {
            if (preg_match('/[^A-Z0-9|]+/', $this->guid) > 0)
            {
                throw new Exception("Guid contains characters other than uppercase A-Z, 0-9 or pipe (|) - [$this->guid]");
            }

            $this->guidForQuery = preg_replace('/[^A-Z0-9|]+/', "", $this->guid);
            $this->args = array($this->guidForQuery);
        }
    }

    protected function getData($year, $dataCall, $guid = null)
    {
        $xml = "";

        $this->guid = $guid;
        $this->args = null;
        $this->guidForQuery = $guid;

        $this->checkGuidForInvalidCharacters();

        $guidForCache = Resource_Cache::makeKey($this->guidForQuery);

        if (!$xml = $this->cache->load($dataCall . $year . $guidForCache))
        {
            $xml = $this->retrieveData->getData($year, $dataCall, $this->args);
            $this->cache->save($xml, $dataCall . $year . $guidForCache);
        }

        return $xml;
    }

}