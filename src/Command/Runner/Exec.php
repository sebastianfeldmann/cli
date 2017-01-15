<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Command\Runner;

use RuntimeException;
use SebastianFeldmann\Cli\Process;
use SebastianFeldmann\Cli\Command;
use SebastianFeldmann\Cli\Command\OutputFormatter;
use SebastianFeldmann\Cli\Command\Runner;
use SebastianFeldmann\Cli\Command\RunnerResult;

class Exec implements Runner
{
    /**
     * Class handling system calls.
     *
     * @var \SebastianFeldmann\Cli\Process
     */
    private $process;

    /**
     * Exec constructor.
     *
     * @param \SebastianFeldmann\Cli\Process $process
     */
    public function __construct(Process $process = null)
    {
        $this->process = $process !== null ? $process : new Process\ProcOpen();
    }

    /**
     * Execute a cli command.
     *
     * @param  \SebastianFeldmann\Cli\Command                 $command
     * @param  \SebastianFeldmann\Cli\Command\OutputFormatter $formatter
     * @return \SebastianFeldmann\Cli\Command\RunnerResult
     */
    public function run(Command $command, OutputFormatter $formatter = null) : RunnerResult
    {
        $cmd = $this->process->execute($command->getCommand());

        if (!$cmd->wasSuccessful()) {
            throw new RuntimeException('Command failed and exited with return code \'' . $cmd->getCode() . '\'');
        }

        $formatted = $formatter !== null ? $formatter->format($cmd->getStdOutAsArray()) : [];
        $result    = new RunnerResult($cmd, $formatted);

        return $result;
    }
}
