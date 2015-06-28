<?php

namespace Macro;

class DebugMacro
{

    protected static $_runs = [];

    public static function record($identifier, $result)
    {
        self::$_runs[] = [
            'identifier' => $identifier,
            'result' => $result
        ];
    }

    public static function runs()
    {
        return self::$_runs;
    }

}
