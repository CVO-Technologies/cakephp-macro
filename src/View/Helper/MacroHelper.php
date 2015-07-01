<?php

namespace Macro\View\Helper;

use Cake\View\Helper;
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
        catch (MissingMacroException $missing) {
            trigger_error($missing->getMessage());
        }

        return null;
    }

    public function execute($content, $context = null, array $options = [])
    {
        try {
            return $this->executeMacros($content, $context, $options);
        }
        catch (MissingMacroException $missing) {
            trigger_error($missing->getMessage());
        }

        return null;
    }

}
