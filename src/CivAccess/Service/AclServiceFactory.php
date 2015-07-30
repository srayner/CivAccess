<?php

namespace CivAccess\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $roleMapper = $serviceLocator->get('CivAccess\RoleMapper');
        $ruleMapper = $serviceLocator->get('CivAccess\RuleMapper');
        return new AclService($roleMapper, $ruleMapper);    
    }
}