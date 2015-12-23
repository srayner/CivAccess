<?php

namespace CivAccess\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

class PrivilegeMapper extends AbstractDbMapper implements PrivilegeMapperInterface
{
    protected $tableName = 'access_privilege';
    
    public function deletePrivilegeById($id)
    {
        return parent::delete(array('privilege_id' => $id));
    }

    public function getPrivilegeById($id)
    {
        $select = $this->getSelect()
                       ->where(array('privilege_id' => $id));
        return $this->select($select)->current();
    }

    public function getPrivileges()
    {
        $select = $this->getSelect();
        return $this->select($select);
    }

    public function persist($privilege)
    {
        if ($privilege->getPrivilegeId() > 0) {
            $this->update($privilege, null, null, new ClassMethods());
        } else {
            $this->insert($privilege, null, new ClassMethods());
        }
        return $privilege;
    }
    
    protected function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setPrivilegeId($result->getGeneratedValue());
        return $result;
    }
    
    protected function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'privilege_id = ' . $entity->getPrivilegeId();
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }
}