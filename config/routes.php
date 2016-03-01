<?php
use Cake\Routing\Router;

//Router::plugin(
//    'Users',
//    ['path' => '/users'],
//    function ($routes) {
//        $routes->fallbacks('DashedRoute');
//    }
//);

//Router::prefix('dashboard', function ($routes) {
//    $routes->plugin('Users', function ($routes) {
//        $routes->connect('/:controller');
//    });
//    $routes->extensions(['json', 'xml']);
//    Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'dashboard']); // because crud (might remove)
//    $routes->fallbacks('DashedRoute');
//});
//
//Router::prefix('api', function ($routes) {
//    $routes->plugin('Users', function ($routes) {
//        $routes->connect('/:controller');
//    });
//    $routes->extensions(['json', 'xml']);
//    Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
//    $routes->fallbacks('InflectedRoute');
//});