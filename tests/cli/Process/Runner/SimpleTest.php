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
 * Class SimpleTest
 *
 * @package SebastianFeldmann\Cli
 */
class SimpleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Exec::run
     */
    public function testRun()
    {
        $res = new CommandResult('echo 1', 0, '1', '');
        $cmd = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Command')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->method('getCommand')
            ->willReturn('echo 1');

        $process = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Process')
                        ->disableOriginalConstructor()
                        ->getMock();
        $process->expects($this->once())->method('run')->willReturn($res);

        $runner = new Simple($process);
        $result = $runner->run($cmd);

        $this->assertEquals('1', implode('', $result->getOutput()));
    }

    /**
     * Tests Exec::run
     *
     * @expectedException \RuntimeException
     */
    public function testRunFailed()
    {
        $res = new CommandResult('echo 1', 1, '', '1');
        $cmd = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Command')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->method('getCommand')
            ->willReturn('echo 1');

        $process = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Process')
                        ->disableOriginalConstructor()
                        ->getMock();
        $process->expects($this->once())->method('run')->willReturn($res);

        $runner = new Simple($process);
        $runner->run($cmd);
    }
}
