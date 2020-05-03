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

use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
class ResultTest extends TestCase
{
    /**
     * Tests Cmd::getCode
     */
    public function testGetCode()
    {
        $result = new Result('echo 1', 0);
        $this->assertEquals(0, $result->getCode(), 'code getter should work properly');
    }

    /**
     * Tests Result::isSuccessful
     */
    public function testIsSuccessfulTrue()
    {
        $result = new Result('echo 1', 0);
        $this->assertTrue($result->isSuccessful(), 'should be successful on code 0');
    }

    /**
     * Tests Result::isSuccessful
     */
    public function testIsSuccessfulTrueWithDifferentExitCode()
    {
        $result = new Result('echo 1', 1, '', '', '', [0, 1]);
        $this->assertTrue($result->isSuccessful(), 'should be successful on code 1');
    }

    /**
     * Tests Result::isSuccessful
     */
    public function testIsSuccessfulFalse()
    {
        $result = new Result('echo 1', 1);
        $this->assertFalse($result->isSuccessful(), 'should not be successful on code 1');
    }

    /**
     * Tests Result::getCmd
     */
    public function testGetCmd()
    {
        $result = new Result('echo 1', 0);
        $this->assertEquals('echo 1', $result->getCmd(), 'cmd getter should work properly');
    }

    /**
     * Tests Result::getStdOut
     */
    public function testGetStdOut()
    {
        $result = new Result('echo 1', 0, 'foo bar');
        $this->assertEquals('foo bar', $result->getStdOut(), 'output getter should work properly');
    }

    /**
     * Tests Result::getStdErr
     */
    public function testGetStdErr()
    {
        $result = new Result('echo 1', 0, 'foo bar', 'fiz baz');
        $this->assertEquals('fiz baz', $result->getStdErr(), 'error getter should work properly');
    }

    /**
     * Tests Result::getStdOut
     */
    public function testGetStdOutAsArray()
    {
        $result = new Result('echo 1', 0, 'foo' . PHP_EOL . 'bar' . PHP_EOL . PHP_EOL);
        $this->assertCount(2, $result->getStdOutAsArray());
    }

    /**
     * Tests Result::isOutputRedirected
     * Tests Result::getRedirectPath
     */
    public function testIsOutputRedirectedTrue()
    {
        $result = new Result('echo 1', 0, 'foo', '', '/foo/bar.txt');
        $this->assertTrue($result->isOutputRedirected());
        $this->assertEquals('/foo/bar.txt', $result->getRedirectPath());
    }

    /**
     * Tests Result::isOutputRedirected
     * Tests Result::getRedirectPath
     */
    public function testIsOutputRedirectedFalse()
    {
        $result = new Result('echo 1', 0, 'foo');
        $this->assertFalse($result->isOutputRedirected());
        $this->assertEquals('', $result->getRedirectPath());
    }

    /**
     * Tests Result::outputToBuffer
     *
     * The resulted in an infinite loop, after the fix should work.
     */
    public function testEmptyOutputToBufferIsWorking()
    {
        $result = new Result('echo 1', 0, '', '');
        $this->assertEquals([], $result->getStdOutAsArray());
    }

    /**
     * Tests Result::__toString
     */
    public function testToString()
    {
        $result = new Result('echo 1', 0, 'foo');
        $this->assertEquals('foo', (string) $result, 'toString should work properly');
    }
}
