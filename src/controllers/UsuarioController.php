<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
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
              
                $perfil = Autenticador::instanciar()->getPerfil();
                if ($perfil == "Solicitante"){
                    return $response->withStatus(301)->withHeader('Location', '/sigec/emprestimos/my');
                }
                
                return $response->withStatus(301)->withHeader('Location', '/sigec/emprestimos/ativos');
                
            } else{
                $this->container['flash']->addMessage('error', 'Matrícula ou senha inválida!');                
                return $response->withStatus(301)->withHeader('Location', '/sigec/login');         
            }
            
        }  
    }
    
        
    public function logout(Request $request, Response $response, $args) {
        session_destroy();
        return $response->withStatus(301)->withHeader('Location', '/sigec');        
    }
        
    public function create(Request $request, Response $response, $args){
        $postParam = $request->getParsedBody();
        
        if (!$postParam['cargo']){
            $postParam['cargo'] = "não informado";
        }
        
        if (!$postParam['url_foto']){
            $postParam['url_foto'] = "../src/assets/img/usuarios/usuario.png";
        }
                
        // Verificar se a matrícula já está em uso
        if (Usuario::matriculaExists($postParam['matricula'])) {            
            $this->container->flash->addMessage('warning', 'Essa matrícula já existe!');
            return $response->withRedirect('../usuario/novo');
        }        

        if(isset($postParam)){
            
            if (in_array('', $postParam)) {                
                $this->container['flash']->addMessage('warning', 'Preencha os campos obrigatórios (*)');                                
                return $response->withStatus(301)->withHeader('Location', '../usuario/novo'); 
            } 
            
            $postParam['senha'] = md5($postParam['senha']);
            //$postParam['senha'] = password_hash($postParam['senha'], PASSWORD_DEFAULT);
            
            
//            var_dump($postParam);
//            die();
            
            Usuario::create($postParam);
            $this->container['flash']->addMessage('success', 'Usuário adicionado!');
            return $response->withStatus(301)->withHeader('Location', '../usuarios'); 
        }                
    }
    
    public function novo(Request $request, Response $response, $args){
       
         return $this->container['renderizar']->render($response, 'usuario_novo.html', [ ]);                
    }
    
    public function editar(Request $request, Response $response, $args){
        $objeto = new Usuario($args['id']);        
        $usuario = $objeto->getById();        
        
        return $this->container['renderizar']->render($response, 'usuario_editar.html', [
            'usuario' => $usuario            
        ]);        
    }
    
    public function detalhar(Request $request, Response $response, $args){             
        $usuario = (new Usuario($args['id']))->getById();        

        return $this->container['renderizar']->render($response, 'detalhar_usuario.html', [
            'usuario' => $usuario            
        ]);        
    }    
    
    public function alterarSenha(Request $request, Response $response, $args){
        $objeto = new Usuario($args['id']);        
        $usuario = $objeto->getById();
                
        return $this->container['renderizar']->render($response, 'usuario_alterar_senha.html', [
            'usuario' => $usuario            
        ]);        
    }
    
    public function alterarFoto(Request $request, Response $response, $args){
        $objeto = new Usuario($args['id']);        
        $usuario = $objeto->getById();
                
        return $this->container['renderizar']->render($response, 'usuario_alterar_foto.html', [
            'usuario' => $usuario            
        ]);        
    }
       
    
    public function update(Request $request, Response $response, $args){
        
        $objeto = new Usuario($args['id']);        
        $params = $request->getParams();
        
        if (in_array('', $params)) {                
            $this->container['flash']->addMessage('warning', 'Todos os campos são obrigatórios!');                                
            return $response->withStatus(301)->withHeader('Location', '../../usuario/' .$args['id']. '/update'); 
        } 
        
        $objeto->update($params);        
        $this->container['flash']->addMessage('success', 'Salvo com sucesso!');          
        return $response->withStatus(301)->withHeader('Location', '../../usuarios');        
    }
    
    public function updateSenha(Request $request, Response $response, $args){
        
        $objeto = new Usuario($args['id']);  
        
        $params = $request->getParams();
        
        // Verifica se os campos obrigatórios estão presentes
        if (in_array('', $params)){
            $this->container['flash']->addMessage('error', 'Por favor, preencha todos os campos obrigatórios.');
            return $response->withStatus(301)->withHeader('Location', '../../' . $args['id'] . '/alterarSenha');
        }

        // Verifica se as senhas coincidem
        if ($params['nova_senha'] !== $params['confirmar_senha']) {
            $this->container['flash']->addMessage('error', 'As senhas não coincidem. Tente novamente.');
            return $response->withStatus(301)->withHeader('Location', '../../' . $args['id'] . '/alterarSenha');
        }
        
        // Atualiza o objeto com os novos parâmetros
        $objeto->updateSenha([
            'senha' => md5($params['nova_senha'])                
        ]);
        
        //$objeto->update($params);        
        $this->container['flash']->addMessage('success', 'Salvo com sucesso!');          
        return $response->withStatus(301)->withHeader('Location', '../../../usuarios');        
    }
    
    public function uploadFoto(Request $request, Response $response, $args) {
        
        var_dump($args);
        die();
        
        $usuarioId = $args['id'];
                
        $directory = $this->container->get('upload_directory_imagem');
                
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['url_foto'];       
             
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            
            $filename = '../src/assets/img/usuarios/' . $this->moveUploadedFile($directory, $uploadedFile);
            
            Usuario::atualizarFoto($filename, $usuarioId); 

            $this->container->flash->addMessage('success', 'Foto atualizada!');
            return $response->withStatus(302)->withHeader('Location', '../../usuarios');

        } else {                
            $this->container->flash->addMessage('error', 'Erro ao atualizar foto!');
            return $response->withStatus(301)->withHeader('Location', '../../usuario/' . $args['id'] . '/alterarFoto');

        }

    }

    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); 
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
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
        $this->container['flash']->addMessage('success', 'Excluído com sucesso!'); 
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
    
    public function importar(Request $request, Response $response, $args){

        $this->container['flash']->addMessage('success', 'Você será redirecionado!');          
        return $response->withStatus(301)->withHeader('Location', '../../usuarios');
    }
    
}

