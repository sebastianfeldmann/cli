<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Output;

/**
 * Class CommandLineTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 2.1.0
 */
class UtilTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests:Util::trimEmptyLines
     */
    public function testTrimEmptyLinesNoEmptyLines()
    {
        $input  = ['foo', 'bar', 'baz'];
        $result = Util::trimEmptyLines($input);

        $this->assertEquals($input, $result);
    }

    /**
     * Tests:Util::trimEmptyLines
     */
    public function testTrimEmptyLinesLeadingEmptyLines()
    {
        $input  = ['', '', 'foo', 'bar', 'baz'];
        $result = Util::trimEmptyLines($input);

        $this->assertEquals($input, $result);
    }

    /**
     * Tests:Util::trimEmptyLines
     */
    public function testTrimEmptyLinesOneEmptyLine()
    {
        $expected = [];
        $input    = [''];
        $result   = Util::trimEmptyLines($input);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests:Util::trimEmptyLines
     */
    public function testTrimEmptyLinesEmptyLinesAtTheEnd()
    {
        $expected = ['foo', 'bar'];
        $input    = ['foo', 'bar', '', ''];
        $result   = Util::trimEmptyLines($input);

        $this->assertEquals($expected, $result);
    }
}
