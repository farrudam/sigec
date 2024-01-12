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
                
        $chave = (new Chave())->getById($args['id']); 
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
            
            RestricaoChave::create($postParam);
            $this->container['flash']->addMessage('success', 'Restrição adicionada!');
            return $response->withStatus(301)->withHeader('Location', '../../restringir');  
            
        }        
                      
    }
    
    public function reabilitar(Request $request, Response $response, $args){
        
        $args['user_remocao'] = Autenticador::instanciar()->getMatricula();
        
        RestricaoChave::delete($args['user_remocao'], $args['id_chave'], $args['mat_solic'], $args['data_inclusao']);
        $this->container['flash']->addMessage('success', 'Restrição removida!');            
        return $response->withStatus(301)->withHeader('Location', '../../../restringir');  
    }
    
    
    public function restringirTodos(Request $request, Response $response, $args){
        
        $params = $request->getParams();
        
        $params['id_chave'] = $args['id'];
               
        if(isset($params)){
                                  
            // Localiza o usuário operador do sistema
            $params['user_inclusao'] = Autenticador::instanciar()->getMatricula();
            
            RestricaoChave::restringirTodos($params);
            $this->container['flash']->addMessage('success', 'Restrições adicionadas!');
            return $response->withStatus(301)->withHeader('Location', '../../chave/' .$args['id']. '/restringir');  
            
        }        
                      
    }
    
    public function removeRestricoes(Request $request, Response $response, $args){
        
        $params = $request->getParams();
        
        $params['id_chave'] = $args['id'];
               
        if(isset($params)){
                                  
            // Localiza o usuário operador do sistema
            $params['user_remocao'] = Autenticador::instanciar()->getMatricula();
            
            RestricaoChave::removeRestricoes($params);
            $this->container['flash']->addMessage('success', 'Restrições removidas!');
            return $response->withStatus(301)->withHeader('Location', '../../chave/' .$args['id']. '/restringir');  
            
        }        
                      
    }
    
    
    
}

