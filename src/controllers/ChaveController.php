<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use sigec\models\Sala;

use sigec\models\Chave;


class ChaveController extends Controller{ 
    
    public function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            Chave::create($postParam);
            $this->container['flash']->addMessage('success', 'Chave adicionada com sucesso!');
            return $response->withStatus(301)->withHeader('Location', '../chaves'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'chave_nova.html', [             
            'salas' => (new Sala())->getAll()
         ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Chave();
        $chave = $objeto->getById($args['id']);     
        $sala = (new Sala())->getById($args['id_sala']);
        return $this->container['renderizar']->render($response, 'chave_editar.html', [
            'chave' => $chave,
            'sala' => $sala
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Chave($args['id']);        
        $params = $request->getParams();        
        $objeto->update($params);
        $this->container['flash']->addMessage('success', 'Alteração realizada com sucesso!');
        return $response->withStatus(301)->withHeader('Location', '../../chaves'); 
    }

    public function show(Request $request, Response $response, $args){        
        $objeto = new Chave();
        $chaves = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_chaves.html', [            
            'chaves' => $chaves
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Chave::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../chaves');

    }

    public function habilitar(Request $request, Response $response, $args){

        Chave::habilitar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../chaves');

    }

    public function desabilitar(Request $request, Response $response, $args){

        Chave::desabilitar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../chaves');

    }   
    
}

