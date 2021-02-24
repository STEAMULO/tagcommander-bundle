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

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 *
 */
class DataLayerCollector extends DataCollector
{
    /**
     * @var ParameterBagInterface
     */
    protected $datalayer;

    /**
     * @param ParameterBagInterface $datalayer
     */
    public function __construct(ParameterBagInterface $datalayer)
    {
        $this->datalayer = $datalayer;
        $this->data      = array(
            'values'     => array(),
            'events'     => array(),
            'containers' => array(),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function reset()
    {
        $this->data      = array(
            'values'     => array(),
            'events'     => array(),
            'containers' => array(),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $this->data['values'] = $this->datalayer->all();
    }

    /**
     * @param string $trackerName
     * @param string $eventName
     * @param array $values
     */
    public function collectEvent($trackerName, $eventName, $values = array())
    {
        $this->data['events'][$eventName][] = array(
            'tracker' => $trackerName,
            'values'  => $values,
        );
    }

    /**
     * @param string $name
     * @param string $script
     * @param string|null $version
     * @param string|null $alternative
     *
     * @return void
     */
    public function collectContainer($name, $script, $version = null, $alternative = null)
    {
        $this->data['containers'][] = array(
            'name'        => $name,
            'script'      => $script,
            'version'     => $version,
            'alternative' => $alternative,
        );
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->data['values'];
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->data['events'];
    }

    /**
     * @return array
     */
    public function getContainers()
    {
        return $this->data['containers'];
    }

    /**
     * @return integer
     */
    public function getUniqueEventsCount()
    {
        $count = 0;
        foreach ($this->data['events'] as $events) {
            $count += count($events);
        }
        return $count;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'datalayer';
    }
}
