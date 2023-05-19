<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


class LoginController extends Controller{

    public function login(Request $request, Response $response, $args)
    {
        if ($request->isGet()){
            return $this->container['renderizar']->render($response, 'login.html', []);            
        }        
    }
    
    public function checkin (Request $request, Response $response, $args) {        
            
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if(isset($postParam)){            
            if (empty($postParam['matricula']) || empty($postParam['senha'])) {                
                $this->container['flash']->addMessage('warning', 'Todos os campos são obrigatórios!');                
                return $response->withStatus(301)->withHeader('Location', '/sigec/login');         
            } else {
                $this->container['flash']->addMessage('success', 'Dados válidos');
                return $response->withStatus(301)->withHeader('Location', '/sigec/login');
            } 
        }
         
    }
    
    public function logout($request, $response, $args) {
        session_destroy();
        return $this->container['renderizar']->render($response, 'home.html', [ ]);
    }

//    private function checarDados(array $postParams): bool
//    {
//        if(empty($postParams['matricula'])){
//            $this->container['flash']->addMessage('error', 'Matrícula é obrigatório!');
//            return false;
//        }
//        if(empty($postParams['senha'])){
//            $this->container['flash']->addMessage('error', 'Senha é obrigatório!');
//            return false;
//        }
//        
//        return true;
//    }

        

}