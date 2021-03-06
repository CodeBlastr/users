
<?php
@$contextMenu['append'] .= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item']);
@$contextMenu['append'] .= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'list-group-item']);
@$contextMenu['append'] .= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'list-group-item']);
@$contextMenu['append'] .= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn-danger list-group-item']);

$this->set('contextMenu', $contextMenu);
?>
<div class="users view columns">
    <h2><?= h($user->name) ?></h2>
    <div class="row">
        <div class="col-lg-5 columns strings">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Id') ?></h6>
                    <p><?= h($user->id) ?></p>
                    <h6 class="subheader"><?= __('Username') ?></h6>
                    <p><?= h($user->username) ?></p>
                    <h6 class="subheader"><?= __('Email') ?></h6>
                    <p><?= h($user->email) ?></p>
                    <h6 class="subheader"><?= __('Password') ?></h6>
                    <p><?= h($user->password) ?></p>
                    <h6 class="subheader"><?= __('First Name') ?></h6>
                    <p><?= h($user->first_name) ?></p>
                    <h6 class="subheader"><?= __('Last Name') ?></h6>
                    <p><?= h($user->last_name) ?></p>
                    <h6 class="subheader"><?= __('Token') ?></h6>
                    <p><?= h($user->token) ?></p>
                    <h6 class="subheader"><?= __('Api Token') ?></h6>
                    <p><?= h($user->api_token) ?></p>
                    <h6 class="subheader"><?= __('Role') ?></h6>
                    <p><?= h($user->role) ?></p>
                    <h6 class="subheader"><?= __('Data') ?></h6>
                    <p><?= h($user->data) ?></p>
                    <h6 class="subheader"><?= __('Creator Id') ?></h6>
                    <p><?= h($user->creator_id) ?></p>
                    <h6 class="subheader"><?= __('Modifier Id') ?></h6>
                    <p><?= h($user->modifier_id) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns dates end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Token Expires') ?></h6>
                    <p><?= h($user->token_expires) ?></p>
                    <h6 class="subheader"><?= __('Activation Date') ?></h6>
                    <p><?= h($user->activation_date) ?></p>
                    <h6 class="subheader"><?= __('Tos Date') ?></h6>
                    <p><?= h($user->tos_date) ?></p>
                    <h6 class="subheader"><?= __('Created') ?></h6>
                    <p><?= h($user->created) ?></p>
                    <h6 class="subheader"><?= __('Modified') ?></h6>
                    <p><?= h($user->modified) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 columns booleans end">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h6 class="subheader"><?= __('Active') ?></h6>
                    <p><?= $user->active ? __('Yes') : __('No'); ?></p>
                    <h6 class="subheader"><?= __('Is Superuser') ?></h6>
                    <p><?= $user->is_superuser ? __('Yes') : __('No'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
