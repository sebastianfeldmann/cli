<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Process\Runner;

use SebastianFeldmann\Cli\Command\Result as CommandResult;

/**
 * Class Result
 *
 * @package SebastianFeldmann\Cli
 */
class Result
{
    /**
     * @var \SebastianFeldmann\Cli\Command\Result
     */
    private $cmdResult;

    /**
     * @var iterable
     */
    private $formatted;

    /**
     * Result constructor.
     *
     * @param \SebastianFeldmann\Cli\Command\Result $cmdResult
     * @param iterable                              $formatted
     */
    public function __construct(CommandResult $cmdResult, $formatted = [])
    {
        $this->cmdResult = $cmdResult;
        $this->formatted = $formatted;
    }

    /**
     * Get the raw command result.
     *
     * @return \SebastianFeldmann\Cli\Command\Result
     */
    public function getCommandResult() : CommandResult
    {
        return $this->cmdResult;
    }

    /**
     * Return cmd output as array.
     *
     * @return array
     */
    public function getOutput() : array
    {
        return $this->cmdResult->getStdOutAsArray();
    }

    /**
     * Return formatted output.
     *
     * @return array
     * @throws \Exception
     */
    public function getFormattedOutput()
    {
        return $this->formatted;
    }
}
