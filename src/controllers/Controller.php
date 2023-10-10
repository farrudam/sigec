<?php

namespace sigec\controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;


Class Controller{
    protected $container;    

    public function __construct(Container $container){
        $this->container = $container;   
        
    }

}