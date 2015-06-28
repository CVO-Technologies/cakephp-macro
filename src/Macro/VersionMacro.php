<?php

namespace Macro\Macro;

use Cake\Core\Configure;

class VersionMacro extends Macro
{

    public function run()
    {
        return Configure::read('Macro.version');
    }

}
