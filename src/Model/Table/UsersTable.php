<?php

namespace CodeBlastr\Users\Model\Table;

//use CodeBlastr\Users\Model\Entity\User;
///use Cake\ORM\Query;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

use Cake\Database\Schema\Table as Schema;


class UsersTable extends Table
{

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
        $this->displayField('id');
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

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

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
        $rules->add($rules->isUnique(['username']));
        return $rules;
    }

    /**
     * Before Save Callback
     *
     * If tos is incoming, changes it to the actual db column name and timestamp
     *
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!empty($entity->tos)) {
            $entity->tos_date = Time::now();
            unset($entity->tos);
        }
        if (!empty($entity->name)) {
            $entity->first_name = $this->_splitName($entity->name, 2);
            $entity->last_name = $this->_splitName($entity->name, 3);
            unset($entity->name);
        }
        if ($entity->isNew() && empty($entity->email) && !empty($entity->username)) {
            $entity->email = $entity->username;
        }
        if ($entity->isNew() && empty($entity->username) && !empty($entity->email)) {
            $entity->username = $entity->email;
        }
        return true;
    }

    /**
     * Split name method
     * turn a string into first name and last name
     *
     * @url http://stackoverflow.com/questions/8808902/best-way-to-split-a-first-and-last-name-in-php
     * @param $str
     */
    protected function _splitName($str, $position = 2) {
        // 0 full name string
        // 1 prefix (eg. Mr.)
        // 2 first name
        // 3 last name
        // 4 suffix (eg. Jr.)

        $results = array();
        preg_match('#^(\w+\.)?\s*([\'\’\w]+)\s+([\'\’\w]+)\s*(\w+\.?)?$#', $str, $results);
        return $results[$position];
    }

}