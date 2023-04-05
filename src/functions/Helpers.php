<?php

namespace sigec\functions;

class Helpers 
{
    
    
    public static function url(string $url = null): string
    {
        $servidor = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($servidor == 'localhost' ? URL_DESENVOLVIMENTO : URL_PRODUCAO);

        if (str_starts_with($url, '/')) {
            return $ambiente . $url;
        }
        return $ambiente . '/' . $url;
    }
    
    public static function redirecionar(string $url = null): void
    {
        header('HTTP/1.1 302 Found');
        
        $local = ($url ? self::url($url) : self::url());
        
        header("Location: {$local} ");
        exit();
    }
    
       
    
}