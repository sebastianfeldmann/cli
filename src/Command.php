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

/**
 * Interface Command
 *
 * @package SebastianFeldmann\Cli
 */
interface Command
{
    /**
     * Get the cli command.
     *
     * @return string
     */
    public function getCommand() : string;
}
