<?php

namespace CodeBlastr\Users\Controller\Component;

use CakeDC\Users\Controller\Component\UsersAuthComponent;
//use CakeDC\Users\Exception\BadConfigurationException;
//use Cake\Controller\Component;
use Cake\Core\Configure;
//use Cake\Event\Event;
//use Cake\Network\Request;
//use Cake\Routing\Router;
//use Cake\Utility\Hash;

class UsersAuthComponent extends UsersAuthComponent
{

    /**
     * Overwritten to add the isPublicAuthorized()
     * @todo This and isPublicAuthorized() have been submitted as a pull request to CakeDC/Users. Will probably remove both in the future.
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        if (Configure::read('Users.publicAcl')) {
            $this->isPublicAuthorized();
        }
    }


    /**
     * Check Public Access
     *
     * ### Usage
     *
     * Your permssions config should return '*' or 'public' for role(s) allowed.
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
     * @return bool
     */
    public function isPublicAuthorized()
    {
        $isAuthorized = null;
        if (empty($this->_registry->getController()->Auth->user())) {
            $controller = $this->_registry->getController();
            $isAuthorized = $controller->Auth->isAuthorized(['role' => 'public'], $controller->request);
            if ($isAuthorized === true) {
                $this->_registry->getController()->Auth->allow();
            }
        }
        return $isAuthorized;
    }
}
