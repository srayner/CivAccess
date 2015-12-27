<?php

namespace CivAccess\Form;

use Zend\InputFilter\InputFilter;

class PrivilegeInputFilter extends InputFilter
{
    public function __construct()
    {
        // Privilege
        $this->add(array(
            'name'       => 'privilege',
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

