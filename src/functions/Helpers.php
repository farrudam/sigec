<?php

namespace sigec\functions;

use sigec\functions\Sessao;


class Helpers
{

    /*Instancia e retorna as mensagens flash por sessão*/
    public static function flash(): ?string
    {
        $sessao = new Sessao();

        if ($flash = $sessao->flash()) {
            echo $flash;
        }
        return null;
    }

    

}
