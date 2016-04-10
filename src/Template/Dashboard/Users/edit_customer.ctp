<?php
/**
 * @todo This file doesn't quite work the way I'd like (because not every site will have "customers"), but need to get this platform going, and not sure how else it might work to have "many" sites but not "all" sites use this file.
 *
 */
@$contextMenu['append'] .= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'active disabled list-group-item']);
@$contextMenu['append'] .= $this->Form->postLink(('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn-danger list-group-item']);
@$contextMenu['append'] .= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'list-group-item']);
@$contextMenu['append'] .= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item']);

$this->set('contextMenu', $contextMenu);
?>

<div class="users form columns row">
    <div class="col-sm-9 col-md-7">
        <?= $this->Form->create($user); ?>
        <fieldset>
            <legend><?= __('Edit {0}', $user['name']) ?></legend>
            <?= $this->Form->input('data.company', ['label' => 'Company Name']) ?>
            <?= $this->Form->input('name', ['require' => true]) ?>
            <?= $this->Form->input('username', ['label' => 'Login Username', 'require' => true]) ?>
            <?= $this->Form->input('email', ['label' => 'Contact Email', 'require' => true, 'type' => 'email']) ?>
            <?= $self === true ? $this->Form->input('password', ['value' => false]) : null ?>
            <?= $this->Form->input('data.phone1', ['label' => 'Phone Number', 'type' => 'phone']) ?>

            <?= $this->Form->input('data.price_tier', ['options' => ['msrp' => 'MSRP', 'wholesale' => 'Wholesale']]) ?>

            <?= $this->Form->input('data.minimum_order', ['prepend' => '$']) ?>
            <?= $this->Form->input('data.payment_terms', ['append' => 'days', 'default' => 0]) ?>
            <?= $this->Form->input('data.rep') ?>

            <?= $isSuperuser === true ? $this->Form->input('active', ['label' => 'Allow login?']) : null ?>
            <?= $isSuperuser === true ? $this->Form->input('data.notify', ['type' => 'radio', 'options' => ['yes' => 'yes', 'no' => 'no']]) : null ?>

        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>