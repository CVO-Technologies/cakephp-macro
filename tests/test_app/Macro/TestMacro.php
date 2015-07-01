<?php

namespace Macro\Test\App\Macro;

use Macro\Macro\Macro;

class TestMacro extends Macro
{

    public function run()
    {
        return $this->__call('run', func_get_args());
    }

    public function __call($name, $arguments)
    {
        return [
            $name,
            $arguments,
            (is_object(($this->context()))) ? get_class($this->context()) : $this->context()
        ];
    }

}
