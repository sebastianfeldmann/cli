<?php
/**
 * This file is part of SebastianFeldmann\Cli.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Cli\Processor;

use RuntimeException;
use SebastianFeldmann\Cli\Command\Result;
use SebastianFeldmann\Cli\Output;
use SebastianFeldmann\Cli\Processor;

/**
 * Class ProcOpen
 *
 * @package SebastianFeldmann\Cli
 * @author  Sebastian Feldmann <sf@sebastian-feldmann.info>
 * @link    https://github.com/sebastianfeldmann/cli
 * @since   Class available since Release 0.9.0
 */
class ProcOpen implements Processor
{
    /**
     * Handles the output of stdOut
     *
     * @var \SebastianFeldmann\Cli\Output
     */
    private $stdOutOutput;

    /**
     * Handles the Output of stdErr
     *
     * @var \SebastianFeldmann\Cli\Output
     */
    private $stdErrOutput;

    /**
     * ProcOpen constructor
     *
     * @param \SebastianFeldmann\Cli\Output $stdOut
     * @param \SebastianFeldmann\Cli\Output $stdErr
     */
    public function __construct(Output $stdOut = null, Output $stdErr = null)
    {
        $this->stdOutOutput = $stdOut ?? new Output\Silent();
        $this->stdErrOutput = $stdErr ?? new Output\Silent();
    }

    /**
     * Execute the command
     *
     * @param  string $cmd
     * @param  int[]  $acceptableExitCodes
     * @return \SebastianFeldmann\Cli\Command\Result
     */
    public function run(string $cmd, array $acceptableExitCodes = [0]) : Result
    {
        $old    = error_reporting(0);
        $stdOut = '';
        $stdErr = '';
        $spec   = [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']];

        $process = proc_open($cmd, $spec, $pipes);
        if (!is_resource($process)) {
            throw new RuntimeException('can\'t execute \'proc_open\'');
        }

        // Loop on process until it exits
        do {
            $status = proc_get_status($process);
            $out    = !feof($pipes[1]) ? (string) fgets($pipes[1]) : '';
            $err    = !feof($pipes[2]) ? (string) fgets($pipes[2]) : '';

            $this->handleOutput($out, $err);

            $stdOut .= $out;
            $stdErr .= $err;
        } while ($status['running']);

        // According to documentation, the exit code is only valid the first call
        // after a process is finished. We can't rely on the return value of
        // proc_close because proc_get_status will read the exit code first.
        $code = $status['exitcode'];
        proc_close($process);
        error_reporting($old);

        return new Result($cmd, $code, $stdOut, $stdErr, '', $acceptableExitCodes);
    }

    /**
     * Uses the output handlers to process the given stdOut and stdErr output
     *
     * @param  string $stdOut
     * @param  string $stdErr
     * @return void
     */
    private function handleOutput(string $stdOut, string $stdErr) : void
    {
        $this->stdOutOutput->write($stdOut);
        $this->stdErrOutput->write($stdErr);
    }
}
