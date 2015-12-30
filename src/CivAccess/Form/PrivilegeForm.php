<?php

namespace CivAccess\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class PrivilegeForm extends Form
{
    private $serviceManager;
    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct();
        
        $this->serviceManager = $serviceLocator;
        $this->addElements();
    }
    
    private function addElements()
    {
        // Privilege Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'privilege_id',
        ));
        
        // Resource Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'resource_id',
            'options' => array(
                'label' => 'Resource',
                'options' => $this->getResourcesArray()
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ), 
        ));
        
        // Privilege
        $this->add(array(
            'name' => 'privilege',
            'options' => array(
                'label' => 'Privilege',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control input-sm'
            ), 
        ));
        
        // Display Name
        $this->add(array(
            'name' => 'display_name',
            'options' => array(
                'label' => 'Display Name',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control input-sm'
            ), 
        ));
        
        // Submit button.
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id'    => 'submitbutton',
                'class' => 'btn btn-sm btn-primary'
            ),
        ));
    }
    
    private function getResourcesArray()
    {
        $resources = $this->serviceManager->get('CivAccess\AclService')->getResources();
        $result = array();
        foreach($resources as $resource) {
            $result[$resource->getResourceId()] = $resource->getDisplayName();
        }
        return $result;
    }
}