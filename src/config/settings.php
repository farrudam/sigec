<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderizar' => [
            'template_path' => array(
                __DIR__ . '/../../templates/',
                __DIR__ . '/../views/bloco',
                __DIR__ . '/../views/'
            ),
        ],

        // PDO settings
        'conexao' => [
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'dbname' => 'sigec',
            ],


        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
