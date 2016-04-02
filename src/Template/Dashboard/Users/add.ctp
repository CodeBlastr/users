
<?php
    @$contextMenu['append'] .= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'active disabled list-group-item']);
    @$contextMenu['append'] .= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item']);

$this->set('contextMenu', $contextMenu);
?>

<div class="users form columns">
    <?= $this->Form->create($user); ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('first_name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('token');
            echo $this->Form->input('token_expires', ['type' => 'datepicker']);
            echo $this->Form->input('api_token');
            echo $this->Form->input('activation_date', ['type' => 'datetimepicker']);
            echo $this->Form->input('tos_date', ['type' => 'timepicker']);
            echo $this->Form->input('active');
            echo $this->Form->input('is_superuser');
            echo $this->Form->input('role');
        ?>
    </fieldset>

    <div class="container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' data-datepicker="true">
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' data-timepicker="true">
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->button(__('Submit'), ['class' => 'btn-success']) ?>
    <?= $this->Form->end() ?>
</div>
