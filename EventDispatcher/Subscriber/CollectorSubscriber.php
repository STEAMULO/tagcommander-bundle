<?php

namespace Meup\Bundle\TagcommanderBundle\EventDispatcher\Subscriber;

use Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\Track;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\DeployContainer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CollectorSubscriber implements EventSubscriberInterface
{
    protected $collector;

    public function __construct(DataLayerCollector $collector)
    {
        $this->collector = $collector;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'tc_container' => array('onTcContainer', 0),
            'tc_event'     => array('onTcEvent', 0),
        );
    }

    public function onTcContainer(DeployContainer $event)
    {
        $this->collector->collectContainer(
            $event->getContainerName(),
            $event->getContainerScript(),
            $event->getContainerVersion(),
            $event->getContainerAlternative()
        );
    }

    public function onTcEvent(Track $event)
    {
        $this->collector->collectEvent(
            $event->getTrackerName(),
            $event->getEventName(),
            $event->getValues()
        );
    }
}
