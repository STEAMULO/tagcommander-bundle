<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\DataCollector;

use Meup\Bundle\TagcommanderBundle\DataCollector\DataLayerCollector;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class DataLayerCollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     */
    public function testConstruct()
    {
        $dataLayerCollector = new DataLayerCollector(new ParameterBag());

        $this->assertEquals('datalayer', $dataLayerCollector->getName());
    }

    /**
     * 
     */
    public function testCollect()
    {
        $dataLayerCollector = new DataLayerCollector(new ParameterBag(array('foo' => 'bar')));
        $dataLayerCollector->collect(new Request(), new Response());

        $values = $dataLayerCollector->getValues();
        $this->assertEquals('bar', $values['foo']);
    }

    /**
     * 
     */
    public function testEventsCollect()
    {
        $dataLayerCollector = new DataLayerCollector(new ParameterBag());
        $dataLayerCollector->collectEvent('trackerName', 'eventName', array('foo'=>'bar'));

        $events = $dataLayerCollector->getEvents();
        $this->assertTrue(array_key_exists('eventName', $events));
        $this->assertEquals(1, $dataLayerCollector->getUniqueEventsCount());
    }

    /**
     * 
     */
    public function testContainersCollect()
    {
        $dataLayerCollector = new DataLayerCollector(new ParameterBag());
        $dataLayerCollector->collectContainer('foobar', 'http://');

        $containers = $dataLayerCollector->getContainers();
        $this->assertEquals('foobar', $containers[0]['name']);
    }
}
