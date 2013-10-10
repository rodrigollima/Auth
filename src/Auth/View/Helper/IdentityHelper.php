<?php

namespace Auth\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\SessionManager;

class IdentityHelper extends AbstractHelper
{
    private $identity;
    
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) {
        $this->sessionManager = $sessionManager;
    }
    
    public function __invoke() {
        return $this;
    }
    
    public function getIdentity()
    {
        if ($this->identity === null) {
            $sessionStorage = new SessionStorage("Auth", null, $this->sessionManager);
            $this->identity = $sessionStorage->read();
             
        }
        return $this->identity;
    }
}
