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
use SebastianFeldmann\Cli\Command;
use SebastianFeldmann\Cli\Command\Runner;
use SebastianFeldmann\Cli\Command\OutputFormatter;
use SebastianFeldmann\Cli\Processor;

class Simple implements Runner
{
    /**
     * Class handling system calls.
     *
     * @var \SebastianFeldmann\Cli\Processor
     */
    private $processor;

    /**
     * Exec constructor.
     *
     * @param \SebastianFeldmann\Cli\Processor $processor
     */
    public function __construct(Processor $processor = null)
    {
        $this->processor = $processor !== null ? $processor : new Processor\ProcOpen();
    }

    /**
     * Execute a cli command.
     *
     * @param  \SebastianFeldmann\Cli\Command                 $command
     * @param  \SebastianFeldmann\Cli\Command\OutputFormatter $formatter
     * @return \SebastianFeldmann\Cli\Command\Runner\Result
     */
    public function run(Command $command, OutputFormatter $formatter = null) : Result
    {
        $cmd = $this->processor->run($command->getCommand());

        if (!$cmd->isSuccessful()) {
            throw new RuntimeException('Command failed and exited with return code \'' . $cmd->getCode() . '\'');
        }

        $formatted = $formatter !== null ? $formatter->format($cmd->getStdOutAsArray()) : [];
        $result    = new Result($cmd, $formatted);

        return $result;
    }
}
