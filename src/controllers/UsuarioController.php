<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\Usuario;
use sigec\models\Autenticador;



class UsuarioController extends Controller{
    
    public function login(Request $request, Response $response, $args)
    {
        if ($request->isGet()){
            return $this->container['renderizar']->render($response, 'login.html', []);            
        }        
    }
        
    public function checkin(Request $request, Response $response, $args) {       
        
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                        
        if(isset($postParam)){            

            if (in_array('', $postParam)) {                
                $this->container['flash']->addMessage('warning', 'Todos os campos são obrigatórios!');                
                return $response->withStatus(301)->withHeader('Location', '/sigec/login');         
            } 
                  
            $objeto = Autenticador::instanciar();
            
            if ($objeto->logar($postParam['matricula'], $postParam['senha'], $tp = 'LOCALHOST')){
                return $response->withStatus(301)->withHeader('Location', '/sigec');         
            } else{
                $this->container['flash']->addMessage('error', 'Matrícula ou senha inválida!');                
                return $response->withStatus(301)->withHeader('Location', '/sigec/login');         
            }
            
        }  
    }
    
        
    public function logout(Request $request, Response $response, $args) {
        session_destroy();
        return $response->withStatus(301)->withHeader('Location', '/sigec/login');        
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

