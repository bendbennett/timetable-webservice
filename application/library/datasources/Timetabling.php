<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ben
 * Date: 04/02/2013
 * Time: 14:35
 * To change this template use File | Settings | File Templates.
 */
class Datasource_Timetabling extends Datasource_RetrieveData
{

    public function __construct($config, $logger)
    {
        parent::__construct($config, $logger);

        $this->username = $config->database->timetabling->username;
        $this->password = $config->database->timetabling->password;
        $this->host = $config->database->timetabling->host;
        $this->database = $config->database->timetabling->database;
    }

}