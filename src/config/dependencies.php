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

// Container para mensagens SweetAlert
//$container['sweetalert'] = function () {
//    return new SweetAlert();
//};

$container['DOMPDF'] = function () {
   return new Dompdf();
};


$container['upload_directory_imagem']    =  __DIR_BASE__ .'/uploads/imagem';
$container['upload_directory_documento'] =  __DIR_BASE__ .'/uploads/documentos/';

$container['base_url'] = function () {
 if (isset($_SERVER['HTTPS'])){
   $base = isset($_SERVER['HTTPS'])? 'https://':'http://';
 }
 
 return $base.$_SERVER['HTTP_HOST'];
   
};



