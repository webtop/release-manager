<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Classes\Connector;
use Classes\Config;
use Classes\Common;
use Config\GitLabConfig;
use Config\GitHubConfig;
use Library\GitFascade;

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
    
    return true;
});

$app->post('/test-connection', function(Request $request, Response $response, array $args) use($app) {
    $withAuth = false;
    
    if ($request->getParam('git-source-select') == 'gitlab') {
        $gitConfig = new GitLabConfig();
    } else {
        $gitConfig = new GitHubConfig();
    }
    
    $gitConfig->setApiUrl($request->getParam('git-api-url'));
    if (!empty($request->getParam('git-source-auth'))) {
        $gitConfig->setAuthMethod($request->getParam('git-source-auth'));
        $withAuth = true;
    }
    
    if ($withAuth) {
        switch ($request->getParam('git-source-auth')) {
            case 'user-pass':
                $gitConfig->setAuthCredentials([
                    'username' => $request->getParam('git-auth-username'),
                    'password' => $request->getParam('git-auth-password')
                ]);
                break;
            case 'access-token':
                $gitConfig->setToken($request->getParam('git-auth-token'));
                break;
            case 'oauth':
                $gitConfig->setAuthCredentials([
                    'app-id' => $request->getParam('git-auth-app-id'),
                    'app-secret' => $request->getParam('git-auth-secret')
                ]);
                break;
        }
    }
    
    $connectResult = GitFascade::getInstance($gitConfig)->connect($withAuth);
    
    return $response->withJson($connectResult);
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