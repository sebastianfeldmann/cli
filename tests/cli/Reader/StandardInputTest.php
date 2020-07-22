<?php

/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianFeldmann\Cli\Reader;

use PHPUnit\Framework\TestCase;

/**
 * Class StandardInputTest
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 3.3.0
 */
class StandardInputTest extends TestCase
{
    /**
     * Tests StandardInput::createIterator
     */
    public function testReadStandardInput(): void
    {
        $pipe = new StandardInput(fopen(SF_CLI_PATH_FILES . '/misc/foo.txt', 'r'));

        $input = '';
        foreach ($pipe as $line) {
            $input .= $line;
        }

        $this->assertStringContainsString('fooish', $input);
    }
}
