<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ben
 * Date: 04/02/2013
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */
class Datasource_Biomedsci extends Datasource_RetrieveData
{

    public function __construct($config, $logger)
    {
        parent::__construct($config, $logger);

        $this->username = $config->database->biomedsci->username;
        $this->password = $config->database->biomedsci->password;
        $this->host = $config->database->biomedsci->host;
        $this->database = $config->database->biomedsci->database;
    }
}
