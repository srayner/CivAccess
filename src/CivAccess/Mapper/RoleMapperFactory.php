<?php

namespace CivAccess\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

use CivAccess\Acl\Role;

class RoleMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('CivAccess\DbAdapter');
        $mapper = new RoleMapper();
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype(new Role());
        $mapper->setHydrator(new ClassMethods());
        return $mapper;
    }   
}