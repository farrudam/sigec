<?php

namespace sigec\controllers;
use Anddye\Mailer\Mailable;

class EmailController extends Mailable
{
    
    protected $user;
    protected $chavesPendentes;
    
    public function __construct($user)
    {
        $this->user = $user;

        
    }
    
    public function build()
    {
        $this->setSubject('Pendências de Chaves');
        $this->setView('email.html', [
            'user' => $this->user

        ]);
        
        return $this;
    }
    
   
}
