<?php

namespace Macro;

class DebugMacro
{

    protected static $_runs = [];

    public static function record($identifier, $parameters, $context, $options, $result, $elapsedTime)
    {
        self::$_runs[] = [
            'identifier' => $identifier,
            'parameters' => $parameters,
            'context' => $context,
            'options' => $options,
            'result' => $result,
            'elapsedTime' => $elapsedTime
        ];
    }

    public static function runs()
    {
        return self::$_runs;
    }

}
