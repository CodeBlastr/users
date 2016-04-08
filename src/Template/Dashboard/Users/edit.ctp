<?php
@$contextMenu['append'] .= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'active disabled list-group-item']);
@$contextMenu['append'] .= $this->Form->postLink(('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn-danger list-group-item']);
@$contextMenu['append'] .= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'list-group-item']);
@$contextMenu['append'] .= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item']);

$this->set('contextMenu', $contextMenu);
?>

<div class="users form columns row">
    <div class="col-sm-8">
        <?= $this->Form->create($user); ?>
        <fieldset>
            <legend><?= __('Edit User') ?></legend>
            <?php
            echo $this->Form->input('name');
            echo $this->Form->input('email', ['require' => true, 'type' => 'email']);
            echo $self === true ? $this->Form->input('password', ['value' => false]) : null;
            echo $this->Form->input('active', ['label' => 'Allow login?']);
            echo $this->Form->input('notify', ['type' => 'radio', 'options' => ['yes' => 'yes', 'no' => 'no']]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>