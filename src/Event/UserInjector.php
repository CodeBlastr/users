<?php
namespace CodeBlastr\Users\Event;

use Cake\Event\EventListenerInterface;
//use Cake\Controller\Component\AuthComponent;

/**
 * Class UserInjector
 *
 * Store events that inject functionality into existing cakedc methods here.
 */
class UserInjector implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Users.Component.UsersAuth.beforeLogin' => 'upgradeRedirect',
        ];
    }

    public function upgradeRedirect($event)
    {
        if ($event->subject()->Auth->user) {
            debug('yup');
            exit;
        }
    }
}