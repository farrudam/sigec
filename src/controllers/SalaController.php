<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use sigec\models\Sala;
use sigec\models\Bloco;


class SalaController extends Controller{

//    public function index(Request $request, Response $response, $args){
//        return $this->container['renderizar']->render($response, 'index.html', [
//            'titulo' => 'teste de título',
//            'subtitulo' => 'teste de subtitulo'
//        ]);        
//    } 
    
    public function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);         
        
        if(isset($postParam)){
            Sala::create($postParam);
            return $response->withStatus(301)->withHeader('Location', '../salas'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'sala_nova.html', [ 
            'blocos' => (new Bloco())->getAll()
         ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Sala();
        $sala = $objeto->getById($args['id']);        
        $bloco = (new Bloco())->getById($args['id_bloco']);
        
        return $this->container['renderizar']->render($response, 'sala_editar.html', [
            'sala' => $sala,
            'bloco' => $bloco
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Sala($args['id']);        
        $params = $request->getParams();        
        $objeto->update($params);        

        return $response->withStatus(301)->withHeader('Location', '../../salas'); 
//      $rota = $this->container['renderizar']->get('router')->pathFor('bloco.show');       
//      return $response->withStatus(301)->withHeader('Location', $rota); 
    }

    public function show(Request $request, Response $response, $args){
        $objeto = new Sala();
        $salas = $objeto->getAll();
        //$bloco = (new Bloco())->getById($args['id_bloco']);
        
        
        return $this->container['renderizar']->render($response, 'listar_salas.html', [
            'salas' => $salas
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Bloco::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../salas');
//        $msg = Produto::delete($produto_codigo);
//        if ($msg[2]) {
//            $this->flash->addMessage('danger', $msg[2]);
//        } else {
//            $this->flash->addMessage('success', 'Registro excluido com sucesso');
//        }
    }
    
    


}

