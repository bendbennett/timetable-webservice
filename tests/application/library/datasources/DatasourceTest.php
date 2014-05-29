<?php

/**
 * @group Unit
 * @group Datasource
 */

class DatasourceTest extends PHPUnit_Framework_TestCase
{
	private $config;
	private $mockedLogger;
	private $datasource;

	public function setUp()
	{
		$this->config = Zend_Registry::get('config');
		$this->mockedLogger = $this->getMock('Resource_Logger', array('log'));
		$this->datasource = new ConcreteDatasource($this->config, $this->mockedLogger);
	}

	public function testPrepareStoredProcedureAndArgs_returnsOnlyStoredProcedureNamePrefixedWithExecWhenYearAndArgsAreNull()
	{
		$storedProcCommand = $this->datasource->prepareStoredProcedureAndArgs(null, 'storedProcName', null);
		
		$this->assertEquals('EXEC storedProcName', trim($storedProcCommand));
	}

    public function testPrepareStoredProcedureAndArgs_returnsStoredProcedureNamePrefixedWithExecAndSuffixedWithYearAndArgs()
    {
        $storedProcCommand = $this->datasource->prepareStoredProcedureAndArgs(2012, 'storedProcName', array('A1B2C3D4'));

        $this->assertEquals("EXEC storedProcName 2012,'A1B2C3D4'", trim($storedProcCommand));
    }

    public function testPrepareSqlQueryAndArgs_returnsAppropriatelySubstituedString()
    {
        $unpopulatedSqlQuery = $this->datasource->queryForTest;
        $args = array('blah|car|star');

        $sqlQuery = $this->datasource->prepareSqlQueryAndArgs($unpopulatedSqlQuery, $args);

        $this->assertEquals('SELECT blah FROM car WHERE star', $sqlQuery);
    }
}