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

use SebastianFeldmann\Cli\Command\Result as CommandResult;
use PHPUnit\Framework\TestCase;

/**
 * Class SimpleTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
class SimpleTest extends TestCase
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

        $process = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Processor')
                        ->disableOriginalConstructor()
                        ->getMock();
        $process->expects($this->once())->method('run')->willReturn($res);

        $runner = new Simple($process);
        $result = $runner->run($cmd);

        $this->assertEquals('1', implode('', $result->getBufferedOutput()));
    }

    /**
     * Tests Exec::run
     */
    public function testRunFailed()
    {
        $this->expectException(\RuntimeException::class);
        $res = new CommandResult('echo 1', 1, '', '1');
        $cmd = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Command')
                    ->disableOriginalConstructor()
                    ->getMock();
        $cmd->method('getCommand')
            ->willReturn('echo 1');

        $process = $this->getMockBuilder('\\SebastianFeldmann\\Cli\\Processor')
                        ->disableOriginalConstructor()
                        ->getMock();
        $process->expects($this->once())->method('run')->willReturn($res);

        try {
            $runner = new Simple($process);
            $runner->run($cmd);
        } catch (\Exception $e) {
            $this->assertStringContainsString('exit-code: 1', $e->getMessage());
            $this->assertStringContainsString('message:   1', $e->getMessage());
            throw $e;
        }
    }
}
