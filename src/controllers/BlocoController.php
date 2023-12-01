<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\Bloco;


class BlocoController extends Controller{
 
    
    public function create(Request $request, Response $response, $args){
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            
            if (in_array('', $postParam)) {                
                $this->container['flash']->addMessage('warning', 'Todos os campos são obrigatórios!');                                
                return $response->withStatus(301)->withHeader('Location', '../bloco/novo'); 
            }
            
            Bloco::create($postParam);
            $this->container['flash']->addMessage('success', 'Bloco adicionado com sucesso!');
            return $response->withStatus(301)->withHeader('Location', '../blocos'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'bloco_novo.html', [ ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Bloco($args['id']);
        $bloco = $objeto->getById();        
        return $this->container['renderizar']->render($response, 'bloco_editar.html', [
            'bloco' => $bloco
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Bloco($args['id']);       
        $params = $request->getParams();        
        $objeto->update($params);        
        $this->container['flash']->addMessage('success', 'Salvo com sucesso!');
        return $response->withStatus(301)->withHeader('Location', '../../blocos');

    }

    public function show(Request $request, Response $response, $args){
        unset($_SESSION['slimflash']);
        $objeto = new Bloco();
        $blocos = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_blocos.html', [
            'blocos' => $blocos
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Bloco::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../blocos');
    }
    
    


}

