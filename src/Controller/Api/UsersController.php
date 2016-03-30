<?php
namespace CodeBlastr\Users\Controller\Api;

//use CodeBlastr\Users\Controller\Api\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\UnauthorizedException;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'token']);
    }

    public function add()
    {
        // eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI3NDhjOWY0ZC1kYmY3LTRmMzgtODYyZi03ZTViMGE5OTBjNzkiLCJleHAiOjE0NTgyNzMyODd9.BelqElDZILatGypDVqw4Hh6EFZj5qMt2LzNBDftwsNk
        $this->Crud->on('afterSave', function (Event $event) {
            if ($event->subject->created) {
                $this->set('data', [
                    'id' => $event->subject->entity->id,
                    'token' => JWT::encode(
                        [
                            'sub' => $event->subject->entity->id,
                            'exp' => time() + 604800 // even though this is not required we are adding the JWT exp claim to the token payload so the token will expire after one week, effectively forcing the user to request a new unique token using the /token action.
                        ],
                        Security::salt())
                ]);
                $this->Crud->action()->config('serialize.data', 'data');
            }
        });
        return $this->Crud->execute();
    }

    public function customers() {
        $this->set('users', $this->Users->find('all'));
    }

    /**
     * Token
     */
    public function token()
    {
        $user = $this->Auth->identify();
        if (!$user) {
            throw new UnauthorizedException('Invalid username or password, or user is not active.');
        }

        $this->set([
            'success' => true,
            'data' => [
                'token' => JWT::encode([
                    'sub' => $user['id'],
                    'exp' => time() + 604800 // 1 week
                    //'exp' => time() + 60 // 1 minute
                ],
                    Security::salt())
            ],
            '_serialize' => ['success', 'data']
        ]);
    }
}