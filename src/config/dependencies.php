<?php

use Dompdf\Dompdf;
use sigec\models\Autenticador;

$container = $app->getContainer();


// view renderer
$container['renderizar'] = function ($c) {
    $settings = $c->get('settings')['renderizar'];
    $view = new Slim\Views\Twig($settings['template_path']);
    
    $view->addExtension(new \Slim\Views\TwigExtension(
		$c->router,
		'https://sistemas.tiangua.ifce.edu.br/sigec'//$c->request->getUri()
    ));
    
    
    $env = $view->getEnvironment();
    $env->addGlobal('messages', $c->get('flash')->getMessages());
    $env->addGlobal('session', Autenticador::instanciar());
    $env->addGlobal('base_url', 'https://sistemas.tiangua.ifce.edu.br/sigec');
    
    
    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};


$container['flash'] = function () {
  //session_start();
  /*if ( session_status() !== PHP_SESSION_ACTIVE )
  {
    session_start();
  }
  */
  session_start();
  return new \Slim\Flash\Messages();
};

$container['mailer'] = function($container) {
    $twig = $container['renderizar'];
    $mailer = new \Anddye\Mailer\Mailer($twig, [
        'host'      => 'smtp.gmail.com',  // SMTP Host
        'port'      => '465',  // SMTP Port
        'username'  => 'naoresponda@tiangua.ifce.edu.br',  // SMTP Username
        'password'  => 'cPLYN2io8psQ/]4>',  // SMTP Password
        'protocol'  => 'SSL'   // SSL or TLS
    ]);
        
    // Set the details of the default sender
    $mailer->setDefaultFrom('suporte@tiangua.ifce.edu.br', 'nao-responda [SIGEC]');
    
    return $mailer;
};

$container['DOMPDF'] = function () {
   return new Dompdf();
};


$container['upload_directory_imagem']    =  '/var/www/homes/sistemas/pasta_online_internet/sigec/src/assets/img/usuarios';
$container['upload_directory_documento'] =  '/var/www/homes/sistemas/pasta_online_internet/sigec/uploads/documentos';

$container['base_url'] = function () {
 if (isset($_SERVER['HTTPS'])){
   $base = isset($_SERVER['HTTPS'])? 'https://':'http://';
 }
 
 return $base.$_SERVER['HTTP_HOST'];
   
};



