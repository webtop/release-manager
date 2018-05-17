<?php

$settings = [
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
        
        // Git host settings
        'git-source' => 'github' // should be github or gitlab
    ],
];

if (empty($settings['git-source'])) {
    exit('No defined git source!');
}

return $settings;
