<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


class HomeController extends Controller{

    public function index(Request $request, Response $response, $args){
        return $this->container['renderizar']->render($response, 'index.html', [ ]);        
    }


}