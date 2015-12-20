<?php

namespace CivAccess\Form;

use Zend\InputFilter\InputFilter;

class RoleInputFilter extends InputFilter
{
    public function __construct()
    {
        // Role
        $this->add(array(
            'name'       => 'role',
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
        
        // Parent
        $this->add(array(
            'name'       => 'parent',
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