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

/**
 * Class ResultTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
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
     * Tests Result::isSuccessful
     */
    public function testIsSuccessful()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertTrue($res->isSuccessful());
    }

    /**
     * Tests Result::getCode
     */
    public function testGetCode()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals(0, $res->getCode());
    }

    /**
     * Tests Result::getCmd
     */
    public function testGetCmd()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals('echo 1', $res->getCmd());
    }

    /**
     * Tests Result::getStdOut
     */
    public function testGetStdOut()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals("a\nb", $res->getStdOut());
    }

    /**
     * Tests Result::getStdErr
     */
    public function testGetStdErr()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb", "foo");
        $res = new Result($cmd);
        $this->assertEquals('foo', $res->getStdErr());
    }

    /**
     * Tests Result::isOutputRedirected
     * Tests Result::getRedirectPath
     */
    public function testIsOutputRedirectedTrue()
    {
        $cmd    = new CommandResult('echo 1', 0, 'foo', '', '/foo/bar.txt');
        $result = new Result($cmd);
        $this->assertTrue($result->isOutputRedirected());
        $this->assertEquals('/foo/bar.txt', $result->getRedirectPath());
    }

    /**
     * Tests Result::isOutputRedirected
     * Tests Result::getRedirectPath
     */
    public function testIsOutputRedirectedFalse()
    {
        $cmd    = new CommandResult('echo 1', 0, 'foo');
        $result = new Result($cmd);
        $this->assertFalse($result->isOutputRedirected());
        $this->assertEquals('', $result->getRedirectPath());
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
    public function testGetBufferedOutput()
    {
        $cmd = new CommandResult('echo 1', 0, "a\nb");
        $res = new Result($cmd);
        $this->assertEquals(['a', 'b'], $res->getBufferedOutput());
    }
}
