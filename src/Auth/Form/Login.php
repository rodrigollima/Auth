<?php

namespace Auth\Form;

use Zend\Form\Form;
use Auth\Form\LoginFilter;

class Login extends Form
{
    public function __construct($name = null, $options = array()) {
        parent::__construct('login_form');
        
        $this->setInputFilter(new LoginFilter());
        
        $this->add(array(
           'name' => 'username',
           'attributes' => array(
               'type' => 'text',
               'placeholder' => 'usuario@seuemail.com',
               'class' => 'input-block-level'
           ),
           'options' => array(
               'label' => 'Email'    
           ),
        ));
        
        $this->add(array(
           'name' => 'password',
           'attributes' => array(
               'type' => 'password',
               'placeholder' => '********',
               'class' => 'input-block-level'
           ),
           'options' => array(
               'label' => 'Senha'
           )
        ));
        
        $this->add(array(
           'name' => 'submit',
           'attributes' => array(
               'type' => 'submit',
               'value' => 'Entrar Agora',
               'class' => 'btn btn-primary',
           )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));
    }
}