<?php

use Slim\Http\Request;
use Slim\Http\Response;
use DigitalPig\ReleaseManager\Connector;

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/repos', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->get('settings')['github']);
    $repos = $connector->getRepos();
    
    return $response->withJson($repos);
});

$app->get('/repo/{repo}', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->get('settings'));
    $repo = $connector->getRepo($args['repo']);
    
    return $response->withJson($repo);
});

$app->get('/repo/{repo}/branches', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->get('settings'));
    $branches = $connector->getBranches($args['repo']);
    
    return $response->withJson($branches);
});

$app->get('/repo/{repo}/branch/{branch}', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->get('settings'));
    $branch = $connector->getBranch($args['repo'], $args['branch']);
    
    return $response->withJson($branch);
});