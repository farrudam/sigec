<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


Class Controller{
    protected $container;    

    public function __construct(Container $container){
        $this->container = $container;   
        
//        $usuario = false;       
//                
//        if (!$usuario){
//            $this->container['flash']->addMessage('error', 'Você deve estar logado');
//            return $response->withStatus(301)->withHeader('Location', '/sigec/login');         
//        }
        
    }

}