<?php

namespace CivAccess\Mapper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

use CivAccess\Acl\Rule;

class AclDbMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('CivAccess\DbAdapter');
        $mapper = new AclDbMapper();
        $mapper->setDbAdapter($dbAdapter);
        $mapper->setEntityPrototype(new Rule());
        $mapper->setHydrator(new ClassMethods());
        return $mapper;
    }   
}
