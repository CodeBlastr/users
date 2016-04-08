<?php
namespace CodeBlastrUsers\Controller\Dashboard;

use App\Controller\AppController;
use CodeBlastrUsers\Model\Table;
use Cake\Core\Configure;
use Cake\Utility\Hash;

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

    public function implementedEvents()
    {
        return parent::implementedEvents() + ['Crud.beforeRender' => '_beforeRender'];
    }

    /**
     * Modify the template file name
     *
     * @param $event
     * @todo Maybe 'staff' needs to be some kind of config setting?
     */
    public function _beforeRender($event)
    {
        if ($this->request->action === 'edit') {

            $this->viewVars['self'] = false;
            if ($this->request->session()->read('Auth.User.id') === $event->subject()->id) {
                $this->viewVars['self'] = true;
            }

            $this->viewVars['isSuperuser'] = false;
            if ($this->request->session()->read('Auth.User.is_superuser')) {
                $this->viewVars['isSuperuser'] = true;
            }

            $this->viewVars['reps'] = Hash::combine($event->subject()->repository->findByRole('staff')->toArray(), '{n}.id', '{n}.name');

            if ($role = $event->subject()->entity->role) {
                $this->Crud->action()->view($this->templateExists($this->viewBuilder(), ['suffix' => "_$role", 'plugin' => 'CodeBlastrUsers', 'templatePath' => 'Dashboard/Users', 'templateName' => 'edit']));
            }

        }
    }
}