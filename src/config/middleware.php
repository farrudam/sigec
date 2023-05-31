<?php

use sigec\models\Autenticador;

$auth = function ($request, $response, $next) {
    $aut = Autenticador::instanciar();
  
    if (!$aut->logado())
    {        
        return $response->withRedirect('login');
    }
    
    $twig = $this->get('renderizar')->getEnvironment();
      
    $twig->addGlobal('current_user', $aut);
    
    return $next($request, $response);
};

