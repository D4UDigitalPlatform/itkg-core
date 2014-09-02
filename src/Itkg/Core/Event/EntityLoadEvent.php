<?php

namespace Itkg\Core\Event;

use Itkg\Core\CachableInterface;
use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Itkg\Core\EntityAbstract;

class EntityLoadEvent extends BaseEvent
{
    /**
     * Entity instance
     *
     * @var CachableInterface
     */
    private $entity;

    /**
     * Constructor
     */
    public function __construct(CachableInterface $entity)
    {
        $this->entity = $entity;
    }

    /**
     * Entity getter
     *
     * @return CachableInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

}