<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use sigec\models\Sala;
//use sigec\models\Bloco;
use sigec\models\Chave;


class ChaveController extends Controller{ 
    
    public function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //  var_dump($postParam);
        //  die();         
        
        if(isset($postParam)){
            Chave::create($postParam);
            return $response->withStatus(301)->withHeader('Location', '../chaves'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'chave_nova.html', [ 
            //'blocos' => (new Bloco())->getAll(),
            'salas' => (new Sala())->getAll()
         ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Chave();
        $chave = $objeto->getById($args['id']);     
        $sala = (new Sala())->getById($args['id_sala']);   
        //$bloco = (new Bloco())->getById($args['id_bloco']);
        
        return $this->container['renderizar']->render($response, 'chave_editar.html', [
            'chave' => $chave,
            'sala' => $sala,
            //'bloco' => $bloco
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Chave($args['id']);        
        $params = $request->getParams();        
        $objeto->update($params);        

        return $response->withStatus(301)->withHeader('Location', '../../chaves'); 
//      $rota = $this->container['renderizar']->get('router')->pathFor('bloco.show');       
//      return $response->withStatus(301)->withHeader('Location', $rota); 
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

    public function ativar(Request $request, Response $response, $args){

        Chave::ativar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../chaves');

    }

    public function desativar(Request $request, Response $response, $args){

        Chave::desativar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../chaves');

    }
    
    


}

