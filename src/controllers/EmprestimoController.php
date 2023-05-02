<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\Emprestimo;


class EmprestimoController extends Controller{
    
    public function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            Emprestimo::create($postParam);
            return $response->withStatus(301)->withHeader('Location', '../emprestimos'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'emprestimo_novo.html', [ ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Emprestimo();
        $emprestimo = $objeto->getById($args['id']);
//        
        return $this->container['renderizar']->render($response, 'emprestimo_editar.html', [
            'emprestimo' => $emprestimo
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Emprestimo($args['id']);       
        $params = $request->getParams();        
        $objeto->update($params);        

        return $response->withStatus(301)->withHeader('Location', '../../emprestimos'); 
    }

    public function show(Request $request, Response $response, $args){
        $objeto = new Emprestimo();
        $emprestimo = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_emprestimos.html', [
            'emprestimos' => $emprestimo
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Emprestimo::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../emprestimos');

    }
    
    


}

