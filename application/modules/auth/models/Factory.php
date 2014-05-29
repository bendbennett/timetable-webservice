<?php

class Auth_Model_Factory
{

	public static function createAuthModel($config, $logger)
	{
		$class = new Auth_Model_Authorisation($config, $logger);

		return $class;
	}

}

?>