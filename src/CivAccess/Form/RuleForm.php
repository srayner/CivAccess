<?php

namespace CivAccess\Form;

use Zend\Form\Form;

class RuleForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        
        // Rule Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'rule_id',
        ));
        
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
        
        // Resource
        $this->add(array(
            'name' => 'resource',
            'options' => array(
                'label' => 'Resource',
            ),
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control input-sm'
            ), 
        ));
        
        // Privilege
        $this->add(array(
            'name' => 'priviledge',
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
}