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

/**
 * Class Locator
 *
 * Find scripts into releases folder
 *
 * @package Itkg\Core\Command\DatabaseUpdate
 */
class Locator implements LocatorInterface
{
    /**
     * @var string
     */
    private $path = 'script/releases';

    /**
     * @var string
     */
    private $release;

    /**
     * @var string
     */
    private $scriptName;

    /**
     * Get all scripts for a path
     * If a scriptName is defined, only scripts like $scriptName.php will be returned
     *
     * @return array
     */
    public function findScripts()
    {
        $path = sprintf('%s/%s/script', $this->path, $this->release);

        return $this->getFiles($path);
    }

    /**
     * Get all rollback scripts for a path
     * If a scriptName is defined, only scripts like $scriptName.php will be returned
     *
     * @return array
     */
    public function findRollbackScripts()
    {
        $path = sprintf('%s/%s/rollback', $this->path, $this->release);

        return $this->getFiles($path);
    }

    /**
     * Set params
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params = array())
    {
        foreach ($params as $key => $value) {
            if (null != $value) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * Get files for a specific path
     *
     * @param $path
     * @return array
     */
    private function getFiles($path)
    {
        $files = array();

        foreach (new \DirectoryIterator($path) as $file) {
            if ($file->isDot()
                || (null != $this->scriptName && sprintf('%s.php', $this->scriptName) != $file->getFilename())
            ) {
                continue;
            }

            $files[$file->getFilename()] = sprintf('%s/%s', $file->getPath(), $file->getFilename());
        }
        sort($files);

        return $files;
    }
}
