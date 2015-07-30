<?php

namespace CivAccess\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Adapter\Adapter;

class RuleMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    protected $tableName = 'access_rule';
    
    public function getRules()
    {
        $select = $this->getSelect();
        return $this->select($select);
    }
    
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