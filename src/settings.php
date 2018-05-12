<?php
return [
    'settings' => [
        'mode' => 'development',
        'debug' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        // Github settings
        'github' => [
            'token' => '0e17dac7b70a737f61797873fadcf7b8acfbd475',
            'owner' => 'webtop'
        ],
    ],
];
