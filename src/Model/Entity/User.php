<?php

namespace CodeBlastrUsers\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property bool $active
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class User extends Entity
{
    protected $_virtual = ['name', 'reverse_name'];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'token',
        'tos_date',
        'is_superuser'
    ];

    /**
     * Cake's powerful hashing algorithm
     *
     * @param $password
     * @return bool|string
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    protected function _getName()
    {
        return @$this->_properties['first_name'] . ' ' . @$this->_properties['last_name'];
    }

    protected function _getReverseName()
    {
        return !empty($this->_properties['first_name']) && !empty($this->_properties['last_name']) ? $this->_properties['last_name'] . ', ' .  $this->_properties['first_name'] : $this->_getName();
    }
}
