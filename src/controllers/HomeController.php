<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


class HomeController extends Controller{

    public function home(Request $request, Response $response, $args){
        return $this->container['renderizar']->render($response, 'home.html', [ ]);        
    }
        
//    public function admin(Request $request, Response $response, $args){       
//        $this->container['flash']->addMessage('error', 'Você deve estar logado');
//        return $response->withStatus(302)->withHeader('Location', '/sigec/login');         
//    }
}