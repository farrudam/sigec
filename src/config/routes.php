<?php

$app->group('/admin', function() use ($app){
  $app->get('/login', function(){
      echo 'login';
  });
});


//$app->get('/', function ($request, $response, $args) {
//
//  echo "ola mundo";
//   
//})->setName('ola_mundo');


$app->get('/', 'sigec\controllers\HomeController:index');
$app->get('/user/update/{id}', 'sigec\controllers\UserController:update');
$app->get('/user/show', 'sigec\controllers\UserController:show');
$app->get('/user/exibir', 'sigec\controllers\UserController:exibir');
$app->get('/user/{id}', 'sigec\controllers\UserController:find');


$app->get('/blocos', 'sigec\controllers\BlocoController:show')->setName('bloco.show');
$app->get ('/bloco/novo', 'sigec\controllers\BlocoController:novo')->setName('bloco.novo');
$app->post ('/bloco/novo', 'sigec\controllers\BlocoController:create')->setName('bloco.create');
$app->get('/bloco/{id}/editar', 'sigec\controllers\BlocoController:editar');
$app->post('/bloco/update/{id}', 'sigec\controllers\BlocoController:update');
$app->get('/bloco/{id}/excluir', 'sigec\controllers\BlocoController:excluir');


$app->get('/salas', 'sigec\controllers\SalaController:show')->setName('sala.show');
$app->get ('/sala/nova', 'sigec\controllers\SalaController:novo')->setName('sala.nova');
$app->post ('/sala/nova', 'sigec\controllers\SalaController:create')->setName('sala.create');
//$app->get('/bloco/{id}/sala/{id}/editar', 'sigec\controllers\SalaController:editar');
//$app->post('/bloco/{id}/sala/update/{id}', 'sigec\controllers\SalaController:update');
//$app->get('/bloco/{id}/sala/{id}/excluir', 'sigec\controllers\SalaController:excluir');




//$app->match(['get','post'],'sigec\controllers\BlocoController:novo')->setName('bloco.novo');