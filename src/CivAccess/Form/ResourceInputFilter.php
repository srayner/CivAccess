<?php

namespace CivAccess\Form;

use Zend\InputFilter\InputFilter;

class ResourceInputFilter extends InputFilter
{
    public function __construct()
    {
        // Resource
        $this->add(array(
            'name'       => 'resource',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max' => 128,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        
        // Display Name
        $this->add(array(
            'name'       => 'display_name',
            'required'   => true,
            'validators' => array(
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'max' => 64,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));
        
    }
}

