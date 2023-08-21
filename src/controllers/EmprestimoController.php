<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use sigec\models\Emprestimo;
use sigec\models\ItemEmprestimo;
use sigec\models\Usuario;
use sigec\models\Bloco;
use sigec\models\Chave;


class EmprestimoController extends Controller{
    
    public function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            Emprestimo::create($postParam);
            return $response->withStatus(301)->withHeader('Location', '../emprestimos'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
        $blocos = (new Bloco)->getAll();  
        $chaves = (new Chave)->getAll();  
                        
        return $this->container['renderizar']->render($response, 'exibir_chaves.html', [
            'blocos' => $blocos,
            'chaves' => $chaves
        ]);
    }
    
    public function show(Request $request, Response $response, $args){        
        $emprestimos = (new Emprestimo)->getAll();  
        $itens_emprestimos = (new ItemEmprestimo)->getAll();  
                        
        return $this->container['renderizar']->render($response, 'listar_emprestimos.html', [
            'emprestimos' => $emprestimos,
            'itens_emprestimos' => $itens_emprestimos
        ]);
    }
    
    public function detalhes(Request $request, Response $response, $args){        
        $emprestimo = (new Emprestimo($args['id']))->getById();
        $chaves = (new Emprestimo($args['id']))->getChaves();
                        
        return $this->container['renderizar']->render($response, 'detalhar_emprestimo.html', [
            'emprestimo' => $emprestimo,
            'itens_emprestimo' => $chaves
        ]);
    }     

    public function relatorio(Request $request, Response $response, $args){
        $objeto = new Emprestimo();
        $emprestimo = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'relatorio.html', [
            'emprestimos' => $emprestimo
        ]);
    }
    
    


}

