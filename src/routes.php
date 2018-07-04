<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Classes\Connector;
use Classes\Config;

/**
 * ========================
 *  Renderable routes
 * ========================
 */
$app->get('/', function (Request $request, Response $response, array $args) {
    $viewArgs = [
        'pageTitle' => 'Release Manager'
    ];
    return $this->view->render($response, 'index.phtml', $viewArgs);
});

$app->get('/config', function(Request $request, Response $response, array $args) use ($app) {
    //$config = new Config($request, $response, $args);
    // $configData = $config->getBaseConfig($app);
    return $this->view->render($response, 'config.phtml', $args);
});



/**
 * ========================
 *  API routes to get data
 * ========================
 */
$app->get('/repos', function (Request $request, Response $response, array $args) use ($app) {
    $repos = $this->connector->getRepos();
    return $response->withJson($repos);
});

$app->get('/repo/{repo}', function (Request $request, Response $response, array $args) use ($app) {
    $repo = $this->connector->getRepo($args['repo']);
    return $response->withJson($repo);
});

$app->get('/repo/{repo}/branches', function (Request $request, Response $response, array $args) use ($app) {
    $branches = $this->connector->getBranches($args['repo']);
    return $response->withJson($branches);
});

$app->get('/repo/{repo}/branch/{branch}', function (Request $request, Response $response, array $args) use ($app) {
    $branch = $this->connector->getBranch($args['repo'], $args['branch']);
    return $response->withJson($branch);
});