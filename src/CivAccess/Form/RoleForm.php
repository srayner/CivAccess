<?php

namespace CivAccess\Form;

use Zend\Form\Form;

class RoleForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        
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
            'name' => 'parent',
            'options' => array(
                'label' => 'Inherits From',
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
}
