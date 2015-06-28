<?php

namespace Macro\Macro;

use Cake\Datasource\ModelAwareTrait;

abstract class Macro
{

    use ModelAwareTrait;

    /**
     * The name of this Macro. Macro names are plural, named after the model they use.
     *
     * Set automatically using conventions in Macro::__construct().
     *
     * @var string
     */
    public $name = null;

    public function __construct(MacroRegistry $macroRegistry, array $config = [], $name = null)
    {
        if ($this->name === null && $name === null) {
            list(, $name) = namespaceSplit(get_class($this));
            $name = substr($name, 0, -5);
        }
        if ($name !== null) {
            $this->name = $name;
        }

        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $modelClass = ($this->plugin ? $this->plugin . '.' : '') . $this->name;
        $this->_setModelClass($modelClass);
    }


    /**
     * Magic accessor for model autoloading.
     *
     * @param string $name Property name
     * @return bool|object The model instance or false
     */
    public function __get($name)
    {
        list($plugin, $class) = pluginSplit($this->modelClass, true);
        if ($class !== $name) {
            return false;
        }
        return $this->loadModel($plugin . $class);
    }


    public function run()
    {
    }

}
