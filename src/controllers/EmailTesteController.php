<?php

namespace sigec\controllers;

use Anddye\Mailer\Mailable;

class EmailTesteController extends Mailable
{
    
    protected $user;
    protected $chavesPendentes;
        
    public function __construct($user, $chavesPendentes)
    {
        $this->user = $user;
        $this->chavesPendentes = $chavesPendentes;
        
    }
    
    public function build()
    {
        $this->setSubject('Empréstimo em Atraso');
        $this->setView('email2.html', [
            'user' => $this->user,
            'chavesPendentes' => $this->chavesPendentes
        ]);        
        
    }
}    

    
    

