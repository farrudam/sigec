<?php

use sigec\models\Autenticador;
#Todas essas rotas estão em /autenticacao

$app->map(['GET', 'POST'], '/login', function ($request, $response, $args) {
   
    if($request->isGet()){
      $messages = $this->flash->getMessages();
      #Verificando se tem mensagem de erro
      
      return $this->renderer->render($response, 'login.html' , array());
    }else{
          
        # Uso do singleton para instanciar
        # apenas um objeto de autenticação
        # e esconder a classe real de autenticação
        $aut = Autenticador::instanciar();
      
        $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);  

        # efetua o processo de autenticação
        
        if ($aut->logar($postParam['login'], $postParam['senha'], $postParam['origem'])) {
          # redireciona o usuário para dentro do sistema
          $url = $this->router->pathFor('home');
          return $response->withRedirect($url);
        }else{  
          $this->flash->addMessage('erro', 'Usuário ou senha incorretos');
        }
    
      return $response->withStatus(302)->withHeader('Location', 'login');
    }
   
})->setName('login');

$app->map(['GET', 'POST'], '/logout', function($request, $response, $args){
    session_destroy();
    $url = $this->router->pathFor('home');
    return $response->withRedirect($url);
})->setName('logout');

$app->get('/geraRolMenu', function ($request, $response, $args) {
    siap\home\models\Menu::geraRolMenus();
  echo 'Gerado com sucesso. Seu ip é '.getClientIp();
  
})->setName('rolMenu');
