<?php

namespace Macro\Test\TestCase\Macro;

use Cake\TestSuite\TestCase;
use Macro\Macro\Macro;
use Macro\Macro\MacroRegistry;

class TestMacro extends Macro
{
}

class MacroTest extends TestCase
{

    /**
     * @var MacroRegistry
     */
    private $_registry = null;

    public function setUp()
    {
        parent::setUp();

        $this->_registry = new MacroRegistry();
    }

    public function testContext()
    {
        $testMacro = new TestMacro($this->_registry, [
            'context' => 'test123'
        ]);

        $this->assertEquals('test123', $testMacro->context());
    }

    public function testNoContext()
    {
        $testMacro = new TestMacro($this->_registry);

        $this->assertNull($testMacro->context());
    }

    public function testDefaultRun()
    {
        $testMacro = new TestMacro($this->_registry);

        $this->assertNull($testMacro->run());
    }

}
