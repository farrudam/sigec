<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\ItemEmprestimo;
use sigec\models\Chave;
use sigec\models\Autenticador;


class ItemEmprestimoController extends Controller{
    
    static function create(Request $request, Response $response, $args){
       $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);         
        
        if(isset($postParam)){
            ItemEmprestimo::create($postParam);
            $chave = new Chave($postParam['id_chave']);
            $chave->emprestar();
            return $response->withStatus(301)->withHeader('Location', '../emprestimos'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'emprestimo_itens.html', [ ]);                
    }
    
    public function devolver(Request $request, Response $response, $args){  
        
        Chave::devolver($args['id_chave']);
        $mat_user = Autenticador::instanciar()->getMatricula();
        ItemEmprestimo::devolver($args['id'], $args['id_chave'], $mat_user);
        return $response->withStatus(301)->withHeader('Location', '../../../../emprestimos');

    }
}

