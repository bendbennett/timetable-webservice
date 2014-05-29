<?php

/**
 * @abstract Class to define  .
 * @author shaunhare
 *
 * @version
 */
class Auth_Model_Authorisation extends Zend_Http_Client
{
	private $_config;
	private $_logger;
	private $_server;
    const MOBILE = 0;

	public function __construct($config, $logger)
	{
		$this->_config = $config;
		$this->_logger = $logger;
		$this->_server = $_SERVER;

		$this->setUri($config->authUrl);
	}


	public function __get($name)
	{
		return $this->$name;
	}


	public function __set($name, $value)
	{
		$this->$name = $value;
	}


	public function authorise($apiKey, $config, $contentType,$clientType=null)
	{

		if(is_null($clientType))
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }
        else
        {
            // this is for the DR room table feed as of 02.05.13 Shaun Hare
            if($clientType == Auth_Model_Authorisation::MOBILE)
            {
                $ip = sha1("mobile-".base64_decode($apiKey));
            }
        }
		$this->_logger->log('ip = '.$ip, Zend_Log::INFO);

		$this->setHeaders('Content-Type', $contentType);
		$this->setParameterGet('apiKey', $apiKey);

		$this->setParameterGet('consumer', $ip);
		$contentType = str_replace('application/', '', $contentType);
		$this->setParameterGet('format', $contentType);
		$response = $this->request();
		$httpCode = $response->extractCode($response);

		return array("httpCode"=>$httpCode,"response"=>$response->getBody());
	}
}