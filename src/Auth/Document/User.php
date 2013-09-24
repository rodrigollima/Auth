<?php

namespace Auth\Document\User;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM(repositoryClass="Doctrine\Blog\ORM\UserRepository") */
class User
{
    /** @Id @Column(type="integer") */
    private $id;

    /** @Column(type="string") */
    private $username;

    /** @Column(type="text") */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }
}
    
    