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

use SebastianFeldmann\Cli\Command\Result;

/**
 * Interface Cli
 *
 * @package SebastianFeldmann\Cli
 */
interface Process
{
    /**
     * Execute a system call.
     *
     * @param  string $cmd
     * @return \SebastianFeldmann\Cli\Command\Result
     */
    public function execute(string $cmd) : Result;
}
