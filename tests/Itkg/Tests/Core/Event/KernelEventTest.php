<?php

/*
 * This file is part of the Itkg\Core package.
 *
 * (c) Interakting - Business & Decision
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Itkg\Tests\Core\Event;

use Itkg\Core\Event\KernelEvent;
use Itkg\Core\ServiceContainer;

class KernelEventTest extends \PHPUnit_Framework_TestCase
{
    public function testContainer()
    {
        $container = new ServiceContainer();

        $event = new KernelEvent($container);

        $this->assertEquals($container, $event->getContainer());
    }
} 