<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Process\Runner;

use SebastianFeldmann\Cli\Command\Result as CommandResult;

/**
 * Class CommandResultTest
 *
 * @package phpbu\App\Cli
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Result::getCmdResult
     */
    public function testGetFormattedOutput()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals([], $res->getFormattedOutput());
    }

    /**
     * Tests Result::wasSuccessful
     */
    public function testWasSuccessful()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertTrue($res->wasSuccessful());
    }

    /**
     * Tests Result::getCommandResult
     */
    public function testGetCommandResult()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals($cmd, $res->getCommandResult());
    }

    /**
     * Tests Result::getOutput
     */
    public function testGetOutput()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals(['a', 'b'], $res->getOutput());
    }
}
