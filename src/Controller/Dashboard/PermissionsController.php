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
        $settings = Configure::read('Users.SimpleRbac.permissions');
        debug($settings);

        $permissions = $this->_collectPermissions();
        debug($permissions);

        $users = TableRegistry::get('Users');
        $results = $users->find()->select('role')->distinct('role')->extract('role')->toArray();
        debug($results);

        debug('Then we can build the ui');

        debug('Then we can write the permissions file by merging the new settings with the existing settings');
        exit;
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
            if ($action = $this->_getPermissions($path[0])) {
                $actions = array_merge($actions, $action);
            }
        }
        return $actions;
    }

    /**
     * Get all the actions that can have permissions managed
     *
     * @param string $path
     * @param array $actions
     * @return array
     */
    protected function _getPermissions(string $path, array $actions = [])
    {
        $controllers = $this->_getControllers($path);
        if (!empty($controllers)) {
            foreach ($controllers as $controller) {
                $namespace = $this->_getNameSpace($controller);
                $class = new ReflectionClass($namespace . '\\' . pathinfo($controller)['filename']);
                if (@$class->getDefaultProperties()['permissions'] === true) {
                    if ($action = $this->_getActions($class)) {
                        $actions[] = $action;
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
    protected function _getActions(ReflectionClass $class)
    {
        $tryCrud = false;
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [$class->getShortName() => []];
        $ignoreList = ['__construct', 'beforeRender', 'beforeFilter', 'afterFilter', 'initialize', 'invokeAction', 'isAction'];
        foreach ($actions as $action) {
            if ($action->class == $class->name && !in_array($action->name, $ignoreList)) {
                array_push($results[$class->getShortName()], $action->name);
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
    protected function _addCrud(ReflectionClass $class, array $results)
    {
        if (class_exists($class->name)) {
            $object = $class->name;
            $object = new $object();
            if (is_object($object->Crud)) {
                $results[$class->getShortName()] = array_merge(array_keys($object->Crud->_config['actions']), $results[$class->getShortName()]);
            }
        }
        return $results;
    }
}