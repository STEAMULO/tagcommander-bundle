<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Tests\EventDispatcher\Subscriber;

use Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Subscriber\CollectorSubscriber;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\DeployContainer;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\Track;

/**
 *
 */
class CollectorSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param DeployContainer $deployContainer
     * @param Track $track
     * @return DataLayerCollector
     */
    private function buildCollector(DeployContainer $deployContainer, Track $track)
    {
        $collector = $this
            ->getMockBuilder('Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector')
            ->disableOriginalConstructor()
            ->setMethods(array('collectContainer', 'collectEvent'))
            ->getMock()
        ;

        $this->withDeployContainerEvent($collector, $deployContainer);
        $this->withTrackEvent($collector, $track);

        return $collector;
    }

    private function withDeployContainerEvent($collector, DeployContainer $deployContainer)
    {
        $collector
            ->expects($this->once())
            ->method('collectContainer')
            ->with(
                $this->equalTo($deployContainer->getContainerName()),
                $this->equalTo($deployContainer->getContainerScript()),
                $this->equalTo($deployContainer->getContainerVersion()),
                $this->equalTo($deployContainer->getContainerAlternative())
            )
        ;
    }

    private function withTrackEvent($collector, Track $track)
    {
        $collector
            ->expects($this->once())
            ->method('collectEvent')
            ->with(
                $this->equalTo($track->getTrackerName()),
                $this->equalTo($track->getEventName()),
                $this->equalTo($track->getValues())
            )
        ;
    }

    /**
     * 
     */
    public function testConstruct()
    {
        $deployContainer = new DeployContainer('name', 'http://');
        $track = new Track('tracker', 'event', array('foo' => 'bar'));

        $collectorSubscriber = new CollectorSubscriber($this->buildCollector($deployContainer, $track));
        $collectorSubscriber->onTcContainer($deployContainer);
        $collectorSubscriber->onTcEvent($track);

        $this->assertEquals(
            array(DeployContainer::class, Track::class),
            array_keys($collectorSubscriber->getSubscribedEvents())
        );
    }
}
