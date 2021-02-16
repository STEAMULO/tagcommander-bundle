<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\EventDispatcher\Subscriber;

use Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\Track;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\DeployContainer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 */
class CollectorSubscriber implements EventSubscriberInterface
{
    /**
     * @var DataLayerCollector
     */
    protected $collector;

    /**
     * @param DataLayerCollector $collector
     */
    public function __construct(DataLayerCollector $collector)
    {
        $this->collector = $collector;
    }

    /** @inheritDoc */
    public static function getSubscribedEvents()
    {
        return array(
            DeployContainer::class => 'onTcContainer',
            Track::class     => 'onTcEvent',
        );
    }

    /**
     * @param DeployContainer $event
     * @return void
     */
    public function onTcContainer(DeployContainer $event)
    {
        $this->collector->collectContainer(
            $event->getContainerName(),
            $event->getContainerScript(),
            $event->getContainerVersion(),
            $event->getContainerAlternative()
        );
    }

    /**
     * @param Track $event
     * @return void
     */
    public function onTcEvent(Track $event)
    {
        $this->collector->collectEvent(
            $event->getTrackerName(),
            $event->getEventName(),
            $event->getValues()
        );
    }
}
