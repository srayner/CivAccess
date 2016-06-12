<?php

namespace CivAccess\Strategy;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DeniedStrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['CivAccess'];
        return new DeniedStrategy('error/403', $config['display_info']);        
    }

}

