<?php

use Dompdf\Dompdf;

$container = $app->getContainer();

// view renderer
$container['renderizar'] = function ($c) {
    $settings = $c->get('settings')['renderizar'];
    $view = new Slim\Views\Twig($settings['template_path']);
    
    $view->addExtension(new \Slim\Views\TwigExtension(
		$c->router,
		$c->request->getUri()
    ));
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

// Register provider
$container['flash'] = function () {
  //session_start();
  if ( session_status() !== PHP_SESSION_ACTIVE )
  {
    session_start();
  }
  return new \Slim\Flash\Messages();
};


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



