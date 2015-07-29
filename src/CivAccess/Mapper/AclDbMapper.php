<?php

namespace CivAccess\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Adapter\Adapter;

class AclDbMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    protected $tableName = 'access_rule';
    
    public function getRulesForRole($role)
    {
        $select = $this->getSelect()
                       ->where(array('role' => $role));
        return $this->select($select);
    }
    
    public function setDbAdapter(Adapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
}

