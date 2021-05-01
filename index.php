<?php

require_once './vendor/autoload.php';
require_once './source/Core/Headers.php';

use CoffeeCode\Router\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * ROUTE CONFIG
 */
$router = new Router(env('BASE_URL'), '@');

$router->get('/hello', fn () => 'hello');

/**
 * ROUTES
 */
$router->namespace('Source\Controllers')->group('user');
$router->get('/', 'PlayerController@index');
$router->get('/{id}', 'PlayerController@getById');
$router->post('/', 'PlayerController@create');
$router->put('/{id}', 'PlayerController@update');
$router->delete('/{id}', 'PlayerController@delete');

$router->dispatch();
