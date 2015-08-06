<?php

namespace Meup\Bundle\TagcommanderBundle\EventDispatcher\Listener;

use Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\TrackEvent;

class CollectorListener
{
    protected $collector;

    public function __construct(DataLayerCollector $collector)
    {
        $this->collector = $collector;
    }

    public function onTcEvent(TrackEvent $event)
    {
        $this->collector->collectEvent(
            $event->getTrackerName(),
            $event->getEventName(),
            $event->getValues()
        );
    }
}
