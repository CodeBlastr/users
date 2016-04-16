<?php

namespace CodeBlastrUsers\Model\Table;

//use CodeBlastrUsers\Model\Entity\User;
use Cake\ORM\Query;
use CakeDC\Users\Model\Table\UsersTable;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;
use Cake\Utility\Hash;
use Cake\Mailer\Email;

use Cake\Database\Schema\Table as Schema;


class UsersTable extends UsersTable
{
    /**
     * Is this user being created by someone besides themselves?
     *
     * @var bool
     */
    public $procreate = false;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
    }

    /**
     * Initialize Schema
     *
     * @param Schema $schema
     * @return Schema
     */
    protected function _initializeSchema(Schema $schema)
    {
        $schema->columnType('data', 'json');
        return $schema;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        // we don't require a password, because if there isn't one we'll generate one
//        $validator
//            ->requirePresence('password', 'create')
//            ->allowEmpty('password');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username', 'message' => 'Username is already being used']);
        return $rules;
    }

    /**
     * Before Marshal callback
     * Event is fired before request data is converted into entities
     *
     * 1. split the name field into first_name, last_name
     * 2. remove the password field so we don't clear someone's password by accident
     * 3. If tos is incoming, changes it to the actual db column name and timestamp
     *
     * @param Event $event
     * @param ArrayObject $data
     * @param ArrayObject $options
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        if (!empty($data['name'])) {
            $data['first_name'] = $this->_splitName($data['name'], 2);
            $data['last_name'] = $this->_splitName($data['name'], 3);
            unset($data['name']);
        }
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        }
        if (!empty($data['tos'])) {
            $data['tos_date'] = Time::now();
            unset($data['tos']);
        }
        return $data;
    }

    /**
     * Before Save Callback
     *
     * 1. make the email equal the username if email is empty and it's a new entry
     * 2. make the username the email if the username is empty and it's a new entry
     * 3. create a password if it is empty and it's a new entry
     *
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() && empty($entity->email) && !empty($entity->username)) {
            $entity->email = $entity->username;
        }
        if ($entity->isNew() && empty($entity->username) && !empty($entity->email)) {
            $entity->username = $entity->email;
        }
        if ($entity->isNew() && empty($entity->password)) {
            if ($entity->active === true) {
                $this->procreate = true;
            }
            $entity->password = $this->_randomPassword();
        }
        return true;
    }

    /**
     * After save callback
     * 2. If no password, and active is true then email a link to create a password
     *
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($this->procreate === true) {
            $email = new Email();
            $email = $email->template('default', 'default')
                ->to('test@example.com')
                ->subject('About')
                ->send();
            debug($email);
            exit;
        }

        debug('well it is after');
        exit;
    }

    /**
     * Split name method
     * turn a string into first name and last name
     *
     * @url http://stackoverflow.com/questions/8808902/best-way-to-split-a-first-and-last-name-in-php
     * @param $str
     */
    protected function _splitName($str, $position)
    {
        // 0 full name string
        // 1 prefix (eg. Mr.)
        // 2 first name
        // 3 last name
        // 4 suffix (eg. Jr.)

        $results = array();
        preg_match('#^(\w+\.)?\s*([\'\’\w]+)\s+([\'\’\w]+)\s*(\w+\.?)?$#', $str, $results);
        return !empty($results[$position]) ? $results[$position] : $str;
    }

    /**
     * Get distinct roles as a list
     *
     * #Usage
     * $users = TableRegistry::get('CodeBlastrUsers.Users');
     * $roles = $users->find('roles');
     *
     * @param Query $query
     * @param array $options
     * @return mixed
     */
    public function findRoles(Query $query, array $options)
    {
        $roles = $this->find()->select('role')->distinct('role')->extract('role')->toArray();
        return Hash::combine($roles, '{n}', '{n}');
    }

    /**
     * Random string generator
     *
     * @return string
     * @todo maybe this should be a utility function??
     */
    public function _randomPassword() {
        $pass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'),0,5);
        $pass .= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0,5);
        $pass .= substr(str_shuffle('012*345$6789!'),0,5);
        $pass = substr(str_shuffle($pass),0,12);
        return $pass;
    }


}