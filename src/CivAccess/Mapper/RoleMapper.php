<?php

namespace CivAccess\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Stdlib\Hydrator\HydratorInterface;

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
    
    public function persistRole($role)
    {
        $this->insert($role, null, null);
    }
    
    /**
     * @param object|array $entity
     * @param string|TableIdentifier|null $tableName
     * @param HydratorInterface|null $hydrator
     * @return ResultInterface
     */
    protected function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setCustomerId($result->getGeneratedValue());
        return $result;
    }
}