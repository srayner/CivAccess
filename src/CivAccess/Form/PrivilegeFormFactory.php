<?php

namespace CivAccess\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class PrivilegeFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new PrivilegeForm($serviceLocator);
        $inputFilter = new PrivilegeInputFilter();
        $form->setHydrator(new ClassMethods)
             ->setInputFilter($inputFilter);
        return $form; 
    }
}