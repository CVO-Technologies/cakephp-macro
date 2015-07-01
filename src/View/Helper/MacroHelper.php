<?php

namespace Macro\View\Helper;

use Cake\View\Helper;
use Macro\Error\MacroException;
use Macro\Error\MissingMacroException;
use Macro\MacroTrait;

class MacroHelper extends Helper
{

    use MacroTrait;

    public function run($name)
    {
        try {
            return $this->runMacro($name);
        }
        catch (MacroException $missing) {
            trigger_error($missing->getMessage());
        }

        return null;
    }

    public function execute($content, $context = null, array $options = [])
    {
        try {
            return $this->executeMacros($content, $context, $options);
        }
        catch (MacroException $missing) {
            trigger_error($missing->getMessage());
        }

        return null;
    }

}
