<?php

namespace Macro\Macro;

use Cake\ORM\Table;

class ModelMacro extends Macro
{

    public function __construct(MacroRegistry $macroRegistry, array $config = [], $name = null)
    {

        list($plugin, $tableName) = pluginSplit($config['table'], true);

        $this->plugin = substr($plugin, 0, -1);

        parent::__construct($macroRegistry, $config, $tableName);
    }

    public function last($field)
    {
        if (!$field) {
            return null;
        }

        $entity = $this->getTable()->find()->order([
            $this->getTable()->alias() . '.created' => 'DESC'
        ])->select([$field])->first();
        if (!$entity) {
            return null;
        }

        return $entity->get($field);
    }

    /**
     * @return Table
     */
    protected function getTable()
    {
        list($plugin, $table) = pluginSplit($this->modelClass, true);

        return $this->{$table};
    }

}
