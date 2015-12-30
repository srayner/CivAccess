<?php

namespace CivAccess\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class RoleFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new RoleForm($serviceLocator);
        $inputFilter = new RoleInputFilter();
        $form->setHydrator(new ClassMethods)
             ->setInputFilter($inputFilter);
        return $form; 
    }
}