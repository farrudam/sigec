<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\RestricaoChave;
use sigec\models\Chave;
use sigec\models\Usuario;
use sigec\models\Autenticador;
use sigec\database\DBSigec;


class RestricaoChaveController extends Controller{
    
    
    
    public function novo(Request $request, Response $response, $args){
        
        $objeto = new Chave();
        $chave = $objeto->getById($args['id']); 
        $restricoes = (new RestricaoChave())->getRestricoesByChave($args['id']);
        //$usuarios = (new RestricaoChave())->getAllSemRestricao($args['id']);
        $usuarios = (new Usuario())->getAll();
                         
        return $this->container['renderizar']->render($response, 'chave_restringir.html', [
            'chave' => $chave,
            'restricoes' => $restricoes,
            'usuarios' => $usuarios   
        ]);
    }
    
    public function restringir(Request $request, Response $response, $args){
        
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
                                  
            // Localiza o usuário operador do sistema
            $postParam['user_inclusao'] = Autenticador::instanciar()->getMatricula();
            
//            var_dump($postParam);
//            die();
            
            RestricaoChave::create($postParam);
            $this->container['flash']->addMessage('success', 'Restrição adicionada!');
            return $response->withStatus(301)->withHeader('Location', '../../../../chaves');  
            
        }        
                      
    }
    
    public function reabilitar(Request $request, Response $response, $args){        
        RestricaoChave::delete($args);
        $this->container['flash']->addMessage('success', 'Restrição removida!');            
        return $response->withStatus(301)->withHeader('Location', '../../../../chaves');
    }
}

