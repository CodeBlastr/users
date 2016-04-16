<?php
namespace CodeBlastrUsers\Controller\Dashboard;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use CodeBlastrUsers\Model\Entity\User;
use CodeBlastrUsers\Model\Table;
use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\Event\Event;

class UsersController extends AppController
{
    use \Crud\Controller\ControllerTrait;
    use \CodeBlastrUsers\Traits\UtilityTrait;

    /**
     * Permissions management turned on
     *
     * @var bool
     */
    public $permissions = true;

    /**
     * Paginate settings
     *
     * @var array
     */
    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 100,
//        'fields' => [
//            'id', 'first_name', 'username', 'active', 'created'
//        ],
//        'sortWhitelist' => [
//            'id', 'username'
//        ]
    ];

    public function initialize()
    {
        //$this->loadComponent('CakeDC/Users.UsersAuth');
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ]
        ]);
        parent::initialize();
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|null
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        $this->Crud->on('setFlash', function ($event) {
            unset($event->subject->params['class']);
            $event->subject->element = ltrim($event->subject->type);
        });
        return parent::beforeFilter($event);
    }

    public function add()
    {
        $this->viewVars['isSuperuser'] = false;
        if ($this->request->session()->read('Auth.User.is_superuser')) {
            $this->viewVars['isSuperuser'] = true;
        }

        $this->Crud->on('beforeRender', function (Event $event) {
            $this->viewVars['reps'] = Hash::combine(TableRegistry::get('CodeBlastrUsers.Users')->findByRole('staff')->toArray(), '{n}.id', '{n}.name');
            if ($role = $this->request->query['role']) {
                $this->Crud->action()->view($this->templateExists($this->viewBuilder(), ['suffix' => "_$role", 'plugin' => 'CodeBlastrUsers', 'templatePath' => 'Dashboard/Users', 'templateName' => $this->request->action]));
            }
        });
        $this->Crud->execute();
    }

    public function edit($id = null)
    {
        $this->viewVars['self'] = false;
        if ($this->request->session()->read('Auth.User.id') === $id) {
            $this->viewVars['self'] = true;
        }

        $this->viewVars['isSuperuser'] = false;
        if ($this->request->session()->read('Auth.User.is_superuser')) {
            $this->viewVars['isSuperuser'] = true;
        }

        $this->Crud->on('beforeRender', function (Event $event) {
            $this->viewVars['reps'] = Hash::combine($event->subject()->repository->findByRole('staff')->toArray(), '{n}.id', '{n}.name');

            if ($role = $event->subject()->entity->role) {
                $this->Crud->action()->view($this->templateExists($this->viewBuilder(), ['suffix' => "_$role", 'plugin' => 'CodeBlastrUsers', 'templatePath' => 'Dashboard/Users', 'templateName' => $this->request->action]));
            }
        });
        return $this->Crud->execute();
    }

    /**
     * @return array
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + ['Crud.beforeRender' => '_beforeRender'];
    }
}