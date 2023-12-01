<?php

$app->get('/', 'sigec\controllers\HomeController:home')->setName('home');
$app->get('/buscar/{matricula}', 'sigec\controllers\EmprestimoController:buscar')->add($auth);
$app->post('/pesquisar', 'sigec\controllers\EmprestimoController:pesquisar');
$app->get('/detalhar_usuario/{userMatricula}', 'sigec\controllers\EmprestimoController:detalharUsuario')->add($auth);


$app->get('/usuarios', 'sigec\controllers\UsuarioController:show')->setName('usuarios')->add($auth);
$app->get('/usuario/novo', 'sigec\controllers\UsuarioController:novo')->setName('user_novo')->add($auth);
$app->post('/usuario/novo', 'sigec\controllers\UsuarioController:create');
$app->get('/usuario/{id}/update', 'sigec\controllers\UsuarioController:editar')->setName('user_editar')->add($auth);
$app->post('/usuario/{id}/update', 'sigec\controllers\UsuarioController:update')->setName('user_update');
$app->get('/usuario/{id}/alterarSenha', 'sigec\controllers\UsuarioController:alterarSenha')->setName('user_alterar_senha')->add($auth);
$app->get('/usuario/{id}/alterarFoto', 'sigec\controllers\UsuarioController:alterarFoto')->setName('alterar_foto_editar')->add($auth);
$app->post('/usuario/{id}/alterarFoto', 'sigec\controllers\UsuarioController:uploadFoto')->setName('alterar_foto_update')->add($auth);

$app->post('/usuario/update/{id}/senha', 'sigec\controllers\UsuarioController:updateSenha');
$app->get('/usuario/{id}/excluir', 'sigec\controllers\UsuarioController:excluir')->setName('user_excluir')->add($auth);
$app->get('/usuario/{id}/detalhar', 'sigec\controllers\UsuarioController:detalhar')->setName('user_detalhar')->add($auth);
$app->get('/usuario/importar', 'sigec\controllers\UsuarioController:importar')->setName('user_importar')->add($auth);
$app->get('/usuario/{id}/ativar', 'sigec\controllers\UsuarioController:ativar')->setName('user_ativar')->add($auth);
$app->get('/usuario/{id}/desativar', 'sigec\controllers\UsuarioController:desativar')->setName('user_desativar')->add($auth);

$app->get('/login', 'sigec\controllers\UsuarioController:login')->setName('login');
$app->post('/login', 'sigec\controllers\UsuarioController:checkin')->setName('checkin');
$app->get('/logout', 'sigec\controllers\UsuarioController:logout')->setName('logout');


$app->get('/blocos', 'sigec\controllers\BlocoController:show')->setName('blocos')->add($auth);
$app->get ('/bloco/novo', 'sigec\controllers\BlocoController:novo')->setName('bloco_novo')->add($auth);
$app->post ('/bloco/novo', 'sigec\controllers\BlocoController:create');
$app->get('/bloco/{id}/editar', 'sigec\controllers\BlocoController:editar')->setName('bloco_editar')->add($auth);
$app->post('/bloco/update/{id}', 'sigec\controllers\BlocoController:update');
$app->get('/bloco/{id}/excluir', 'sigec\controllers\BlocoController:excluir')->setName('bloco_excluir')->add($auth);


$app->get('/salas', 'sigec\controllers\SalaController:show')->setName('salas')->add($auth);
$app->get ('/sala/nova', 'sigec\controllers\SalaController:novo')->setName('sala_nova')->add($auth);
$app->post ('/sala/nova', 'sigec\controllers\SalaController:create');
$app->get('/sala/{id}/editar', 'sigec\controllers\SalaController:editar')->setName('sala_editar')->add($auth);
$app->post('/sala/update/{id}', 'sigec\controllers\SalaController:update');
$app->get('/sala/{id}/excluir', 'sigec\controllers\SalaController:excluir')->setName('sala_excluir')->add($auth);
$app->get('/sala/{id}/ativar', 'sigec\controllers\SalaController:ativar')->setName('sala_ativar')->add($auth);
$app->get('/sala/{id}/desativar', 'sigec\controllers\SalaController:desativar')->setName('sala_desativar')->add($auth);
$app->get('/sala/{id}/reparar', 'sigec\controllers\SalaController:reparar')->setName('sala_reparar')->add($auth);


