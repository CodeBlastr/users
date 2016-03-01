<?php

namespace CodeBlastr\Users\Controller\Dashboard;

use App\Controller\AppController;
use CodeBlastr\Users\Model\Table;
use Cake\Event\Event;

class UsersController extends AppController
{
    use \Crud\Controller\ControllerTrait;

    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 100,
        'fields' => [
            'id', 'username', 'active', 'created'
        ],
        'sortWhitelist' => [
            'id', 'username'
        ]
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

}