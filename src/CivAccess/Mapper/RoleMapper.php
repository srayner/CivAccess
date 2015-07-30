<?php

namespace CivAccess\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Adapter\Adapter;

class RoleMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    protected $tableName = 'access_role';
    
    public function getRoles()
    {
        $select = $this->getSelect()
                       ->order(array('priority', 'role'));
        return $this->select($select);
    }
    
    public function setDbAdapter(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
}