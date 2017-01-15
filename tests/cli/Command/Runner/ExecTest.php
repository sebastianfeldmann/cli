<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Command\Runner;

use SebastianFeldmann\Cli\Command\Result;

/**
 * Class ExecTest
 *
 * @package SebastianFeldmann\Cli
 */
class ExecTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Exec::run
     */
    public function testRun()
    {
        $res = new Result('echo 1', 0, '1', '');
        $cmd = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Command')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->method('getCommand')
            ->willReturn('echo 1');

        $process = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Process')
                        ->disableOriginalConstructor()
                        ->getMock();
        $process->expects($this->once())->method('execute')->willReturn($res);

        $runner = new Exec($process);
        $result = $runner->run($cmd);

        $this->assertEquals('1', implode('', $result->getOutput()));
    }
}
