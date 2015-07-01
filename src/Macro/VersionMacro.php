<?php

namespace Macro\Macro;

use Cake\Core\Configure;
use Macro\Error\InvalidContextException;

class VersionMacro extends Macro
{

    public function run()
    {
        return Configure::read('Macro.version');
    }

    protected function _validateContext($context)
    {
        throw new InvalidContextException('No context is supported');
    }


}
