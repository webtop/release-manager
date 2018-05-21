<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Classes\Connector;

// Routes
$app->get('/', function (Request $request, Response $response, array $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/repos', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->git);
    $repos = $connector->getRepos();
    
    return $response->withJson($repos);
});

$app->get('/repo/{repo}', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->git);
    $repo = $connector->getRepo($args['repo']);
    
    return $response->withJson($repo);
});

$app->get('/repo/{repo}/branches', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->git);
    $branches = $connector->getBranches($args['repo']);
    
    return $response->withJson($branches);
});

$app->get('/repo/{repo}/branch/{branch}', function (Request $request, Response $response, array $args) use ($app) {
    $connector = Connector::getInstance($this->git);
    $branch = $connector->getBranch($args['repo'], $args['branch']);
    
    return $response->withJson($branch);
});