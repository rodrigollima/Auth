<?php

namespace Auth\Document;
    
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Math\Rand;

/** @ODM\Document(collection="users", repositoryClass="Auth\Document\UserRepository") */
class User
{
    /** @ODM\Id */
    private $id;
    
    /** @ODM\Field(type="string") */
    private $name;
    
    /** @ODM\Field(type="string") */
    private $displayName;
    
    /** @ODM\Field(type="string") */
    private $mail;
    
    /** @ODM\Field(type="string") */
    private $username;

    /** @ODM\Field(type="string") */
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
        return $this;
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

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = self::encodePassword($password);
        return $this;
    }
    
    public static function encodePassword($password)
    {
        $salt = Rand::getBytes(strlen($password), true);
        $hash = Pbkdf2::calc('sha256', $password, $salt, 10000, strlen($password)*2);
        
        return $hash;
    }
    
    
    public function toArray() 
    {
        return array(
            'id'          => $this->getId(),
            'name'        => $this->getName(),
            'displayName' => $this->getDisplayName(),
            'mail'        => $this->getMail(),
            'username'    => $this->getUsername(),
            'password'    => $this->getPassword(),
        );
    }
}
    
    