<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\Usuario;


class UsuarioController extends Controller{
    
    public function login(Request $request, Response $response, $args)
    {
        if ($request->isGet()){
            return $this->container['renderizar']->render($response, 'login.html', []);            
        }        
    }
        
    public function checkin(Request $request, Response $response, $args) {       
        
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $matricula = $postParam['matricula'];
        $senha = $postParam['senha'];

        if(isset($postParam)){            

            if (in_array('', $postParam)) {                
                $this->container['flash']->addMessage('warning', 'Todos os campos são obrigatórios!');                
                return $response->withStatus(301)->withHeader('Location', '/sigec/login');         
            } 
                  
            $objeto = new Usuario($args['id']);
            $usuario = $objeto->getById();
            
            var_dump($objeto);
            
            //$loginValido = $usuario->validarLogin($matricula, $senha);                               
            
                       

//            if (!$usuario) {
//                $this->container['flash']->addMessage('error', 'Matrícula ou senha inválidos!');                
//                return $response->withStatus(301)->withHeader('Location', '/sigec/login');                
//                         
//            } 
//            
//            if($postParam['senha'] != $objeto->getSenha()){
//                $this->container['flash']->addMessage('success', "{$usuario->getNome()}, seja bem vindo(a)!");
//                return $this->container['renderizar']->render($response, 'home.html', ['usuario' => $usuario]);     
//            }

             
        }  
    }
    
    public function logout($request, $response, $args) {
        session_destroy();
        return $this->container['renderizar']->render($response, 'login.html', [ ]);
    }
        
    public function create(Request $request, Response $response, $args){
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            Usuario::create($postParam);
            $this->container['flash']->addMessage('success', 'Usuário adicionado com sucesso!');
            return $response->withStatus(301)->withHeader('Location', '../usuarios'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
         
         return $this->container['renderizar']->render($response, 'usuario_novo.html', [ ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Usuario($args['id']);        
        $usuario = $objeto->getById();
        
//        
        return $this->container['renderizar']->render($response, 'usuario_editar.html', [
            'usuario' => $usuario            
        ]);        
    }
    
    public function update(Request $request, Response $response, $args){
        $objeto = new Usuario($args['id']);       
        $params = $request->getParams();        
        $objeto->update($params);        
        $this->container['flash']->addMessage('success', 'Alteração realizada com sucesso!');
        return $response->withStatus(301)->withHeader('Location', '../../usuarios');  
    }

    public function show(Request $request, Response $response, $args){
        $objeto = new Usuario();
        $usuarios = $objeto->getAll();
        
        return $this->container['renderizar']->render($response, 'listar_usuarios.html', [
            'usuarios' => $usuarios
        ]);
    }
    
    public function excluir(Request $request, Response $response, $args){

        Usuario::delete($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../usuarios');        
    }

    public function ativar(Request $request, Response $response, $args){

        Usuario::ativar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../usuarios');

    }

    public function desativar(Request $request, Response $response, $args){

        Usuario::desativar($args['id']);
        return $response->withStatus(301)->withHeader('Location', '../../usuarios');
    }
}

