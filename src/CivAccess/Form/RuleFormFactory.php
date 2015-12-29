<?php

namespace CivAccess\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class RuleFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new RuleForm($serviceLocator);
        $inputFilter = new RuleInputFilter();
        $form->setHydrator(new ClassMethods)
             ->setInputFilter($inputFilter);
        return $form; 
    }
}