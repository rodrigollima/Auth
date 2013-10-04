<?php

namespace Auth\Document;

use \Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository {
    
    public function authenticate($username, $password)
    {
        $user = $this->findOneBy(array('username' => $username));
        if ($user) {
            if (User::checkPassword($password, $user->getPassword())) {
                return $user;
            }
        }
        
        return null;
    }
    
}