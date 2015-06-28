<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;

Configure::write(
    'DebugKit.panels',
    array_merge((array)Configure::read('DebugKit.panels'), ['Macro.Macros'])
);

Configure::write('Macro.version', trim(file_get_contents(Plugin::path('Macro') . DS . 'VERSION.txt')));
