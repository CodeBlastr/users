<?php

namespace CodeBlastr\Users\Controller\Component;

use CakeDC\Users\Controller\Component\UsersAuthComponent;
//use CakeDC\Users\Exception\BadConfigurationException;
//use Cake\Controller\Component;
//use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Routing\Router;
//use Cake\Utility\Hash;

class UsersAuthComponent extends UsersAuthComponent
{

    /**
     * Check Public Access
     *
     * ### Usage
     * Add this to your AppController
     * ```php
     * public function beforeFilter(Event $event) {
     *     $this->UsersAuth->isPublicAuthorized($event);
     * }
     * ```
     *
     * Your permssions config should return '*' or 'public' for roles allowed.
     *
     * Ex. In permissions.php for SimpleRbacAuthorize
     * ```php
     * 'Users.SimpleRbac.permissions' => [
     *     [
     *         'role' => '*',
     *         'controller' => ['Pages'],
     *         'action' => ['other', 'display'],
     *         'allowed' => true,
     *     ]];
     *
     * @param Event $event
     * @return bool
     */
    public function isPublicAuthorized(Event $event)
    {
        $isAuthorized = null;
        if (empty($this->_registry->getController()->Auth->user())) {
            $controller = $event->subject();
            $isAuthorized = $this->_registry->getController()->Auth->isAuthorized(['role' => 'public'], $controller->request);
            if ($isAuthorized === true) {
                $this->_registry->getController()->Auth->allow();
            }
        }
        return $isAuthorized;
    }
}
