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
     * @return \SebastianFeldmann\Cli\Command\RunnerResult
     */
    public function run(Command $command, OutputFormatter $formatter = null) : RunnerResult;
}
