<?php

namespace Macro\Error;

class MissingMacroMethodException extends MacroException
{

    protected $_messageTemplate = 'Macro class %s could not be found.';

}
