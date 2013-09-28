<?php

namespace Auth\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class MongoAuthenticate implements AdapterInterface
{
    private $username;
    
    private $password;

    private $dm;
    
    
    public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $dm) {
        $this->dm = $dm;
    }
    
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function authenticate()
    {
        $user = $this->dm->getRepository('Auth\Document\User');
        $user = $user->authenticate($this->getUsername(), $this->getPassword());
        
        if (null === $user) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null,  array());
        } else {
            return new Result(Result::SUCCESS, array('user'=>$user, ), array('OK'));
        }
        
    }
}
