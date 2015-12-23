<?php

namespace CivAccess\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

use CivAccess\Acl\Resource;

class ResourceMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('CivAccess\DbAdapter');
        $mapper = new ResourceMapper();
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype(new Resource());
        $mapper->setHydrator(new ClassMethods());
        return $mapper;
    }   
}