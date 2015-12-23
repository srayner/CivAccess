<?php

namespace CivAccess\Mapper;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZfcBase\Mapper\AbstractDbMapper;

class ResourceMapper extends AbstractDbMapper implements ResourceMapperInterface
{
    protected $tableName = 'access_resource';
    
    public function deleteResourceById($id)
    {
        return parent::delete(array('resource_id' => $id));
    }

    public function getResourceById($id)
    {
        $select = $this->getSelect()
                       ->where(array('resource_id' => $id));
        return $this->select($select)->current();
    }

    public function getResources()
    {
        $select = $this->getSelect();
        return $this->select($select);
    }

    public function persist($resource)
    {
        if ($resource->getResourceId() > 0) {
            $this->update($resource, null, null, new ClassMethods());
        } else {
            $this->insert($resource, null, new ClassMethods());
        }
        return $resource;
    }
    
    protected function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setResourceId($result->getGeneratedValue());
        return $result;
    }
    
    protected function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'resource_id = ' . $entity->getResourceId();
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }
}