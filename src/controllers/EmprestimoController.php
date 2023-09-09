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
    
//    public function buscar(Request $request, Response $response, $args)
//    {
//        $matricula = $args['matricula'];
//        
//        $usuario = (new Usuario())->buscar($matricula); 
// 
//        // Crie um array ou objeto com os dados do usuário encontrados
//                
//        foreach ($usuario as $user) {
//            $dadosUsuario = array(
//            'nome' => $user->getNome(),
//            'email' => $user->getEmail()            
//            );
//        }
//        
//        return $this->container['renderizar']->render($response, 'detalhes_usuario.twig', ['usuario' => $dadosUsuario]);
//    }
     
    public function buscar(Request $request, Response $response, $args)
    {
        
        $matricula = $args['matricula'];

        $usuario = (new Usuario())->buscar($matricula);
        
        if (count($usuario) > 0) {
            $dadosUsuario = array(
                'nome' => $usuario[0]->getNome(),
                'email' => $usuario[0]->getEmail()            
            );
//            var_dump($dadosUsuario);
//            die();
            header('Content-Type: application/json');
            echo json_encode($dadosUsuario);
        }
        
    }

    
        
//        public function pesquisar(): void
//        {
//            $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
//
//            if (isset($busca)) {
//                $usuario = (new Usuario())->pesquisar($busca);
//
//                header('Content-Type: application/json');
//                echo json_encode($usuario); // Certifique-se de que $usuario seja um array associativo contendo os dados do usuário
//            }
//        }
    
    

        
//    public function detalharUsuario(Request $request, Response $response, $args) {
//                
//        $userMatricula = $args['userMatricula'];
//        
//        $getParam = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//        if(isset($getParam)){
//            return $response->withStatus(301)->withHeader('Location', '../emprestimos');
//        }
//        
//        $usuario = (new Usuario())->getByMatricula($userMatricula);
//        
//        echo $usuario;
//        die();
//
//        // Retorne os detalhes do usuário como JSON
//        return $response->withJson($usuario);
//    }



}

