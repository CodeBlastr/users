<?php
namespace CodeBlastrUsers\Event;

use Cake\Event\EventListenerInterface;
use Cake\Network\Request;

/**
 * Class DashboardListener
 * @package CodeBlastrUsers\Event
 * @todo Need to make a test unit for this.
 */
class DashboardListener implements EventListenerInterface {

    public function implementedEvents() {
        return array(
            'View.beforeRender' => 'viewBeforeDashboardIndex',
            'Controller.beforeRender' => 'controllerBeforeDashboardIndex'
        );
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function controllerBeforeDashboardIndex(\Cake\Event\Event $event) {
        $controller = $event->subject();
        if ($controller->name === 'Dashboard') {
            // set this here and remove in the view instead of just removing
            // it completely because we'll want to add more permissions checks
            // maybe a complete output of config/permissions.php
            // so that we can show individual links on the dashboard that the
            // user has access to
            $controller->set('auth', $controller->Auth->isAuthorized($controller->Auth->user(), new Request(['params' => ['plugin' => 'CodeBlastrUsers', 'controller' => 'Users', 'action' => 'index']])));
        }
    }

    /**
     * @param \Cake\Event\Event $event
     * @param $viewFileName
     */
    public function viewBeforeDashboardIndex(\Cake\Event\Event $event, $viewFileName) {
        $view = $event->subject();
        if ($view->request->here === '/dashboard') {
            $view->append('tiles.top', $event->subject()->element('CodeBlastrUsers.Dashboard/tile'));
        }
    }
}