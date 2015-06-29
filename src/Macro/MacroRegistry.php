<?php

namespace Macro\Macro;

use Cake\Core\App;
use Cake\Core\ObjectRegistry;

/**
 * Registry object for macros.
 */
class MacroRegistry extends ObjectRegistry
{

    /**
     * Loads/constructs an object instance.
     *
     * Will return the instance in the registry if it already exists.
     * If a subclass provides event support, you can use `$config['enabled'] = false`
     * to exclude constructed objects from being registered for events.
     *
     * Using Cake\Controller\Controller::$components as an example. You can alias
     * an object by setting the 'className' key, i.e.,
     *
     * ```
     * public $components = [
     *   'Email' => [
     *     'className' => '\App\Controller\Component\AliasedEmailComponent'
     *   ];
     * ];
     * ```
     *
     * All calls to the `Email` component would use `AliasedEmail` instead.
     *
     * @param string $objectName The name/class of the object to load.
     * @param array $config Additional settings to use when loading the object.
     * @return mixed
     */
    public function load($objectName, $config = [])
    {
        list(, $name) = pluginSplit($objectName);
        $loaded = isset($this->_loaded[$name]);
        if ($loaded && !empty($config)) {
            $this->_checkDuplicate($name, $config);
        }
        if ($loaded) {
            return $this->_loaded[$name];
        }

        if (is_array($config) && isset($config['className'])) {
            $objectName = $config['className'];
        }
        $className = $this->_resolveClassName($objectName);
        if (!$className || (is_string($className) && !class_exists($className))) {
            list($plugin, $objectName) = pluginSplit($objectName);

            /** @var ModelMacro $modelMacro */
            $modelMacro = $this->load($objectName, [
                'className' => '\Macro\Macro\ModelMacro',
                'table' => $plugin . '.' . $objectName
            ]);
            if (get_class($modelMacro->getTable()) !== 'Cake\\ORM\\Table') {
                return $modelMacro;
            }

            $this->_throwMissingClassError($objectName, $plugin);
        }
        $instance = $this->_create($className, $name, $config);
        $this->_loaded[$name] = $instance;
        return $instance;
    }


    /**
     * Resolve a panel classname.
     *
     * Part of the template method for Cake\Utility\ObjectRegistry::load()
     *
     * @param string $class Partial classname to resolve.
     * @return string|false Either the correct classname or false.
     */
    protected function _resolveClassName($class)
    {
        return App::className($class, 'Macro', 'Macro');
    }

    /**
     * Throws an exception when a component is missing.
     *
     * Part of the template method for Cake\Utility\ObjectRegistry::load()
     *
     * @param string $class The classname that is missing.
     * @param string $plugin The plugin the component is missing in.
     * @return void
     * @throws \RuntimeException
     */
    protected function _throwMissingClassError($class, $plugin)
    {
        throw new \RuntimeException("Unable to find '$class' macro.");
    }

    /**
     * Create the macro instance.
     *
     * Part of the template method for Cake\Utility\ObjectRegistry::load()
     *
     * @param string $class The classname to create.
     * @param string $alias The alias of the macro.
     * @param array $config An array of config to use for the macro.
     * @return Macro The constructed macro class.
     */
    protected function _create($class, $alias, $config)
    {
        return new $class($this, $config);
    }

}
