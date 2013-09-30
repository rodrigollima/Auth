ZF2-Auth
=============

Modulo para autenticação com ZF2
- MongoDB(necessário DoctrineODMMongoModule)

    Documento Básico para autenticação usando MongoDB:
    
    
    db.users.findOne()
    {
	"_id" : ObjectId("5241f1ad024bf9134b9736f3"),
	"username" : "rodrigoxone@gmail.com",
	"password" : "123456"
    }   

- Sessões
  - Arquivo (default)
  - Redis
    
- Configuração
--------------

config/module.config.php:

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
  
