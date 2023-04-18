<?php

$app->group('/admin', function() use ($app){
  $app->get('/login', function(){
      echo 'login';
  });
});

$app->get('/', 'sigec\controllers\HomeController:index');
$app->get('/user/update/{id}', 'sigec\controllers\UserController:update');
$app->get('/user/show', 'sigec\controllers\UserController:show');
$app->get('/user/exibir', 'sigec\controllers\UserController:exibir');
$app->get('/user/{id}', 'sigec\controllers\UserController:find');


$app->get('/blocos', 'sigec\controllers\BlocoController:show');
$app->get ('/bloco/novo', 'sigec\controllers\BlocoController:novo');
$app->post ('/bloco/novo', 'sigec\controllers\BlocoController:create');
$app->get('/bloco/{id}/editar', 'sigec\controllers\BlocoController:editar');
$app->post('/bloco/update/{id}', 'sigec\controllers\BlocoController:update');
$app->get('/bloco/{id}/excluir', 'sigec\controllers\BlocoController:excluir');


$app->get('/salas', 'sigec\controllers\SalaController:show');
$app->get ('/sala/nova', 'sigec\controllers\SalaController:novo');
$app->post ('/sala/nova', 'sigec\controllers\SalaController:create');
$app->get('/sala/{id}/editar', 'sigec\controllers\SalaController:editar');
$app->post('/sala/update/{id}', 'sigec\controllers\SalaController:update');
$app->get('/sala/{id}/excluir', 'sigec\controllers\SalaController:excluir');


$app->get('/chaves', 'sigec\controllers\ChaveController:show');
$app->get ('/chave/nova', 'sigec\controllers\ChaveController:novo');
$app->post ('/chave/nova', 'sigec\controllers\ChaveController:create');
$app->get('/chave/{id}/editar', 'sigec\controllers\ChaveController:editar');
$app->post('/chave/update/{id}', 'sigec\controllers\ChaveController:update');
$app->get('/chave/{id}/excluir', 'sigec\controllers\ChaveController:excluir');
$app->get('/chave/{id}/ativar', 'sigec\controllers\ChaveController:ativar');
$app->get('/chave/{id}/desativar', 'sigec\controllers\ChaveController:desativar');



