<?php
class Plugin_AuthResponseHandler
{


	public static function arrayFromResponse($response, $contentType)
	{
		$contentType = strtolower($contentType);

		switch($contentType)
		{
			case "json":
				{
					return Zend_Json::decode($response);
					break;
				}
			case "xml":
				{
					$object = new SimpleXmlIterator($response);
						
					return self::objectToArray($object);
					break;
				}
			default:
				{
					return unserialize($response);
				}
		}
	}

	public static function buildResponseContentTypeHeader($contentType)
	{
		$header = array();
		$header["name"] = "content-type";
		switch (true)
		{
			case (strstr($contentType, 'application/json') || $contentType =='json'):
				$header["value"]='application/json';
				break;
			case (strstr($contentType, 'application/xml') || $contentType =='xml'):
				$header["value"]='application/xml';
				break;
			default:
				$header["value"]='text/plain';
				break;
		}

		return $header;

	}

	public static function encodeResponse($contentType,$response,$rootXmlNode="error")
	{
		$responseBody="";

		switch (true)
		{
			case (strstr($contentType, 'application/json') || $contentType =='json'):
				$responseBody=Zend_Json::encode($response);
				break;
			case (strstr($contentType, 'application/xml') || $contentType =='xml'):
				$dom = new DOMDocument('1.0', 'utf-8');
				$element = $dom->createElement($rootXmlNode,$response);
				$dom->appendChild($element);
				$xml = $dom->saveXML();
				$responseBody=$xml;
				break;
			default:
				$responseBody=$response;
				break;
		}
		return $responseBody;
	}

	public static function objectToArray($object)
	{
		$xml_array = array();

		for ($object->rewind(); $object->valid(); $object->next())
		{
			if(!array_key_exists($object->key(), $xml_array))
			{
				$xml_array[$object->key()] = array();
			}
				
			if($object->hasChildren())
			{
				$xml_array[$object->key()] = self::ObjectToArray($object->current());
			}
			else
			{
				$xml_array[$object->key()] = strval($object->current());
			}
		}

		return $xml_array;
	}

}