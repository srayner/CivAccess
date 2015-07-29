<?php

namespace CivAccess\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class AclDbMapper extends AbstractDbMapper implements DbAdapterAwareInterface
{
    protected $tableName = 'acl';
    
    public function getRulesForRole($role)
    {
        $select = $this->getSelect()
                       ->where(array('role' => $role));
        return $this->select($select);
    }
}

