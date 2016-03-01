<?php

use Cake\Routing\Router;


Router::plugin('CodeBlastr/Users', ['path' => '/users'], function ($routes) {
    $routes->resources('CodeBlastr/Users');
    //Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
    $routes->fallbacks('DashedRoute');
});

/**
 * Rest api tutorial
 * @url http://www.bravo-kernel.com/2015/04/how-to-build-a-cakephp-3-rest-api-in-minutes/
 * @url http://www.bravo-kernel.com/2015/04/how-to-add-jwt-authentication-to-a-cakephp-3-rest-api/
 */
Router::prefix('api', function ($routes) {
    $routes->plugin('CodeBlastr/Users', ['path' => '/users'], function ($routes) {
        $routes->extensions(['json', 'xml']);
        $routes->resources('CodeBlastr/Users');
        //Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
        $routes->fallbacks('DashedRoute');
    });
    $routes->fallbacks('DashedRoute');
});

Router::prefix('dashboard', function ($routes) {
    $routes->plugin('CodeBlastr/Users', ['path' => '/users'], function ($routes) {
        $routes->fallbacks('DashedRoute');
    });
    $routes->fallbacks('DashedRoute');
});

Router::plugin('CodeBlastr/Users', ['path' => '/users'], function ($routes) {
    $routes->resources('CodeBlastr/Users');
    //Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
    $routes->fallbacks('DashedRoute');
});
