<?php

use Classes\Connector;

$container = $app->getContainer();

// view renderer
$container['view'] = function($c) {
    $settings = $c->get('settings')['view'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// Git connector class
$container['connector'] = function($c) {
    $connector = Connector::getInstance($c->git);
    return $connector;
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
