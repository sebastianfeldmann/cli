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

use SebastianFeldmann\Cli\Output;

/**
 * Class Silent
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 3.2.0
 */
class Silent implements Output
{
    /**
     * Defines the output behaviour
     *
     * @param string $out
     */
    public function write(string $out): void
    {
        return;
    }
}
