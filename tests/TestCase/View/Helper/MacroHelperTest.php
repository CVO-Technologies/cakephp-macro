<?php

namespace Macro\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Macro\View\Helper\MacroHelper;
use PHPUnit_Framework_Error_Notice;

class MacroHelperTest extends TestCase
{
    /**
     * @var MacroHelper
     */
    public $macroHelper;

    public function setUp()
    {
        parent::setUp();

        $this->macroHelper = new MacroHelper(new View());
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Notice
     */
    public function testRunNonExistingMacro()
    {
        $this->macroHelper->run('NonExistingMacro');
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Notice
     */
    public function testExecuteNonExistingMacro()
    {
        $this->macroHelper->execute('{=NonExistingMacro=}');
    }

}
