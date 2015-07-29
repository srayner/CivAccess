<?php

namespace CivAccess\Guard;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GuardsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $guards = array(
            new Guard()
        );
       
        return $guards; 
    }

}
