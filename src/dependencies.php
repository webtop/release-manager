<?php


$container = $app->getContainer();

// view renderer
$container['renderer'] = function($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// git source
$container['git'] = function($c) {
    $sourceClass = '\\Config\\' . $c->get('settings')['git-source'] . 'Config';
    $git = new $sourceClass;
    return $git;
};
