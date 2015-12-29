<?php

namespace CivAccess\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class RuleForm extends Form
{
    private $serviceLocator;
    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct();
        
        $this->serviceManager = $serviceLocator;
        $this->addElements();
    }
    
    private function addElements()
    {
        // Rule Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'rule_id',
        ));
        
        // Role
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'role',
            'options' => array(
                'label' => 'Role',
                'options' => $this->getRolesArray()
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            ), 
        ));
        
        // Resource
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'resource',
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
        
        // Submit button.
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add',
                'id'    => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
    }
    
    private function getRolesArray()
    {
        $roles = $this->serviceManager->get('CivAccess\AclService')->getRoles();
        $result = array();
        foreach($roles as $role) {
            $result[$role->getRole()] = $role->getRole();
        }
        return $result;
    }
    
    private function getResourcesArray()
    {
        $resources = $this->serviceManager->get('CivAccess\AclService')->getResources();
        $result = array();
        foreach($resources as $resource) {
            $result[$resource->getResource()] = $resource->getDisplayName();
        }
        return $result;
    }
}