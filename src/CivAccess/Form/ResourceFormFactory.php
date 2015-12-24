<?php

namespace CivAccess\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ResourceFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new ResourceForm();
        $inputFilter = new ResourceInputFilter();
        $form->setHydrator(new ClassMethods)
             ->setInputFilter($inputFilter);
        return $form; 
    }
}