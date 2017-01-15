<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Command;

/**
 * Class RunnerResultTest
 *
 * @package phpbu\App\Cli
 */
class RunnerResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests RunnerResult::getCmdResult
     */
    public function testGetFormattedOutput()
    {
        $cmd = new Result('echo 1', 0, "a\nb");
        $res = new RunnerResult($cmd);
        $this->assertEquals([], $res->getFormattedOutput());
    }

    /**
     * Tests RunnerResult::getCommandResult
     */
    public function testGetCommandResult()
    {
        $cmd = new Result('echo 1', 0, "a\nb");
        $res = new RunnerResult($cmd);
        $this->assertEquals($cmd, $res->getCommandResult());
    }

    /**
     * Tests RunnerResult::getOutput
     */
    public function testGetOutput()
    {
        $cmd = new Result('echo 1', 0, "a\nb");
        $res = new RunnerResult($cmd);
        $this->assertEquals(['a', 'b'], $res->getOutput());
    }
}
