<?php

namespace Itkg\Core\Command\DatabaseUpdate\Query;

/**
 * Class OutputQueryFactory
 *
 * Create queryDisplay object (with color or simple)
 *
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class OutputQueryFactory
{
    /**
     * @var QueryFormatterInterface
     */
    private $formatter;

    private $acceptTypes = array(
        '',
        'color'
    );

    /**
     * Constructor
     *
     * @param QueryFormatterInterface $formatter
     */
    public function __construct(QueryFormatterInterface $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * Create an outputQueryDisplay
     *
     * @param string $type
     *
     * @throws \InvalidArgumentException
     * @return OutputColorQueryDisplay|OutputQueryDisplay
     */
    public function create($type = '')
    {
        if (!in_array($type, $this->acceptTypes)) {
            throw new \InvalidArgumentException(
                sprintf('Type %s is not valid', $type)
            );
        }

        if ($type == 'color') {
            return new OutputColorQueryDisplay($this->formatter);
        }

        return new OutputQueryDisplay($this->formatter);
    }
}