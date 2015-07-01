<?php

namespace Macro\Test\App\Macro;

use Macro\Macro\Macro;

class Test2Macro extends Macro
{

    public function run()
    {
        return $this->__call('run', func_get_args());
    }

    public function __call($name, $arguments)
    {
        return $this->name . '::' . $name . '(' . implode(',', $arguments) . ')';
    }

}
