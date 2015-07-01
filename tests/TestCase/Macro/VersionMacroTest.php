<?php

namespace Macro\Test\TestCase\Macro;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Macro\Macro\Macro;
use Macro\Macro\MacroRegistry;
use Macro\Macro\VersionMacro;
use Phinx\Config\Config;

class VersionMacroTest extends TestCase
{

    /**
     * @var VersionMacro
     */
    public $macro;

    /**
     * @var MacroRegistry
     */
    protected $_registry;

    protected $_initialVersion;

    public function setUp()
    {
        parent::setUp();

        $this->_initialVersion = Configure::read('Macro.version');

        Configure::write('Macro.version', '1.0');

        $this->_registry = new MacroRegistry();
        $this->macro = new VersionMacro($this->_registry);
    }

    public function tearDown()
    {
        parent::tearDown();

        Configure::write('Macro.version', $this->_initialVersion);
    }

    public function testVersion()
    {
        $this->assertEquals('1.0', $this->macro->run());
    }

}
