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
 * Class ExecutableTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
class ExecutableTest extends TestCase
{
    /**
     * Tests Executable::addArgument
     */
    public function testAddArgumentPlain()
    {
        $cmd = new Executable('foo', [0, 1]);
        $cmd->addArgument('bar');

        $this->assertEquals('"foo" \'bar\'', (string) $cmd, 'argument should be added');
    }

    /**
     * Tests Executable::addArgument
     */
    public function testGetAcceptableExitCodes()
    {
        $cmd = new Executable('foo', [0, 1]);
        $cmd->addArgument('bar');

        $this->assertEquals([0, 1], $cmd->getAcceptableExitCodes());
    }

    /**
     * Tests Executable::silence
     */
    public function testSilence()
    {
        $cmd = new Executable('foo');
        $cmd->silence(true);

        $this->assertEquals('"foo" 2> /dev/null', (string) $cmd, 'command should be silenced');
    }

    /**
     * Tests Executable::addArgument
     */
    public function testAddArgumentArray()
    {
        $cmd = new Executable('foo');
        $cmd->addArgument(array('bar', 'baz'));

        $this->assertEquals('"foo" \'bar\' \'baz\'', (string) $cmd, 'arguments should be added');
    }

    /**
     * Tests Executable::addOption
     */
    public function testAddOptionArray()
    {
        $cmd = new Executable('foo');
        $cmd->addOption('-bar', array('fiz', 'baz'));

        $this->assertEquals('"foo" -bar \'fiz\' \'baz\'', (string) $cmd, 'arguments should be added');
    }

    /**
     * Tests Executable::addOptionIfNotEmpty
     */
    public function testAddOptionIfEmpty()
    {
        $cmd = new Executable('foo');
        $cmd->addOptionIfNotEmpty('-bar', '', false);

        $this->assertEquals('"foo"', (string) $cmd, 'option should not be added');

        $cmd->addOptionIfNotEmpty('-bar', 'fiz', false);

        $this->assertEquals('"foo" -bar', (string) $cmd, 'option should be added');
    }

    /**
     * Tests Executable::addOptionIfNotEmpty
     */
    public function testAddOptionIfEmptyAsValue()
    {
        $cmd = new Executable('foo');
        $cmd->addOptionIfNotEmpty('-bar', '');

        $this->assertEquals('"foo"', (string) $cmd, 'option should not be added');

        $cmd->addOptionIfNotEmpty('-bar', 'fiz');

        $this->assertEquals('"foo" -bar=\'fiz\'', (string) $cmd, 'option should be added');
    }

    /**
     * Tests Executable::addVar
     */
    public function testAddVar()
    {
        $cmd = new Executable('tool');
        $cmd->addVar('FOO', 'fiz');
        $cmd->addVar('BAR', 'baz');
        $cmd->addOptionIfNotEmpty('--extra', 'bonus');

        $this->assertEquals('FOO=\'fiz\' BAR=\'baz\' "tool" --extra=\'bonus\'', (string) $cmd, 'vars prefix');
    }
}
