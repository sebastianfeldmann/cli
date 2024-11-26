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

use SebastianFeldmann\Cli\Command;
use SebastianFeldmann\Cli\Command\Runner\Result as RunnerResult;

/**
 * Interface Runner
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
interface Runner
{
    /**
     * Execute a command.
     *
     * @param  \SebastianFeldmann\Cli\Command                      $command
     * @param  \SebastianFeldmann\Cli\Command\OutputFormatter|null $formatter
     * @return \SebastianFeldmann\Cli\Command\Runner\Result
     */
    public function run(Command $command, ?OutputFormatter $formatter = null): RunnerResult;
}
