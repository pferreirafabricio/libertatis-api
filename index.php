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

/**
 * ROUTES
 */
$router->namespace('Source\Controllers');

$router->group('players');
$router->get('/', 'PlayerController@index');
$router->get('/{nick}', 'PlayerController@show');
$router->post('/', 'PlayerController@create');
$router->put('/', 'PlayerController@update');

$router->group('players/history');
$router->get('/{nick}', 'PlayerController@index');
$router->put('/', 'PlayerController@update');

$router->dispatch();
