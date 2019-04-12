<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli;

use SebastianFeldmann\Cli\Command\Executable;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandLineTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
class CommandLineTest extends TestCase
{
    /**
     * Tests CommandLine::getCommand
     *
     * @expectedException \RuntimeException
     */
    public function testGetExecFail()
    {
        $exec = new CommandLine();
        $exec->getCommand();
    }

    /**
     * Tests CommandLine::getCommand
     */
    public function testGetCommand()
    {
        $cmd = new Executable('echo');
        $cmd->addArgument('foo');

        $commandLine = new CommandLine();
        $commandLine->addCommand($cmd);

        $res = $commandLine->getCommand();

        $this->assertEquals('echo \'foo\'', $res);
        $this->assertEquals('echo \'foo\'', (string)$commandLine);
    }

    /**
     * Tests CommandLine::getCommand
     */
    public function testGetCommandLineMultiCommand()
    {
        $cmd1 = new Executable('echo');
        $cmd1->addArgument('foo');

        $cmd2 = new Executable('echo');
        $cmd2->addArgument('bar');


        $commandLine = new CommandLine();
        $commandLine->addCommand($cmd1);
        $commandLine->addCommand($cmd2);

        $res = $commandLine->getCommand();

        $this->assertEquals('(echo \'foo\' && echo \'bar\')', $res);
    }

    /**
     * Tests CommandLine::isOutputRedirected
     */
    public function testRedirect()
    {
        $cmd = new Executable('echo');
        $cmd->addArgument('foo');

        $commandLine = new CommandLine();
        $commandLine->addCommand($cmd);

        $this->assertFalse($commandLine->isOutputRedirected());

        $commandLine->redirectOutputTo('/tmp/foo');

        $this->assertTrue($commandLine->isOutputRedirected());
        $this->assertEquals('/tmp/foo', $commandLine->getRedirectPath());
    }

    /**
     * Tests CommandLine::pipe
     */
    public function testPipeline()
    {
        $cmd         = new Executable('echo \'foo\'');
        $compressor  = new Executable('bzip2 \'foo.bz2\'');
        $commandLine = new CommandLine();
        $commandLine->addCommand($cmd);
        $commandLine->pipeOutputTo($compressor);

        $this->assertEquals('echo \'foo\' | bzip2 \'foo.bz2\'', $commandLine->getCommand());
    }

    /**
     * Tests CommandLine::getAcceptableExitCodes
     */
    public function testGetAcceptableExitCodes()
    {
        $commandLine = new CommandLine();
        $commandLine->acceptExitCodes([0, 1]);

        $this->assertEquals([0, 1], $commandLine->getAcceptableExitCodes());
    }

    /**
     * Tests CommandLine::getPipeFail
     */
    public function testPipeFailActive()
    {
        $cmd         = new Executable('echo \'foo\'');
        $compressor  = new Executable('bzip2 \'foo.bz2\'');
        $commandLine = new CommandLine();
        $commandLine->addCommand($cmd);
        $commandLine->pipeOutputTo($compressor);
        $commandLine->pipeFail(true);

        $this->assertEquals('set -o pipefail; echo \'foo\' | bzip2 \'foo.bz2\'', $commandLine->getCommand());
    }
}
