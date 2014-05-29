<?php

class Plugin_AuthPlugin extends Zend_Controller_Plugin_Abstract
{

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$params = $this->getRequest()->getParams();
		$namespace = new Zend_Session_Namespace();
		$request = $this->getRequest();
		$contentType = $request->getHeader('Content-Type');

		if (!isset($params['apiKey']))
		{
			$rawbody = "UnAuthorised no apiKey";

			$this->getResponse()->setHttpResponseCode(401);

			$header = Plugin_AuthResponseHandler::buildResponseContentTypeHeader($contentType);
			$this->getResponse()->setHeader("content-type", $header["value"]);
			$body = Plugin_AuthResponseHandler::encodeResponse($contentType, $rawbody);
			$this->getResponse()->appendBody($body);

			$request->setModuleName('default');
			$request->setControllerName('Error');
			$request->setActionName('error');

			return;
		}

		if(!$namespace->$params["apiKey"])
		{
			$config = Zend_Registry::get('config');
			$logger = Zend_Registry::get('logger');
			$auth = Auth_Model_Factory::createAuthModel($config, $logger);

            /**
             * additional conditions for mobile client
             * Added by Shaun Hare 01.05.2013
             */
            if(isset($params["mc"]) && $params["mc"]==true)
            {
               //restrict to only requests for table-assignment endpoints 
                if($request->getActionName() == "moduletableassignment")
                {

                    $encodedUUID = base64_encode($params["apiKey"]);
                    $contentType = "application/".isset($params["format"])? $params["format"]:"xml"; //check and fallback to xml(the default) if not set
                    $authResponse = $auth->authorise($encodedUUID,$config,$contentType,0);
                }
                else
                {
                    $authResponse["httpCode"] = 401;
                    $authResponse["response"] = "unauthorised";
                }
            }
            else
            {
                $authResponse = $auth->authorise($params["apiKey"], $config, $contentType);
            }

			$httpCode = $authResponse["httpCode"];
			$httpResponse = $authResponse["response"];


			if($httpCode != 200)
			{
				$rawbody = "UnAuthorised";

				$this->getResponse()->setHttpResponseCode(401);

				$header = Plugin_AuthResponseHandler::buildResponseContentTypeHeader($contentType);
				$this->getResponse()->setHeader("content-type", $header["value"]);
				$body = Plugin_AuthResponseHandler::encodeResponse($contentType, $rawbody);
				$this->getResponse()->appendBody($body);

				$request->setModuleName('default');
				$request->setControllerName('Error');
				$request->setActionName('error');
			}
			else
			{
				$contentType = str_ireplace('application/', '', $contentType);
				$namespace->$params['apiKey'] = $params["apiKey"] ;
			}
		}
	}

}

