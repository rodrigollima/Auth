<?php

namespace Auth\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class MongoAuthenticate implements AdapterInterface
{
    private $user;
    
    private $pass;

    private $dm;
    
    public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $dm) {
        $this->dm = $db;
    }
    
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }

    public function authenticate()
    {
        $user = $this->mongoConnection->findOne(
                    array("users.mail"    => $this->getUser(), 
                          "users.password" => $this->getPass(),
                          "users.isActive" => "1",
                         ),
                    array("users.mail.$" => 1)
                );
        
        if (null === $user) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null,  array());
        } else {
            return new Result(Result::SUCCESS, array('user'=>$user, ), array('OK'));
        }
        
    }
}
