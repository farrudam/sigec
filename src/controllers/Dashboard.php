<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\Bloco;


class Dashboard extends Controller{   
        
    public function dashboard(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'dashboard.html', [ ]);                
    }
}
