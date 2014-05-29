<?php

abstract class Datasource_RetrieveData
{
    protected $config;
    protected $logger;
    protected $username;
    protected $password;
    protected $host;
    protected $database;
    protected $linkIdentifier;
    protected $storedProcedureMap;


    public function __construct($config, $logger)
    {
        $this->config = $config;
        $this->logger = $logger;

        $this->storedProcedureMap = $config->storedProcedureMap;
    }

    protected function openConnection()
    {
        $this->linkIdentifier = mssql_connect($this->host, $this->username, $this->password);
        mssql_select_db($this->database, $this->linkIdentifier);
    }

    protected function query($query)
    {
        $xml = '';
        $result = mssql_query($query);

        while ($row = mssql_fetch_array($result, MSSQL_ASSOC))
        {
            foreach ($row as $key => $value)
            {
                $xml .= $value;
            }
        }

        return $xml;
    }

    protected function runQuery($queryToExecute)
    {
        $this->openConnection();
        $dataArray = $this->query($queryToExecute);

        if (empty($dataArray))
        {
            $this->logger->log("No Data in $queryToExecute " . __METHOD__ . " in " . __CLASS__, Zend_Log::ERR);
            throw new Exception("No Data in $queryToExecute " . __METHOD__ . " in " . __CLASS__);
        }

        $this->closeConnection();

        return $dataArray;
    }

    public function getData($year, $methodName, $args = null)
    {
        $storedProcedure = $this->storedProcedureMap->$methodName;
        $queryToExecute = '';

        if (!is_null($storedProcedure))
        {
            $queryToExecute = $this->prepareStoredProcedureAndArgs($year, $storedProcedure, $args);
        }
        else
        {
            $queryToExecute = $this->prepareSqlQueryAndArgs($this->$methodName, $args);
        }

        return $this->runQuery($queryToExecute);

    }

    public function prepareStoredProcedureAndArgs($year, $storedProcedureName, $storedProcedureArgs = null)
    {
        if (!is_null($storedProcedureName))
        {
            $storedProcCommand = "EXEC " . $storedProcedureName;

            if (is_array($storedProcedureArgs) && !empty($storedProcedureArgs))
            {
                foreach ($storedProcedureArgs as $arg => $argValue)
                {
                    if (is_string($argValue))
                    {
                        $storedProcedureArgs[$arg] = "'" . $argValue . "'";
                    }
                }

                return $storedProcCommand . " " . $year . ',' . implode(",", $storedProcedureArgs);
            }
            else
            {
                return $storedProcCommand . " " . $year;
            }
        }
    }

    public function prepareSqlQueryAndArgs($methodName, $args)
    {
        $argsArray = explode('|', $args[0]);
        $query = vsprintf($methodName, $argsArray);

        return $query;
    }

    protected function closeConnection()
    {
        mssql_close($this->linkIdentifier);
    }
}