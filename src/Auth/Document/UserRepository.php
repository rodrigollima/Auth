<?php

namespace Auth\Document;

use \Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository {
    
    public function authenticate($username, $password)
    {
        return $this->findOneBy(array('username' => $username, 'password' => $password));
    }
    
}