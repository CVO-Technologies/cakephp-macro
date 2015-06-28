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
