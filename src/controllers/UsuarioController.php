<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use sigec\models\Usuario;


class UsuarioController extends Controller{
    
    public function create(Request $request, Response $response, $args){
         $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(isset($postParam)){
            Usuario::create($postParam);
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

