<?php if (!empty($auth)) : ?>
    <div class="col-md-4">
        <h3>User Management</h3>
        <hr>
        <div class="list-group">
            <a class="list-group-item" href="<?= $this->Url->build(['prefix' => 'dashboard', 'plugin' => 'CodeBlastrUsers', 'controller' => 'Users', 'action' => 'index']) ?>">List users</a>
            <a class="list-group-item" href="<?= $this->Url->build(['prefix' => 'dashboard', 'plugin' => 'CodeBlastrUsers', 'controller' => 'Users', 'action' => 'add']) ?>">Add user</a>
        </div>
        <hr>
        <div class="text-right">
            <a href="<?= $this->Url->build(['prefix' => 'dashboard', 'plugin' => 'CodeBlastrUsers', 'controller' => 'permissions', 'action' => 'index']) ?>">Manage Permissions</a>
        </div>
    </div>
<?php endif; ?>