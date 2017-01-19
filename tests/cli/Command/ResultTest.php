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
 * Class ResultTest
 *
 * @package phpbu\App\Cli
 */
class ResultTest extends \PHPUnit_Framework_TestCase
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
     * Tests Cmd::wasSuccessful
     */
    public function testWasSuccessfulTrue()
    {
        $result = new Result('echo 1', 0);
        $this->assertEquals(true, $result->wasSuccessful(), 'should be successful on code 0');
    }

    /**
     * Tests Cmd::wasSuccessful
     */
    public function testWasSuccessfulFalse()
    {
        $result = new Result('echo 1', 1);
        $this->assertEquals(false, $result->wasSuccessful(), 'should not be successful on code 1');
    }

    /**
     * Tests Cmd::getCmd
     */
    public function testGetCmd()
    {
        $result = new Result('echo 1', 0);
        $this->assertEquals('echo 1', $result->getCmd(), 'cmd getter should work properly');
    }

    /**
     * Tests Cmd::getStdOut
     */
    public function testGetStdOut()
    {
        $result = new Result('echo 1', 0, 'foo bar');
        $this->assertEquals('foo bar', $result->getStdOut(), 'output getter should work properly');
    }

    /**
     * Tests Cmd::getStdErr
     */
    public function testGetStdErr()
    {
        $result = new Result('echo 1', 0, 'foo bar', 'fiz baz');
        $this->assertEquals('fiz baz', $result->getStdErr(), 'error getter should work properly');
    }

    /**
     * Tests Cmd::getStdOut
     */
    public function testGetStdOutAsArray()
    {
        $result = new Result('echo 1', 0, 'foo' . PHP_EOL . 'bar' . PHP_EOL . PHP_EOL);
        $this->assertEquals(2, count($result->getStdOutAsArray()));
    }

    /**
     * Tests Cmd::__toString
     */
    public function testToString()
    {
        $result = new Result('echo 1', 0, 'foo');
        $this->assertEquals('foo', (string) $result, 'toString should work properly');
    }
}
