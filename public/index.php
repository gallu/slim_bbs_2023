<?php
// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

ob_start();

// 基準になるディレクトリ(最後の / はない形式で)
if (false === defined('BASEPATH')) {
    define('BASEPATH', realpath(__DIR__ . '/..'));
}

// Create Container using PHP-DI
$container = new Container();

// configっぽいものを設定
$config = array_merge_recursive(require(BASEPATH . '/config/config.php'), require(BASEPATH . '/config/by_environment_config.php') );
$container->set('settings', $config);

// Set container to create App with on AppFactory
AppFactory::setContainer($container);
$app = AppFactory::create();

// container への追加設定
$dependencies = require(BASEPATH . '/config/dependencies.php');
$dependencies($container, $app);

// ルーティングの読み込み
require __DIR__ . '/../config/routes.php';

// XXX いったん雑に例外を把握
try {
    $app->run();
} catch(\Throwable $e) {
    echo $e->getMessage();
}

// var_dump(memory_get_peak_usage(true));
