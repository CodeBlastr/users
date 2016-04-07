# Users

Extends the CakeDC/Users plugin, this plugin may or may not be released as a stand alone it's best if you don't use this plugin for the time being. 4/7/2016.


## Installation

The order of plugin loading must have the extending plugin come before the base plugin.
(Something to do with routing not working for some reason if you don't.)


``
Plugin::load('CodeBlastrUsers', ['routes' => true]);
Plugin::load('CakeDC/Users', ['routes' => true, 'bootstrap' => true]);
```