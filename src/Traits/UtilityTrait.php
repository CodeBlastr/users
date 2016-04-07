<?php
namespace CodeBlastrUsers\Traits;

use Cake\View\ViewBuilder;
use App\View\AppView;
use Cake\Utility\Hash;

/**
 * Class UtilityTrait
 *
 * Reusable functions.
 *
 * @package CodeBlastrUsers
 * @todo This should be moved to the APP I think.
 */
trait UtilityTrait {

    /**
     * Template exists check
     * Checks if a template exists and if so returns the file name (minus the extension).
     * Else returns the default file name.
     *
     * ###Usage
     * ``$this->templateExists(['suffix' => '_customer'])``
     * returns 'edit_customer' if edit_custom.ctp file exists
     *
     * IMPORTANT NOTE : If using crud it must come after Crud->execute unless you set all options manually.
     *
     * @param array $options
     * prefix : added to the front of a template file name and check if it exists
     * suffix : added to the end of a template file name and check if it exists
     * templateName : the file name (with out the extension)
     * plugin : name of the plugin path to be looked up
     * extension : file extension of template files, defaults to ctp
     *
     */
    public function templateExists(ViewBuilder $viewBuilder, $options = ['prefix' => null, 'suffix' => null]) {

        $options = Hash::merge(['prefix' => null, 'suffix' => null], $options);

        if (!empty($options['templatePath'])) {
            $templatePath = $options['templatePath'];
        } else {
            $templatePath = $viewBuilder()->templatePath();
        }
        if (!empty($options['templateName'])) {
            $templateName = $options['templateName'];
        } else {
            $templateName = $viewBuilder()->template();
        }

        if (!empty($options['plugin'])) {
            $plugin = $options['plugin'];
        } else {
            $plugin = $viewBuilder()->plugin();
        }

        if (!empty($options['extension'])) {
            $extension = $options['extension'];
        } else {
            $extension = '.ctp';
        }

        $view = new AppView();
        if (!empty($plugin)) {
            $paths = $view->paths($plugin);
        } else {
            $paths = $view->paths();
        }

        foreach ($paths as $path) {
            $file = $path . $templatePath . DS . $options['prefix'] . $templateName . $options['suffix'] . $extension;
            if (file_exists($file)) {
                return $options['prefix'] . $templateName . $options['suffix'];
                break;
            }
        }
        return $templateName;
    }
}