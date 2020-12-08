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

use PHPUnit\Framework\TestCase;

/**
 * Class CommandLineTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
class UtilTest extends TestCase
{
    /**
     * Fake global state
     *
     * @var array
     */
    private static $server;

    /**
     * Backup $_SERVER settings.
     */
    protected function setUp(): void
    {
        self::$server = $_SERVER;
    }

    /**
     * Restore $_SERVER settings
     */
    protected function tearDown(): void
    {
        $_SERVER = self::$server;
    }

    /**
     * Test detectCmdLocation Exception
     */
    public function testDetectCmdFail()
    {
        $this->expectException(\RuntimeException::class);
        if (defined('PHP_WINDOWS_VERSION_BUILD')) {
            // can't be tested on windows system
            $this->assertTrue(true);
        } else {
            // assume ls should be there
            $cmd = Util::detectCmdLocation('someStupidCommand');
            $this->assertFalse(true, $cmd . ' should not be found');
        }
    }

    /**
     * Test detectCmdLocation Exception with path
     */
    public function testDetectCmdFailWithPath()
    {
        $this->expectException(\RuntimeException::class);
        // assume ls should be there
        $cmd = Util::detectCmdLocation('someStupidCommand', '/tmp');
        $this->assertFalse(true, $cmd . ' should not be found');
    }

    /**
     * Test detectCmdLocation
     */
    public function testDetectCmdLocationWhich()
    {
        if (defined('PHP_WINDOWS_VERSION_BUILD')) {
            // can't be tested on windows system
            $this->assertTrue(true);
        } else {
            // assume ls should be there
            $ls = Util::detectCmdLocation('ls');
            $this->assertNotEmpty($ls, 'ls command should be found');
        }
    }

    /**
     * Test detectCmdLocation
     */
    public function testDetectCmdLocationWithProvidedPath()
    {
        $cmd     = 'foo';
        $cmdPath = $this->createTempCommand($cmd);
        $result  = Util::detectCmdLocation($cmd, dirname($cmdPath));
        // cleanup tmp executable
        $this->removeTempCommand($cmdPath);

        $this->assertEquals($cmdPath, $result, 'foo command should be found');
    }

    /**
     * Test detectCmdLocation
     */
    public function testDetectCmdLocationWithOptionalLocation()
    {
        $cmd     = 'bar';
        $cmdPath = $this->createTempCommand($cmd);
        $result  = Util::detectCmdLocation($cmd, '', [dirname($cmdPath)]);
        // cleanup tmp executable
        $this->removeTempCommand($cmdPath);

        $this->assertEquals($cmdPath, $result, 'foo command should be found');
    }

    /**
     * Tests Util::getEnvPath
     */
    public function testGetEnvPathFail()
    {
        $this->expectException(\RuntimeException::class);
        unset($_SERVER['PATH']);
        unset($_SERVER['Path']);
        unset($_SERVER['path']);
        $path = Util::getEnvPath();
    }

    /**
     * Tests Util::isAbsolutePath
     */
    public function testIsAbsolutePathTrue()
    {
        $path = '/foo/bar';
        $res  = Util::isAbsolutePath($path);

        $this->assertTrue($res, 'should be detected as absolute path');
    }

    /**
     * Tests Util::isAbsolutePath
     */
    public function testIsAbsolutePathFalse()
    {
        $path = '../foo/bar';
        $res  = Util::isAbsolutePath($path);

        $this->assertFalse($res, 'should not be detected as absolute path');
    }

    /**
     * Tests Util::isAbsolutePath
     */
    public function testIsAbsolutePathStream()
    {
        $path = 'php://foo/bar';
        $res  = Util::isAbsolutePath($path);

        $this->assertTrue($res, 'should not be detected as absolute path');
    }

    /**
     * Tests Util::isAbsolutePathWindows
     *
     * @dataProvider providerWindowsPaths
     *
     * @param string $path
     * @param bool   $expected
     */
    public function testIsAbsolutePathWindows($path, $expected)
    {
        $res = Util::isAbsoluteWindowsPath($path);

        $this->assertEquals($expected, $res, 'should be detected as expected');
    }

    /**
     * Tests Util::toAbsolutePath
     */
    public function testToAbsolutePathAlreadyAbsolute()
    {
        $res = Util::toAbsolutePath('/foo/bar', '');

        $this->assertEquals('/foo/bar', $res, 'should be detected as absolute');
    }

    /**
     * Data provider testIsAbsolutePathWindows.
     *
     * @return array
     */
    public function providerWindowsPaths()
    {
        return [
            ['C:\foo', true],
            ['\\foo\\bar', true],
            ['..\\foo', false],
        ];
    }

    /**
     * Tests Util::toAbsolutePath
     */
    public function testToAbsolutePathWIthIncludePath()
    {
        $filesDir = SF_CLI_PATH_FILES . '/misc';
        set_include_path(get_include_path() . PATH_SEPARATOR . $filesDir);
        $res = Util::toAbsolutePath('foo.txt', '', true);

        $this->assertEquals($filesDir . '/foo.txt', $res);
    }

    /**
     * Tests Util::formatWithColor
     */
    public function testFormatWithColor()
    {
        $plainText   = 'my text test';
        $coloredText = Util::formatWithColor('fg-black, bg-green', $plainText);

        $this->assertStringContainsString("\x1b[0m", $coloredText);
    }

    /**
     * Tests Util::formatWithColor
     */
    public function testFormatWithColorEmptyLine()
    {
        $plainText   = '';
        $coloredText = Util::formatWithColor('fg-black, bg-green', $plainText);

        $this->assertStringNotContainsString("\x1b[0m", $coloredText);
    }

    /**
     * Tests Util::formatWithAsterisk
     */
    public function testFormatWithAsterisk()
    {
        $plainText     = 'Mein Test ';
        $decoratedText = Util::formatWithAsterisk($plainText);

        $this->assertEquals(72, strlen(trim($decoratedText)));
        $this->assertStringContainsString('*', $decoratedText);
    }

    /**
     * Tests Util::canPipe
     */
    public function testCanPipe()
    {
        $this->assertEquals(!defined('PHP_WINDOWS_VERSION_BUILD'), Util::canPipe());
    }

    /**
     * Tests Util::removeDir
     */
    public function testRemoveDir()
    {
        $dir         = sys_get_temp_dir();
        $dirToDelete = $dir . '/foo';
        $subDir      = $dirToDelete . '/bar';

        $file        = $dirToDelete . '/fiz.txt';
        $fileInSub   = $subDir . '/baz.txt';

        mkdir($subDir, 0700, true);
        file_put_contents($file, 'fiz');
        file_put_contents($fileInSub, 'baz');

        Util::removeDir($dirToDelete);

        $this->assertFileDoesNotExist($file);
        $this->assertFileDoesNotExist($fileInSub);
        $this->assertFileDoesNotExist($subDir);
        $this->assertFileDoesNotExist($dirToDelete);
    }

    /**
     * Create some temp command
     *
     * @param  string $cmd
     * @return string
     */
    protected function createTempCommand($cmd)
    {
        $dir     = sys_get_temp_dir();
        $cmdPath = $dir . DIRECTORY_SEPARATOR . $cmd;

        // create the tmp executable
        file_put_contents($cmdPath, "#!/bin/bash\necho 'foo';");
        chmod($cmdPath, 0755);
        return $cmdPath;
    }

    /**
     * Remove prior created temp command
     *
     * @param string $cmdPath
     */
    protected function removeTempCommand($cmdPath)
    {
        unlink($cmdPath);
    }
}
