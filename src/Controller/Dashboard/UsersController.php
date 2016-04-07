<?php
namespace CodeBlastrUsers\Controller\Dashboard;

use App\Controller\AppController;
use CodeBlastrUsers\Model\Table;
use Cake\Core\Configure;

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
        return parent::implementedEvents() + ['Crud.beforeRender' => '_edit'];
    }

    /**
     * Modify the template file name
     *
     * @param $event
     */
    public function _edit($event)
    {
        if ($role = $event->subject()->entity->role) {
            $this->Crud->action()->view($this->templateExists($this->viewBuilder(), ['suffix' => "_$role", 'plugin' => 'CodeBlastrUsers', 'templatePath' => 'Dashboard/Users', 'templateName' => 'edit']));
        }
    }
}