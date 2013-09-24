<?php

namespace Auth\Document;

use \Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository {
    
    public function authenticate($username, $password)
    {
        $user = $this->find("5241f1ad024bf9134b9736f3");
        var_dump($user);exit;
        //return $this->findOneBy(array(, 'password' => $password));
    }
    
}