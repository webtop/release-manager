<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Classes\Connector;
use Classes\Config;
use Classes\Common;
use function GuzzleHttp\json_encode;

/**
 * ========================
 *  Renderable routes
 * ========================
 */
$app->get('/', function (Request $request, Response $response, array $args) {
    if (empty($this->settings['git-source'])) {
        return $response->withRedirect('/config', 303);
    }
    $viewArgs = [
        'pageTitle' => 'Release Manager'
    ];
    
    return Common::buildView($response, $this->view, 'index.phtml', $viewArgs);
});

$app->get('/config', function(Request $request, Response $response, array $args) use ($app) {
    $configError = '';
    $configData = [];
    
    if (empty($this->settings['git-source'])) {
        $configError = 'Please set up the git source configuration';
    } else {
        $config = new Config($request, $response, $args);
        $configData = $config->getBaseConfig($app);
    }
    
    $viewArgs = [
        'pageTitle' => 'Configuration',
        'configData' => $configData,
        'configError' => $configError
    ];
    
    return Common::buildView($response, $this->view, 'config.phtml', $viewArgs);
});

$app->get('/oauth', function(Request $request, Response $response, array $args) use($app) {
    error_log($request);
    error_log($args);
    
    return true;
});

$app->post('/test-connection', function(Request $request, Response $response, array $args) use($app) {
    return json_encode([
        'success' => true
    ]);
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