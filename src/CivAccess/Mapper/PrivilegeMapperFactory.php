<?php

namespace CivAccess\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

use CivAccess\Acl\Privilege;

class PrivilegeMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('CivAccess\DbAdapter');
        $mapper = new PrivilegeMapper();
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype(new Privilege());
        $mapper->setHydrator(new ClassMethods());
        return $mapper;
    }   
}
