ZF2-Auth
====

Modulo para autenticação com ZF2
- MongoDB(necessário DoctrineODMMongoModule)
    Documento Básico para autenticação usando MongoDB
    db.users.insert( { username : "seuemail@seudominio.com", password : "suasenha" } )


- Sessões
  - Arquivo (default)
  - Redis
    

config/module.config.php
    'Auth\Config' => array(
        //Define qual será o metodo de autenticação usado
        'Authentication\Adapter' => array(
            'type' => 'mongo',
        ),
        //Implementa o modo como será salvo os dados da sessão
        'Session\Storage' => array(
            'type'  => 'redis',
            'redis' => array(
                'phpSaveHandler' => 'redis',
                'savePath' => 'tcp://127.0.0.1:6379?weight=1&timeout=1',  
            ),
        ),
    ),
  
