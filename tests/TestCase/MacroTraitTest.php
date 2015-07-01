<?php

namespace Macro\Test\TestCase\Macro;

use Cake\TestSuite\TestCase;
use Macro\Error\MissingMacroException;
use Macro\MacroTrait;
use stdClass;

class MacroTraitClass
{

    use MacroTrait;

}

class MacroTraitTest extends TestCase
{

    /**
     * @var MacroTraitClass
     */
    public $macroTrait;

    public function setUp()
    {
        parent::setUp();

        $this->macroTrait = new MacroTraitClass();
    }

    public function testRun()
    {
        $this->assertEquals([
            'run',
            [],
            null
        ], $this->macroTrait->runMacro('Test'));
    }

    public function testRunWithParameters()
    {
        $this->assertEquals([
            'run',
            [
                'param1',
                2,
                'param3'
            ],
            null
        ], $this->macroTrait->runMacro('Test', ['param1', 2, 'param3']));
    }

    public function testRunWithParametersAndContext()
    {
        $this->assertEquals([
            'run',
            [
                'param1',
                2,
                'param3'
            ],
            get_class($this)
        ], $this->macroTrait->runMacro('Test', ['param1', 2, 'param3'], $this));
    }

    public function testRunWithContext()
    {
        $this->assertEquals([
            'run',
            [],
            get_class($this)
        ], $this->macroTrait->runMacro('Test', [], $this));
    }

    /**
     * @expectedException \Macro\Error\MissingMacroException
     */
    public function testRunNonExistingMacro()
    {
        $this->macroTrait->runMacro('NonExistingMacro');
    }

    /**
     * @dataProvider executeProvider
     */
    public function testExecute($input, $expected)
    {
        $this->assertEquals($expected, $this->macroTrait->executeMacros($input));
    }

    /**
     * @dataProvider executeProviderContext
     */
    public function testExecuteContext($context, $input, $expected)
    {
        $this->assertEquals($expected, $this->macroTrait->executeMacros($input, $context));
    }

    public function executeProvider()
    {
        return [
            ['{=Macro.Version=}', '1.0'],
            ['{=Test2=}', 'Test2::run()'],
            ['{=Test2::method=}', 'Test2::method()'],
            ['{=Test2::method(param1,param2)=}', 'Test2::method(param1,param2)'],
            ['{=Test2::method(param1, param2)=}', 'Test2::method(param1,param2)'],
            ['{=Test2::method(param1,        param2)=}', 'Test2::method(param1,param2)'],
            ['{=Test2::method(param1,        param2)=}', 'Test2::method(param1,param2)'],
            ['{=Test2::method({=Test2=})=}', 'Test2::method(Test2::run())'],
            ['Text in front {=Test2=} and text behind', 'Text in front Test2::run() and text behind'],
        ];
    }

    public function executeProviderContext()
    {
        $testClass = new StdClass;
        $testClass->parameter1 = 'param1';
        $testClass->parameter2 = 'param2';
        $testClass->parameterName = 'parameter2';

        return [
            [$testClass, '{=ContextParameter::parameter(parameter1)=}', 'param1'],
            [$testClass, '---{=ContextParameter::parameter(parameter1)=}---', '---param1---'],
            [$testClass, '{=ContextParameter::parameter({=ContextParameter::parameter(parameterName)=})=}', 'param2'],
            [$testClass, '-{=ContextParameter::parameter({=ContextParameter::parameter(parameterName)=})=}-', '-param2-'],
        ];
    }

    /**
     * @expectedException \Macro\Error\MissingMacroException
     */
    public function testExecuteNonExistingMacro()
    {
        $this->macroTrait->executeMacros('{=NonExistingMacro=}');
    }

}
