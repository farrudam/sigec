<?php

//namespace sigec\controllers;
//
//use Slim\Container;
//use Slim\Http\Request;
//use Slim\Http\Response;
//
//
//use sigec\models\Autenticador;
//
//
//class AutenticadorController extends Controller {
//
//    public function login(Request $request, Response $response, $args) {
//        if ($request->isGet()) {
//            //$messages = $this->flash->getMessages();
//            // Verificando se tem mensagem de erro
//
//            return $this->container['renderizar']->render($response, 'login.html', []);            
//
//        } else {
//            $aut = Autenticador::instanciar();
//            $postParam = filter_input_array(INPUT_POST, FILTER_DEFAULT);           
//
//            if ($aut->logar($postParam['login'], $postParam['senha'], $postParam['tp'])) {
//                $url = $this->router->pathFor('home');
//                return $response->withRedirect($url);
//            } else {
//                $this->flash->addMessage('erro', 'Usuário ou senha incorretos');
//                $url = $this->router->pathFor('login');
//                return $response->withRedirect($url);
//            }
//        }
//    }
//
//    public function logout($request, $response, $args) {
//        session_destroy();
//        $url = $this->router->pathFor('home');
//        return $response->withRedirect($url);
//    }
//    
//}
