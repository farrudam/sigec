<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use sigec\models\Sala;
use sigec\models\Bloco;
use sigec\models\Chave;


class SalaController extends Controller{

    
    public function create(Request $request, Response $response, $args){
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);         
        
        if(isset($postParam)){
            
            if (in_array('', $postParam)) {                
                $this->container['flash']->addMessage('warning', 'Todos os campos são obrigatórios!');                                
                return $response->withStatus(301)->withHeader('Location', '../sala/nova'); 
            }
            
            Sala::create($postParam);
            $this->container['flash']->addMessage('success', 'Sala criada com sucesso!');
            //$this->flash->addMessage('success', 'Sala adicionada com sucesso.');
            return $response->withStatus(301)->withHeader('Location', '../salas'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'sala_nova.html', [ 
            'blocos' => (new Bloco())->getAll()
         ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Sala($args['id']);            
        $sala = $objeto->getById();        
                
        return $this->container['renderizar']->render($response, 'sala_editar.html', [
            'sala' => $sala            
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Sala($args['id']);        
        $params = $request->getParams();        
        $objeto->update($params);        
        $this->container['flash']->addMessage('success', 'Salvo com sucesso!');
        return $response->withStatus(301)->withHeader('Location', '../../salas'); 

    }

    public function show(Request $request, Response $response, $args){
        
        $objeto = new Sala();
        $salas = $objeto->getAll(); 
          
        return $this->container['renderizar']->render($response, 'listar_salas.html', [
            'salas' => $salas
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Sala::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../salas');

    }
    
    public function ativar(Request $request, Response $response, $args){

        Sala::ativar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../salas');

    }

    public function desativar(Request $request, Response $response, $args){

        Sala::desativar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../salas');
        
        
//        $idSala = $args['id'];
//
//        // Verificar se há chaves vinculadas disponíveis
//        $chavesDisponiveis = Chave::chavesVinculadasDisponiveis($idSala);
//
//        if (!empty($chavesDisponiveis)) {
//            // Desativar a sala apenas se houver chaves disponíveis
//            Sala::desativar($idSala);
//            $this->container['flash']->addMessage('success', 'Sala desativada com sucesso!');
//        } else {
//            // Lógica para quando não há chaves disponíveis
//            $this->container['flash']->addMessage('error', 'Não é possível desativar a sala. Existem chaves vinculadas em uso.');
//        }
//
//        return $response->withStatus(301)->withHeader('Location', '../../salas');

    }

    public function reparar(Request $request, Response $response, $args){

        Sala::reparar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../salas');

    }

}

