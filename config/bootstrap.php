<?php


// In config/bootstrap.php
use Cake\Database\Type;
use Cake\Core\Plugin;
use Cake\Core\Configure;
use Cake\Event\EventManager;
//use CodeBlastrUsers\Event\UserInjector;

Type::map('json', 'CodeBlastrUsers\Database\Type\JsonType');

Plugin::load('CakeDC/Users');

//use Cake\Log\Log;
//use Cake\Core\Exception\MissingPluginException;
//use Cake\Core\Plugin;
//use Cake\Event\EventManager;
//use Cake\ORM\TableRegistry;
//use Cake\Routing\Router;


Configure::load('CakeDC/Users.users');
collection((array)Configure::read('Users.config'))->each(function ($file) {
    Configure::load($file);
});

// Attach the UserInjector object to the User's event manager
//$injector = new UserInjector();
//EventManager::instance()->on($injector);


//if (Configure::check('Users.auth')) {
//    Configure::write('Auth.authenticate.all.userModel', Configure::read('Users.table'));
//}
//
//if (Configure::read('Users.Social.login') && php_sapi_name() != 'cli') {
//    try {
//        EventManager::instance()->on(\CakeDC\Users\Controller\Component\UsersAuthComponent::EVENT_FAILED_SOCIAL_LOGIN, [new \CakeDC\Users\Controller\UsersController(), 'failedSocialLoginListener']);
//    } catch (MissingPluginException $e) {
//       Log::error($e->getMessage());
//    }
//}
//
//$oauthPath = Configure::read('OAuth.path');
//if (is_array($oauthPath)) {
//    Router::scope('/auth', function ($routes) use ($oauthPath) {
//        $routes->connect(
//            '/:provider',
//            $oauthPath,
//            ['provider' => implode('|', array_keys(Configure::read('OAuth.providers')))]
//        );
//    });
//}