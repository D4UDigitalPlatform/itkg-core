<?php

/*
 * This file is part of the Itkg\Core package.
 *
 * (c) Interakting - Business & Decision
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Core\Command;

use Itkg\Core\Command\Formatter\CommandLineFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommandExecuterAbstract
 *
 * Provide a wrapper to manage logs into command
 *
 * @package Itkg\Core\Command
 */
abstract class CommandExecuterAbstract extends Command
{
    /**
     * @var Formatter\CommandLineFormatter
     */
    protected $formatter;
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var array
     */
    protected $defautlRecord = array();

    /**
     * @param $name
     * @param CommandLineFormatter $formatter
     * @param array $defautlRecord
     */
    public function __construct($name, CommandLineFormatter $formatter, array $defautlRecord = array())
    {
        parent::__construct($name);

        $this->formatter = $formatter;
        $this->defautlRecord = $defautlRecord;
    }

    /**
     * Execute command and type
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \RuntimeException
     * @throws \LogicException
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        try {
            $this->doExecute($input, $output);
        } catch (\Exception $e) {
            $this->writeException($e);
        }
    }

    /**
     * Executed command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws \RuntimeException
     * @throws \LogicException
     * @return void
     */
    abstract public function doExecute(InputInterface $input, OutputInterface $output);

    /**
     * Write a message with extra record params
     *
     * @param string $message
     * @param array $record
     */
    protected function write($message, array $record = array())
    {
        $record = array_merge($this->defautlRecord, $record);
        $record['msg'] = $message;
        $this->output->writeln($this->formatter->format($record));
    }

    /**
     * Set a default record
     *
     * @param array $defaultRecord
     */
    public function setDefaultRecord(array $defaultRecord = array())
    {
        $this->defautlRecord = $defaultRecord;

        return $this;
    }

    /**
     * Merge default record with extra params
     *
     * @param array $defaultRecord
     * @return $this
     */
    public function mergeDefaultRecord(array $defaultRecord = array())
    {
        $this->defautlRecord = array_merge($this->defautlRecord, $defaultRecord);

        return $this;
    }

    /**
     * Write an exception with extra record params
     *
     * @param \Exception $exception
     * @param array $record
     */
    protected function writeException(\Exception $exception, array $record = array())
    {
        $record = array_merge($this->defautlRecord, $record);
        $this->output->writeln($this->formatter->formatException($exception, $record));
    }
}
