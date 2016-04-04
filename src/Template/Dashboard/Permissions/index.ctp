<?php

//debug($settings);
//debug($permissions);
//debug($roles);


@$sidebar['append'] .= $this->Html->link(__('List Users'), ['controller' => 'users', 'action' => 'index'], ['class' => 'list-group-item']);
@$sidebar['append'] .= $this->Html->link(__('List Permissions'), ['action' => 'index'], ['class' => 'list-group-item disabled active']);

$this->set('sidebar', $sidebar);

?>

<div class="permissions index columns">
    <div class="table-responsive">
        <?= $this->Form->create() ?>
            <table class="table table-striped table-condensed table-hover">
                <?php $i = 0; ?>
                <?php foreach ($permissions as $plugin => $controller) : ?>
                    <thead>
                        <tr>
                            <th>
                                <?= !empty($plugin) ? $plugin : 'App'; ?>
                            </th>
                            <?php foreach ($roles as $role) : ?>
                                <th><?= $role ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <?php foreach ($controller as $name => $actions) : ?>
                        <tbody>
                            <tr>
                                <td class="warning" colspan="<?= count($roles)+1 ?>"><?= str_replace('Controller', '', $name); ?></td>
                            </tr>
                            <?php foreach ($actions as $action) : ?>
                                <tr>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $action; ?></td>
                                    <?php foreach ($roles as $role) : ?>
                                        <td>
                                            <?= $this->Form->input('permission.' . $i . '.plugin', ['value' => $plugin, 'type' => 'hidden']) ?>
                                            <?= $this->Form->input('permission.' . $i . '.controller', ['value' => str_replace('Controller', '', $name), 'type' => 'hidden']) ?>
                                            <?= $this->Form->input('permission.' . $i . '.action', ['value' => $action, 'type' => 'hidden']) ?>
                                            <?= $this->Form->input('permission.' . $i . '.role', ['value' => $role, 'type' => 'hidden']) ?>
                                            <?= $this->Form->input('permission.' . $i . '.allowed', ['type' => 'checkbox']) ?>
                                        </td>
                                    <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endforeach; ?>
                    <tr>
                        <td class="active text-left" colspan="<?= count($roles)+1 ?>"><?= $this->Form->submit(__('Save Permissions'), ['class' => 'btn btn-primary']) ?></td>
                    </tr>
                    <tr class="spacer">
                        <td colspan="<?= count($roles)+1 ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?= $this->Form->end() ?>
    </div>
</div>