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
    
    public function create(Request $request, Response $response, $args){
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            
            if (in_array('', $postParam)) {                
                $this->container['flash']->addMessage('warning', 'Selecione um usuário!');                                
                return $response->withStatus(301)->withHeader('Location', '../chaves'); 
            }
            
            RestricaoChave::create($postParam);
            $this->container['flash']->addMessage('success', 'Restrição adicionada!');
            return $response->withStatus(301)->withHeader('Location', '../chaves'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
        
        $objeto = new Chave();
        $chave = $objeto->getById($args['id']); 
        $restricoes = (new RestricaoChave())->getRestricoesByChave($args['id']);
        //$usuarios = (new RestricaoChave())->getAllSemRestricao($args['id']);
        $usuarios = (new Usuario())->getAll();
        
//        var_dump($usuarios);
//        die();
                         
        return $this->container['renderizar']->render($response, 'chave_restringir.html', [
            'chave' => $chave,
            'restricoes' => $restricoes,
            'usuarios' => $usuarios   
        ]);
    }
    
    public function reabilitar(Request $request, Response $response, $args){         

        
        $db = DBSigec::getKeys();
        
        $db->beginTransaction();
        
        try {
                        
            RestricaoChave::delete($args['id_chave'], $args['id_usuario']);
                        
            $db->commit();            
            
            $this->container['flash']->addMessage('success', 'Restrição removida!');            
            return $response->withStatus(301)->withHeader('Location', '../../../../emprestimos/ativos');
            
            
        } catch (Exception $e) {
            $db->rollback();
            // Lidar com o erro de alguma maneira apropriada. Mensagem Flash
        }

    }
}

