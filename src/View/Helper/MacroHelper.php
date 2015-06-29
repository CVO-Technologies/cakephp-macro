<?php

namespace Macro\View\Helper;

use Cake\View\Helper;
use Macro\MacroTrait;

class MacroHelper extends Helper
{

    use MacroTrait;

    public function run($name)
    {
        return $this->runMacro($name);
    }

    public function execute($content, $context = null)
    {
        return $this->executeMacros($content, $context);
    }

}
