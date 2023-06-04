<?php

use sigec\models\Autenticador;

$auth = function ($request, $response, $next) {
    $aut = Autenticador::instanciar();
  
    if (!$aut->logado())
    {
        $url = $this->router->pathFor('login');
        return $response->withRedirect($url);
    }
    
    $twig = $this->get('renderizar')->getEnvironment();
    
    $response = $next($request, $response);   
    
    return $response;
};

