<?php

/*
 * This file is part of the Itkg\Core package.
 *
 * (c) Interakting - Business & Decision
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Core\Command\DatabaseUpdate;

use Doctrine\DBAL\Connection;
use Itkg\Core\Command\DatabaseUpdate\Migration\Exception;

/**
 * Class Runner
 *
 * Run migrations (Play queries)
 * You can execute queries or just simulate them (for display)
 *
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class Runner implements RunnerInterface
{
    /**
     * Doctrine connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * @var Migration
     */
    private $migration;

    /**
     * @var array
     */
    private $playedQueries = array();

    /**
     * Constructor
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Run a migration
     *
     * @param Migration $migration
     * @param bool $executeQueries
     * @param bool $forcedRollback
     *
     * @throws \Exception
     * @throws Migration\Exception
     * @return void
     */
    public function run(Migration $migration, $executeQueries = false, $forcedRollback = false)
    {
        $this->migration = $migration;

        try {
            $this->playQueries($executeQueries);
            if ($forcedRollback) {
                $this->playRollbackQueries($executeQueries);
            }
        } catch (Exception $e) {
            $this->playRollbackQueries($executeQueries);

            throw $e;
        }
    }

    /**
     * Play Script queries
     *
     * @param bool $executeQueries
     * @throws Migration\Exception
     * @throws \Exception
     * @return void
     */
    private function playQueries($executeQueries = false)
    {
        foreach ($this->migration->getQueries() as $idx => $query) {
            try {
                $this->runQuery($query, $executeQueries);
            } catch (\Exception $e) {
                // Only throw if more than one query is played
                if ($idx >= 1) {
                    throw new Exception($e->getMessage());
                }

                throw $e;
            }
        }
    }

    /**
     * Play rollback queries
     *
     * @param bool $executeQueries
     * @return void
     */
    private function playRollbackQueries($executeQueries = false)
    {
        foreach ($this->migration->getRollbackQueries() as $query) {
            $this->runQuery($query, $executeQueries);
        }
    }

    /**
     * Run a query if execute query is true
     * else simply add query to played queries stack
     *
     * @param Query $query
     * @param bool $executeQueries
     */
    private function runQuery(Query $query, $executeQueries = false)
    {
        $this->playedQueries[] = $query;
        if ($executeQueries) {
            $this->connection->executeQuery((string)$query);
        }
    }

    /**
     * Get played queries
     *
     * @return array
     */
    public function getPlayedQueries()
    {
        return $this->playedQueries;
    }
}
