<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

define('BASE_PATH', realpath(__DIR__));
define('PRIVATE_PATH', realpath(BASE_PATH . '/../private/'));

session_start();

//ini_set('display_errors', 0);

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

// if ($settings['settings']['mode'] == 'development') {
//     error_reporting(E_ALL);
// } else {
//     error_reporting(E_ALL & ~E_NOTICE & ~E_ERROR);
// }

$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
