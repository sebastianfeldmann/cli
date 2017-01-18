<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Process;

use SebastianFeldmann\Cli\Command;
use SebastianFeldmann\Cli\Command\OutputFormatter;
use SebastianFeldmann\Cli\Process\Runner\Result;

/**
 * Interface Runner
 *
 * @package SebastianFeldmann\Cli
 */
interface Runner
{
    /**
     * Execute a command.
     *
     * @param  \SebastianFeldmann\Cli\Command                 $command
     * @param  \SebastianFeldmann\Cli\Command\OutputFormatter $formatter
     * @return \SebastianFeldmann\Cli\Process\Runner\Result
     */
    public function run(Command $command, OutputFormatter $formatter = null) : Result;
}
