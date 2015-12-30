<?php

namespace CivAccess\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleForm extends Form
{
    private $serviceLocator;
    
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        parent::__construct();
        
        $this->serviceLocator = $serviceLocator;
        
        // Role
        $this->add(array(
            'name' => 'role',
            'options' => array(
                'label' => 'Role',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control input-sm'
            ), 
        ));
        
        // Parent
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'parent',
            'options' => array(
                'label' => 'Inherits From',
                'options' => $this->getRolesArray()
            ),
            'attributes' => array(
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
    
    private function getRolesArray()
    {
        $roles = $this->serviceLocator->get('CivAccess\AclService')->getRoles();
        $result = array();
        foreach($roles as $role) {
            $result[$role->getRole()] = $role->getRole();
        }
        return $result;
    }
}
