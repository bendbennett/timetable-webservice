<?php

class Timetabling_Model_Factory
{

	public static function createRetrieveData($config, $logger)
	{
		$class = new Datasource_Timetabling($config, $logger);

		return $class;
	}
	
	public static function createYearsModel($retrieveData, $logger)
	{
		$class = new Timetabling_Model_Years($retrieveData, $logger);
		
		return $class;
	}

    public static function createBiomedsciDatasource($config, $logger)
    {
        $class = new Datasource_Biomedsci($config, $logger);

        return $class;
    }

}

?>