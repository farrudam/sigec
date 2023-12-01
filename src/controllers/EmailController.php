<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace sigec\controllers;
use Anddye\Mailer\Mailable;


/**
 * Description of EmailController
 *
 * @author fabiomagalhaes
 */
class EmailController extends Mailable
{
    
    protected $user;
    
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    public function build()
    {
        $this->setSubject('Welcome to the Team!');
        $this->setView('email.html', [
            'user' => $this->user
        ]);
        
        return $this;
    }
    
}
