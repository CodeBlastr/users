<?php

use Cake\Routing\Router;


/**
 * Rest api tutorial
 * @url http://www.bravo-kernel.com/2015/04/how-to-build-a-cakephp-3-rest-api-in-minutes/
 * @url http://www.bravo-kernel.com/2015/04/how-to-add-jwt-authentication-to-a-cakephp-3-rest-api/
 */
Router::prefix('api', function ($routes) {
    $routes->extensions(['json', 'xml']);
    $routes->resources('CodeBlastr/Users');
    //Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
    $routes->fallbacks('DashedRoute');
});

Router::plugin('CodeBlastr/Users', ['path' => '/dashboard'], function ($routes) {
    $routes->fallbacks('DashedRoute');
});

//Router::plugin('CodeBlastr/Users', function ($routes) {
//    $routes->path('/profiles');
//    $routes->prefix('dashboard', function ($routes) {
//        $routes->connect('/:controller');
//    });
//});

//Router::prefix('dashboard', function ($routes) {
//    $routes->plugin('CodeBlastr/Users', function ($routes) {
//        $routes->connect('/:controller');
//    });
//    $routes->extensions(['json', 'xml']);
//    Router::connect('/api/profiles/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'dashboard']); // because crud (might remove)
//    $routes->fallbacks('DashedRoute');
//});
//
//Router::prefix('api', function ($routes) {
//    $routes->plugin('CodeBlastr/Users', function ($routes) {
//        $routes->connect('/:controller');
//    });
//    $routes->extensions(['json', 'xml']);
//    Router::connect('/api/profiles/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
//    $routes->fallbacks('InflectedRoute');
//});