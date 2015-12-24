<?php

namespace CivAccess\Form;

use Zend\Form\Form;

class ResourceForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        
        // Resource Id
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'resource_id',
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
                'class' => 'btn btn-primary'
            ),
        ));
    }
}