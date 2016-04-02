# users


# Installation

The order of plugin loading must have the extending plugin come before the base plugin.
(Something to do with routing not working for some reason if you don't.)
``
Plugin::load('CodeBlastrUsers', ['routes' => true]);
Plugin::load('CakeDC/Users', ['routes' => true, 'bootstrap' => true]);
```