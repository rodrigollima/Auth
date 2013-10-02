<?php

namespace Auth\Document;

use \Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository {
    
    public function authenticate($username, $password)
    {
        
        $password = User::encodePassword($password);
        
        return $this->findOneBy(array('username' => $username, 'password' => $password));
    }
    
}