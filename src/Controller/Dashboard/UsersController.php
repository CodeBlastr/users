<?php
namespace CodeBlastrUsers\Controller\Dashboard;

use App\Controller\AppController;
use CodeBlastrUsers\Model\Table;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    use \Crud\Controller\ControllerTrait;

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

    public function edit()
    {
        $users = TableRegistry::get('CodeBlastrUsers.Users');
        $this->set('roles', $roles = $users->find('roles'));
        return $this->Crud->execute();
    }
}