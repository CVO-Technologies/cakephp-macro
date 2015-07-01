<?php

namespace Macro\Test\App\Macro;

use Macro\Macro\Macro;

class ContextParameterMacro extends Macro
{

    public function parameter($parameter)
    {
        return $this->context()->{$parameter};
    }

}
