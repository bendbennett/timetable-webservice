<?php

class ErrorController extends Zend_Controller_Action
{
	private $params;


	public function errorAction()
	{
		$this->params = $this->getHelper('ActionHelper');
		$logger = Zend_Registry::get('logger');
		$message = "";
		
		try
		{
			$this->params->switchContext();
		}
		catch (Exception $exception)
		{
			$message = ' - undefined content-type set: must be application/xml or application/json';
			$logger->log($message, Zend_Log::ERR);			
		}
		
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);

		$errors = $this->_getParam('error_handler');

		if (!$errors)
		{
			if ($this->getResponse()->getBody() == '')
			{
				$error = "<error>There has been an error</error>";
				$error = $this->params->prepareData($error);
				print $error;
			}
			return;
		}

		switch ($errors->type)
		{
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$error =  "<error>Page not found</error>";
				//convert to json if appropriate
				$error = $this->params->prepareData($error);
				print $error;
				break;
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER:
				// 404 error -- controller or action not found
				$this->getResponse()->setHttpResponseCode(404);
				$error = "<error>There has been an error".$message."</error>";
				$error = $this->params->prepareData($error);
				print $error;
				break;
			default:
				// application error
				$this->getResponse()->setHttpResponseCode(500);
				break;
		}

		if ($errors)
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

			$logger->log($errors->exception->getMessage().", IP = ".$ip, Zend_Log::ERR);
		}
	}

}

