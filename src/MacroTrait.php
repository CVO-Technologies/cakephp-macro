<?php

namespace Macro;

use Cake\Core\Plugin;
use DebugKit\DebugTimer;
use Macro\Macro\Macro;
use Macro\Macro\MacroRegistry;

trait MacroTrait
{

    /**
     * @var MacroRegistry
     */
    private $_registry = null;

    public function runMacro($identifier, array $parameters = [], $context = null)
    {
        if (Plugin::loaded('DebugKit')) {
            DebugTimer::start(__d('macro', 'Macro: {0}', $identifier));
        }

        $macroParts = explode('::', $identifier);
        $name = $macroParts[0];
        $method = isset($macroParts[1]) ? $macroParts[1] : 'run';

        $this->getMacroRegistry()->reset();

        $config = [];
        if ($context) {
            $config['context'] = $context;
        }

        /** @var Macro $macro */
        $macro = $this->getMacroRegistry()->load($name, $config);
        $result = call_user_func_array([$macro, $method], $parameters);

        if (Plugin::loaded('DebugKit')) {
            DebugTimer::stop(__d('macro', 'Macro: {0}', $identifier));
        }

        DebugMacro::record($identifier, $result);

        return $result;
    }

    public function executeMacros($content, $context = null)
    {
        while ((!isset($count)) || $count > 1) {
            $content = preg_replace_callback('/\{\=(?P<name>[^\:\=\(]+)(\:\:(?P<method>[^\(\=]+))?(\((?P<parameters>.*)\))?\=\}/', function (array $matches) use ($context) {
                $identifier = $matches['name'];
                $parameters = [];

                if (!empty($matches['method'])) {
                    $identifier .= '::' . $matches['method'];
                }
                if (!empty($matches['parameters'])) {
                    $parameters = array_map('trim', explode(', ', $matches['parameters']));
                }

        while ((!isset($count)) || $count > 1) {
            $content = preg_replace_callback(
                '/\{\=(?P<name>[^\:\=\(]+)(\:\:(?P<method>[^\(\=]+))?(\((?P<parameters>.*)\))?\=\}/',
                function (array $matches) use ($context) {
                    $identifier = $matches['name'];
                    $parameters = [];

                    if (!empty($matches['method'])) {
                        $identifier .= '::' . $matches['method'];
                    }
                    if (!empty($matches['parameters'])) {
                        $parameters = array_map('trim', explode(', ', $matches['parameters']));
                    }

                    $parameters = array_map([$this, 'executeMacros'], $parameters, [$context]);

                    return $this->runMacro($identifier, $parameters, $context);
                },
                $content, -1, $count
            );
        }

        return $content;
    }

    /**
     * @return MacroRegistry
     */
    protected function getMacroRegistry() {
        if (!$this->_registry) {
            $this->_registry = new MacroRegistry();
        }

        return $this->_registry;
    }

}
