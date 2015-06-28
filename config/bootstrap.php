<?php

use Cake\Core\Configure;

Configure::write(
    'DebugKit.panels',
    array_merge((array)Configure::read('DebugKit.panels'), ['Macro.Macros'])
);

