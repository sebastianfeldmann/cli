<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Processor;

use PHPUnit\Framework\TestCase;

/**
 * Class ProcOpenTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 3.2.2
 */
class SymfonyTest extends TestCase
{
    /**
     * Tests Symfony::execute
     */
    public function testExecute()
    {
        $processor = new Symfony();
        $result    = $processor->run('echo 1');

        $this->assertEquals(0, $result->getCode(), 'echo should work everywhere');
    }

    /**
     * Tests Symfony::execute
     */
    public function testRunStdOut()
    {
        $cmd       = realpath(__DIR__ .'/../../files/bin/test');
        $processor = new Symfony();
        $res       = $processor->run($cmd);

        $this->assertStringContainsString('is on stdout', $res->getStdOut(), 'stdout should be found');
    }

    /**
     * Tests Symfony::execute
     */
    public function testRunStdErr()
    {
        $cmd       = realpath(__DIR__ .'/../../files/bin/test');
        $processor = new Symfony();
        $res       = $processor->run($cmd);

        $this->assertStringContainsString('is on stderr', $res->getStdErr(), 'stderr should be found');
    }
}
