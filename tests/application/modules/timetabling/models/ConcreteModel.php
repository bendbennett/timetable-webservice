<?php


class ConcreteModel extends Timetabling_Model_Model
{
	public function __construct($retrieveData, $logger)
	{
		parent::__construct($retrieveData, $logger);
	}
	
	public function setCacheExpiryTime()
	{
		parent::setCacheExpiryTime();
	}

    public function checkGuidForInvalidCharacters()
    {
        parent::checkGuidForInvalidCharacters();
    }
}