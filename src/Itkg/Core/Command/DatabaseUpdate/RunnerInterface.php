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

use Itkg\Core\Command\DatabaseUpdate\Migration as BaseMigration;

/**
 * Interface RunnerInterface
 *
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
interface RunnerInterface
{
    /**
     * Run a migration
     *
     * @param Migration $migration
     * @param bool $executeQueries
     * @param bool $forcedRollback
     *
     * @return void
     */
    public function run(BaseMigration $migration, $executeQueries = false, $forcedRollback = false);

    /**
     * Get played queries
     *
     * @return array
     */
    public function getPlayedQueries();
}
