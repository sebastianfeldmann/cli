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

use PHPUnit\Framework\TestCase;

/**
 * Class SilentTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 3.2.0
 */
class SilentTest extends TestCase
{
    /**
     * Tests Silent::write
     */
    public function testWrite()
    {
        $out = new Silent();

        ob_start();
        $out->write('foo');
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertEmpty($content);
    }
}
