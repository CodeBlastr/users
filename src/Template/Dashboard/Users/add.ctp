
<?php
    @$contextMenu['append'] .= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'active disabled list-group-item']);
    @$contextMenu['append'] .= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item']);

$this->set('contextMenu', $contextMenu);
?>

<div class="users form columns row">
    <div class="col-sm-8">
        <?= $this->Form->create($user); ?>
        <fieldset>
            <legend><?= __('Add User') ?></legend>
            <?php
                echo $this->Form->input('role', ['type' => 'hidden']);
                echo $this->Form->input('name', ['label' => 'Name']);
                echo $this->Form->input('email', ['require' => true, 'type' => 'email']);
                echo $this->Form->input('password');
                echo $this->Form->input('active');
                echo $this->Form->input('is_superuser');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
