<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace sigec\utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        // Configurações do PHPMailer
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'nao-responda@ifce.edu.br';
        $this->mailer->Password = 'd0n0tr3ply!@';
        $this->mailer->SMTPSecure = 'SSL';
        $this->mailer->Port = 465;
    }

    public function enviarEmail($destinatario, $assunto, $corpo)
    {
        try {
            // Configurações de e-mail
            $this->mailer->setFrom('nao-responda@ifce.edu.br', 'SIGEC');
            $this->mailer->addAddress($destinatario);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $assunto;
            $this->mailer->Body = $corpo;

            // Envia o e-mail
            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
