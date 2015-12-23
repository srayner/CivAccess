<?php

namespace CivAccess\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

class RoleMapper extends AbstractDbMapper implements RoleMapperInterface
{
    protected $tableName = 'access_role';
    
    public function getRoles($where = null)
    {
        $select = $this->getSelect();
        if (null != $where){
            $select->where($where);
        }
        return $this->select($select);
    }
    
    public function getRoleById($roleId)
    {
        $select = $this->getSelect()
                       ->where(array('role_id' => $roleId));
        return $this->select($select)->current();
    }
    
    public function persist($role)
    {
        if ($role->getRoleId() > 0) {
            $this->update($role, null, null, new ClassMethods());
        } else {
            $this->insert($role, null, new ClassMethods());
        }
        return $role; 
    }
    
    public function deleteRoleById($roleId)
    {
        parent::delete(array('role_id' => $roleId));
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
        return $result;
    }
    
    protected function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'role_id = ' . $entity->getRoleId();
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }
}