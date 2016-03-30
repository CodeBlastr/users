<?php
namespace CodeBlastr\Users\Controller\Dashboard;

use App\Controller\AppController;
use Cake\Core\App;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use ReflectionClass;
use ReflectionMethod;

class PermissionsController extends AppController
{
    /**
     * Permissions management turned on
     *
     * @var bool
     */
    public $permissions = true;

    /**
     * Manage permissions
     */
    public function index()
    {
        $this->set('settings', $settings = Configure::read('Users.SimpleRbac.permissions'));
        $this->set('permissions', $permissions = $this->_collectPermissions());
        //debug($settings);
        $users = TableRegistry::get('Users');

        $roles = $users->find()->select('role')->distinct('role')->extract('role')->toArray();
        if (Configure::read('Users.publicAcl') === true) {
            $roles = array_merge($roles, ['public']);
        }
        $this->set('roles', $roles);

        if ($this->request->is('post')) {
            debug($this->request->data);
            debug('write permissions file');
            exit;
        }
    }

    /**
     * Collect controllers and manageable
     * actions into a single array
     *
     * @return array
     *
     * @todo Move everything from here down into a model
     *
     */
    protected function _collectPermissions() {
        $actions = [];
        foreach (App::path('Controller') as $path) {
            if ($action = $this->_getPermissions($path)) {
                $actions = array_merge($actions, $action);
            }
        }

        $plugins = Plugin::loaded();
        foreach ($plugins as $plugin) {
            $path = App::path('Controller', $plugin);
            if ($action = $this->_getPermissions($path[0], $plugin)) {
                $actions = array_merge($actions, $action);
            }
        }
        return $actions;
    }

    /**
     * Get all the actions that can have permissions managed
     *
     * @param string $path
     * @param mixed $plugin Plugin name string
     * @return array
     */
    protected function _getPermissions(string $path, $plugin = false)
    {
        $actions = [];
        $controllers = $this->_getControllers($path);
        if (!empty($controllers)) {
            foreach ($controllers as $controller) {
                $namespace = $this->_getNameSpace($controller);
                $class = new ReflectionClass($namespace . '\\' . pathinfo($controller)['filename']);
                if (@$class->getDefaultProperties()['permissions'] === true) {
                    if ($action = $this->_getActions($class)) {
                        $actions[$plugin][pathinfo($controller)['filename']] = $action;
                    }
                }
            }
        }
        return $actions;
    }

    /**
     * Get controllers
     *
     * @param $directory
     * @return array|null
     */
    protected function _getControllers($directory) {
        if (file_exists($directory)) {
            $files = scandir($directory);
        } else {
            return null;
        }
        $results = [];
        $ignoreList = [
            '.',
            '..',
            'Component',
            'AppController.php',
        ];
        for ($i=0; $i< count($files); $i++) {
            if(!in_array($files[$i], $ignoreList)) {
                if (is_dir($directory . $files[$i])) {
                    $results = $this->_getControllers($directory . $files[$i] . DS);
                } else {
                    $results[] = $directory . $files[$i];
                }
            }
        }
        return $results;
    }

    /**
     * Get the namespace of a particular file
     *
     * @param $path Full path to file
     * @return array
     */
    protected function _getNamespace($file)
    {
        $ns = null;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'namespace') === 0) {
                    $parts = explode(' ', $line);
                    $ns = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $ns;
    }

    /**
     * Get actions
     *
     * @param Object $class
     * @return array
     */
    protected function _getActions(ReflectionClass $class, $plugin = false)
    {
        $tryCrud = false;
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [];
        $ignoreList = ['__construct', 'beforeRender', 'beforeFilter', 'afterFilter', 'initialize', 'invokeAction', 'isAction'];
        foreach ($actions as $action) {
            if ($action->class == $class->name && !in_array($action->name, $ignoreList)) {
                array_push($results, $action->name);
            }
            if (!in_array($action->name, $ignoreList)) {
                $tryCrud = true;
            }
        }
        if ($tryCrud === true) {
            $results = $this->_addCrud($class, $results);
        }
        return $results;
    }

    /**
     * Check and see if crud is being used
     * and get the crud actions if so.
     *
     * @param ReflectionClass $class
     * @param array $results
     * @return array
     */
    protected function _addCrud(ReflectionClass $class, array $results, $plugin = false)
    {
        if (class_exists($class->name)) {
            $object = $class->name;
            $object = new $object();
            if (is_object($object->Crud)) {
                $results = array_merge(array_keys($object->Crud->_config['actions']), $results);
            }
        }
        return $results;
    }
}