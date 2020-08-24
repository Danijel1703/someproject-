<?php

require 'vendor/autoload.php';

$app = new App\App;

$container = $app->getContainer();

$container['errorHandler'] = function() {
    return function($response) {
        return $response->setBody('Page not found')->withStatus('404');
    };
};

$container['config'] = function() {
    return [
        'db_driver' => 'mysql',
        'db_host' => 'localhost',
        'db_name' => 'project',
        'db_user' => 'inchoo',
        'db_password' => 'password'
    ];
};

$container['db'] = function($c) {
    return new \PDO($c->config['db_driver'].':host='.$c->config['db_host'].';dbname='. $c->config['db_name'],
    $c->config['db_user'],
    $c->config['db_password']);
};


$app->get('/', [new App\Controllers\HomeController, 'index']);
$app->get('/contact', [new App\Controllers\HomeController, 'index']);

$app->get('/users', [new App\Controllers\UserController($container->db), 'index']);

echo 'Test';
$app->run();
