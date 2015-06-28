<?php

namespace Macro\Panel;

use DebugKit\DebugPanel;
use Macro\DebugMacro;

class MacrosPanel extends DebugPanel
{

    public $plugin = 'Macro';

    public function data()
    {
        return [
            'runs' => DebugMacro::runs()
        ];
    }

}
