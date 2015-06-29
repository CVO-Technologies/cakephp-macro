<?php

namespace Macro\Error;

use Cake\Core\Exception\Exception;

class MissingMacroException extends Exception
{

    protected $_messageTemplate = 'Macro class %s could not be found.';

}
