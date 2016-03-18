<?php
namespace CodeBlastr\Users\Test\TestCase\Model\Table;

use CodeBlastr\Users\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \CodeBlastr\Users\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.CodeBlastr/Users.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'CodeBlastr\Users\Model\Table\UsersTable'];
        $this->Users = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
    }

    public function testNothing() {
        $this->assertTrue(true);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {

        $tableName = $this->Users->table();
        $this->assertTrue($tableName === 'users');
    }

    /**
     * Test testSave_no_password method
     *
     * @return void
     */
    public function testSave_no_password()
    {
        $data = ['username' => 'something@something.com'];
        $user = $this->Users->newEntity($data);
        $this->assertTrue(!empty($user->errors()));
        $this->assertTrue($this->Users->save($user) === false);
    }

    /**
     * Test testSave method
     *
     * @return void
     */
    public function testSave()
    {
        $data = ['username' => 'something@something.com', 'password' => 'Test123'];
        $user = $this->Users->newEntity($data);
        $this->assertTrue(empty($user->errors()));
        $this->Users->save($user);
        $this->assertTrue(!empty($user->id));
    }
}
