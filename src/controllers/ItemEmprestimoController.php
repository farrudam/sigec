<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\ItemEmprestimo;
use sigec\models\Chave;


class ItemEmprestimoController extends Controller{
    
    static function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         var_dump($postParam);
         die();
        
        if(isset($postParam)){
            ItemEmprestimo::create($postParam);
            return $response->withStatus(301)->withHeader('Location', '../emprestimos'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'emprestimo_itens.html', [ ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Bloco();
        $bloco = $objeto->getById($args['id']);
//        $bloco = Bloco::getById($args['id']);
        return $this->container['renderizar']->render($response, 'bloco_editar.html', [
            'bloco' => $bloco
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Bloco($args['id']);       
        $params = $request->getParams();        
        $objeto->update($params);        

        return $response->withStatus(301)->withHeader('Location', '../../blocos'); 
//      $rota = $this->container['renderizar']->get('router')->pathFor('bloco.show');       
//      return $response->withStatus(301)->withHeader('Location', $rota); 
    }

    public function show(Request $request, Response $response, $args){
        $objeto = new Bloco();
        $blocos = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_blocos.html', [
            'blocos' => $blocos
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Bloco::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../emprestimos');

    }
    
    public function receber(Request $request, Response $response, $args){
                
        Chave::receber($args['id']);
        ItemEmprestimo::receber($id);
        return $response->withStatus(301)->withHeader('Location', '../../emprestimos');

    }
    
    


}

