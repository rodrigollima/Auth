<?php

namespace Auth\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter 
{
    public function __construct()
    {
        $this->add(array(
           'name' => 'mail',
           'required' => true,
           'filters' => array(
               array('name' => 'StripTags'),
               array('name' => 'StringTrim'),
           ),
        ));
        
        $this->add(array(
           'name' => 'password',
           'required' => true,
           'filters' => array(
               array('name' => 'StripTags'),
               array('name' => 'StringTrim'),
           ),
            
        ));
        
        $this->add(array(
           'name' => 'remember',
           'required' => false,
           'filters' => array(
               array('name' => 'StripTags'),
               array('name' => 'StringTrim'),
           ),
        ));
        
        $this->add(array(
            'name' => 'csrf',
            'required' => true,
            'filters' => array(
               array('name' => 'StripTags'),
               array('name' => 'StringTrim'),
           ),
        ));
    }
}
