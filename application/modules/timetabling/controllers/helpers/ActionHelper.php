<?php

class Helper_ActionHelper extends Zend_Controller_Action_Helper_Abstract
{
    private $request;
    private $response;
    private $contentType;


    public function __construct()
    {
        $this->request = $this->getRequest();
        $this->response = $this->getResponse();
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function checkYearIsNotNull($year)
    {
        if (is_null($year) || strlen(trim($year)) != 4) {
            throw new Exception('The year is null, an empty string or contains only whitespace');
        }
    }

    //guid format is pipe ("|") separated capitalised alphanumermics (e.g., FD8DCCC4E0CC813F3522E0C30F3D54C3 or FD8DCCC4E0CC813F3522E0C30F3D54C3|72BF12E3439F31501D207AE85C84E4D5)
    public function checkGuidFormat($guid)
    {
        if (is_null($guid) || trim($guid) == '') {
            throw new Exception('Guid is null or an empty/whitespace string');
        }

        if (preg_match('/[^A-Z0-9|]+/', $guid) > 0) {
            throw new Exception('The guid is malformed, only uppercase A-Z, 0-9 and pipe (|) allowed - [' . $guid . ']');
        }
    }

    public function checkYearIsNumeric($year)
    {
        if (!is_numeric($year)) {
            throw new Exception('The year is not an integer - [' . $year . ']');
        }
    }

    public function checkYearValid($year, $yearsXml)
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->loadXML($yearsXml);
        $xpathObject = new DOMXPath($dom);
        $domNodeList = $xpathObject->query('/Years/Year');
        $yearsList = '';

        if ($domNodeList->length > 0) {
            foreach ($domNodeList AS $yearNode) {
                $yearsList .= $yearNode->nodeValue . ' ';

                if ($yearNode->nodeValue == $year) {
                    return true;
                }
            }

            throw new Exception('The year is not valid  [' . $year . '] not in [' . trim($yearsList) . ']');
        }
    }

    public function switchContext()
    {
        //20-03-2013 defaulting to using application/xml even if no Content-Type is set
        //throw an exception if Content-Type is set and is not application/xml or application/json
        $this->contentType = $this->request->getHeader('Content-Type');

        // If the content type is empty and if not present default to xml

        if (strlen($this->contentType) == 0) {

            //01-05-2013 check if format set as queryparam - decided on this rather than ext as easy to sort Shaun :-)
            $params = $this->request->getParams();

            if (isset($params["format"])) {
                $this->contentType = "application/" . $params["format"];
            } else {
                $this->contentType = "application/xml";
            }
        }

        if (stristr($this->contentType, "application/xml")) {


            $this->response->setHeader('Content-type', 'application/xml');


        } elseif (stristr($this->contentType, "application/json")) {
            $this->response->setHeader('Content-type', 'application/json');
        } else {
            throw new Exception('unacceptable content-type set: Must be application/xml, application/json');
        }
    }


    public function prepareData($xml)
    {
        if (!stristr($this->contentType, "application/json")) return $xml;

        $jsonContents = Zend_Json::fromXml($xml, true);

        return $jsonContents;
    }

}