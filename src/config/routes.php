<?php

$app->group('/admin', function() use ($app){
  $app->get('/login', function(){
      echo 'login';
  });
});

$app->get('/', 'sigec\controllers\HomeController:index');

$app->get('/usuarios', 'sigec\controllers\UsuarioController:show');
$app->get('/usuario/novo', 'sigec\controllers\UsuarioController:novo');
$app->post('/usuario/novo', 'sigec\controllers\UsuarioController:create');
$app->get('/usuario/{id}/editar', 'sigec\controllers\UsuarioController:editar');
$app->post('/usuario/update/{id}', 'sigec\controllers\UsuarioController:update');
$app->get('/usuario/detalhar', 'sigec\controllers\UsuarioController:detalhar');
$app->get('/usuario/{id}/ativar', 'sigec\controllers\UsuarioController:ativar');
$app->get('/usuario/{id}/desativar', 'sigec\controllers\UsuarioController:desativar');


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
$app->get('/sala/{id}/ativar', 'sigec\controllers\SalaController:ativar');
$app->get('/sala/{id}/desativar', 'sigec\controllers\SalaController:desativar');
$app->get('/sala/{id}/reparar', 'sigec\controllers\SalaController:reparar');


$app->get('/chaves', 'sigec\controllers\ChaveController:show');
$app->get ('/chave/nova', 'sigec\controllers\ChaveController:novo');
$app->post ('/chave/nova', 'sigec\controllers\ChaveController:create');
$app->get('/chave/{id}/editar', 'sigec\controllers\ChaveController:editar');
$app->post('/chave/update/{id}', 'sigec\controllers\ChaveController:update');
$app->get('/chave/{id}/excluir', 'sigec\controllers\ChaveController:excluir');
$app->get('/chave/{id}/habilitar', 'sigec\controllers\ChaveController:habilitar');
$app->get('/chave/{id}/desabilitar', 'sigec\controllers\ChaveController:desabilitar');


$app->get('/emprestimos', 'sigec\controllers\EmprestimoController:show');
$app->get ('/emprestimo/novo', 'sigec\controllers\EmprestimoController:novo');
$app->post ('/emprestimo/novo', 'sigec\controllers\EmprestimoController:create');
$app->get('/emprestimo/{id}/editar', 'sigec\controllers\EmprestimoController:editar');
$app->post('/emprestimo/update/{id}', 'sigec\controllers\EmprestimoController:update');

