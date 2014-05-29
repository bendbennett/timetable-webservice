<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ben
 * Date: 06/02/2013
 * Time: 10:53
 * To change this template use File | Settings | File Templates.
 */
class ConcreteDatasource extends Datasource_RetrieveData
{
    public $queryForTest = 'SELECT %s FROM %s WHERE %s';
}