$app->get('/chaves', 'sigec\controllers\ChaveController:show')->setName('chaves')->add($auth);
$app->get ('/chave/nova', 'sigec\controllers\ChaveController:novo')->setName('chave_nova')->add($auth);
$app->post ('/chave/nova', 'sigec\controllers\ChaveController:create');
$app->get('/chave/{id}/editar', 'sigec\controllers\ChaveController:editar')->setName('chave_editar')->add($auth);
$app->post('/chave/update/{id}', 'sigec\controllers\ChaveController:update');
$app->get('/chave/{id}/excluir', 'sigec\controllers\ChaveController:excluir')->setName('chave_excluir')->add($auth);
$app->get('/chave/{id}/habilitar', 'sigec\controllers\ChaveController:habilitar')->setName('chave_habilitar')->add($auth);
$app->get('/chave/{id}/desabilitar', 'sigec\controllers\ChaveController:desabilitar')->setName('chave_desabilitar')->add($auth);

$app->get('/chave/{id}/restringir', 'sigec\controllers\RestricaoChaveController:novo')->setName('chave_restringir')->add($auth);

$app->post('/chave/{id_chave}/usuario/{mat_solic}/restringir', 'sigec\controllers\RestricaoChaveController:restringir')->setName('chave_restringir')->add($auth);

$app->get('/chave/{id_chave}/usuario/{mat_solic}/reabilitar/{data_inclusao}', 'sigec\controllers\RestricaoChaveController:reabilitar')->setName('chave_reabilitar_usuario')->add($auth);


//$app->get('/emprestimos', 'sigec\controllers\EmprestimoController:show')->setName('emprestimos')->add($auth);
$app->get('/emprestimos/my', 'sigec\controllers\EmprestimoController:meusEmprestimos')->setName('meus_emprestimos')->add($auth);
$app->get('/emprestimos/ativos', 'sigec\controllers\EmprestimoController:ativos')->setName('emprestimos_ativos')->add($auth);
$app->get('/emprestimos/encerrados', 'sigec\controllers\EmprestimoController:encerrados')->setName('emprestimos_encerrados')->add($auth);
$app->get ('/emprestimo/novo', 'sigec\controllers\EmprestimoController:novo')->setName('emprestimo_novo')->add($auth);
$app->post ('/emprestimo/novo', 'sigec\controllers\EmprestimoController:create');
$app->get ('/emprestimos/relatorio', 'sigec\controllers\EmprestimoController:relatorio')->setName('emprestimo_relatorio')->add($auth);
$app->get ('/emprestimo/{id}/detalhes', 'sigec\controllers\EmprestimoController:detalhes')->setName('detalhes_emprestimo')->add($auth);
$app->get ('/emprestimo/{id}/concluir', 'sigec\controllers\EmprestimoController:concluir')->setName('concluir_emprestimo')->add($auth);


$app->get ('/emprestimo/{id}/chave/{id_chave}/devolver', 'sigec\controllers\ItemEmprestimoController:devolver')->setName('item_devolver')->add($auth);

use sigec\controllers\EmailController; 

$app->get('/teste', function ($request, $response, $args) {

       //$this->container['mailer']->setTo('fabioarrudamagalhaes@gmail.com', 'Fábio')->sendMessage(new EmailController('Fulano'));
        $this->mailer->setTo('ronaldo.ribeiro@ifce.edu.br', 'Ronaldo')->sendMessage(new EmailController('Fulano'));
       echo 'enviou';
});
