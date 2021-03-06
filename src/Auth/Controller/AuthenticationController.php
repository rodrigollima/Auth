<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Auth\Form\Login as FrmLogin;

class AuthenticationController extends AbstractActionController
{
    /**
     * @var \Doctrine\ODM\DocumentManager
     */
    private $dm;
    
    /** @var string */
    private $defaultRoute = 'dashboard';
    
    public function loginAction()
    {
        $form = new FrmLogin();
        $request = $this->getRequest();
        
        if ($request->isPost()){
            //Pega os dados enviados via $_POST
            $data = $request->getPost()->toArray();
            //Preenche o Form com os dados
            $form->setData($data);
            //Verifica se o form é válido
            if ($form->isValid()) {
                //Pego o servico adapter do Auth
                $authAdapter = $this->getServiceLocator()->get('Auth\Adapter\Authentication');
                $authAdapter->setUsername($data['username'])
                            ->setPassword($data['password']);
                //Instancio o AuthenticationService do zend
                $auth = new AuthenticationService;
                $sessionManager = $this->getServiceLocator()->get('Auth\Adapter\Session\StorageManager');
                $sessionStorage = new SessionStorage('Auth', null, $sessionManager);
                //Pego o resultado do authenticate
                $result = $auth->authenticate($authAdapter);
                //Verifico se o usuario é valido no sistema
                if($result->isValid()){
                    //Pega o valor da identitida
                    $identity = $auth->getIdentity(); 
                    //Escrevo uma chave usadno o nome de user
                    $sessionStorage->write($identity['user']);
                    //Retorno o usuario para a rota admin
                    return $this->redirect()->toRoute($this->defaultRoute);
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
    }

    public function logoutAction()
    {
        $sessionStorage = new SessionStorage('Auth');
        $sessionStorage->clear();
        
        $this->redirect()->toRoute('auth-login');
    }
    
    private function getDm()
    {
        if ($this->dm === null) {
            $this->dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');
        }
        return $this->dm;
    }
}
