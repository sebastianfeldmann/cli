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

/**
 * Class Result
 *
 * @package SebastianFeldmann\Cli
 */
class Result
{
    /**
     * Command that got executed.
     *
     * @var string
     */
    private $cmd;

    /**
     * Result code.
     *
     * @var int
     */
    private $code;

    /**
     * Output buffer.
     *
     * @var array
     */
    private $buffer;

    /**
     * StdOut.
     *
     * @var string
     */
    private $stdOut;

    /**
     * StdErr.
     *
     * @var string
     */
    private $stdErr;

    /**
     * Result constructor.
     *
     * @param string $cmd
     * @param int    $code
     * @param string $stdOut
     * @param string $stdErr
     */
    public function __construct(string $cmd, int $code, string $stdOut = '', string $stdErr = '')
    {
        $this->cmd    = $cmd;
        $this->code   = $code;
        $this->stdOut = $stdOut;
        $this->stdErr = $stdErr;
    }

    /**
     * Cmd getter.
     *
     * @return string
     */
    public function getCmd() : string
    {
        return $this->cmd;
    }

    /**
     * Code getter.
     *
     * @return int
     */
    public function getCode() : int
    {
        return $this->code;
    }

    /**
     * Command executed successful.
     */
    public function wasSuccessful() : bool
    {
        return $this->code == 0;
    }

    /**
     * StdOutput getter.
     *
     * @return string
     */
    public function getStdOut() : string
    {
        return $this->stdOut;
    }

    /**
     * StdError getter.
     *
     * @return string
     */
    public function getStdErr() : string
    {
        return $this->stdErr;
    }

    /**
     * Return the output as array.
     *
     * @return array
     */
    public function getStdOutAsArray() : array
    {
        if (null === $this->buffer) {
            $this->buffer = $this->textToBuffer();
        }
        return $this->buffer;
    }

    /**
     * Converts a string into an array.
     *
     * @return array
     */
    private function textToBuffer() : array
    {
        $buffer = explode(PHP_EOL, $this->stdOut);
        // remove empty array elements at the end
        $last = count($buffer) - 1;
        while (empty($buffer[$last])) {
            unset($buffer[$last]);
            $last--;
        }
        return $buffer;
    }

    /**
     * Magic to string method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->stdOut;
    }
}
