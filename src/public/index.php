<?php

use App\App;
use App\Config;
use App\Controllers\CallDetailsController;
use App\Controllers\CallHeaderController;
use App\Controllers\HomeController;
use App\Models\CallDetail;
use App\Router;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

define('VIEW_PATH', __DIR__ . '/../views');

$router = new Router;
/**
 * Register all routes here
 */
$router->get('/', [HomeController::class, 'index'])
->post('/call-header/create', [CallHeaderController::class, 'create'])
->post('/call-header/delete', [CallHeaderController::class, 'delete'])
->post('/call-details/create', [CallDetailsController::class, 'create'])
->post('/call-details/delete', [CallDetailsController::class, 'delete'])
->get('/call-header/search', [CallHeaderController::class, 'search']);

(new App(
  $router, 
  ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
  new Config($_ENV)
))->run();
