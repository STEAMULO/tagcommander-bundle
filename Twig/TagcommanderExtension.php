<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Twig;

use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\DeployContainer;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\Track;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 *
 */
class TagcommanderExtension extends \Twig_Extension
{
    /**
     * @var ParameterBagInterface
     */
    protected $datalayer;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var string
     */
    protected $tcVars;

    /**
     * @var array
     */
    protected $events = array();

    /**
     * @var array
     */
    protected $containers = array();

    /**
     * @var string
     */
    protected $defaultEvent = null;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     *
     */
    public function __construct(
        ParameterBagInterface $datalayer,
        EventDispatcherInterface $dispatcher,
        $tcVars = 'tc_vars'
    ) {
        $this->datalayer     = $datalayer;
        $this->dispatcher    = $dispatcher;
        $this->tcVars        = $tcVars;
        $this->serializer    = new Serializer(
            array(new ObjectNormalizer()),
            array(new JsonEncoder())
        );
    }

    /**
     * @return string|boolean|integer|double|null
     */
    protected function serializeWithValues($values = array())
    {
        $datalayer = clone $this->datalayer;

        return $this
            ->serializer
            ->serialize(
                array_merge(
                    $datalayer->all(),
                    $values
                ),
                'json'
            )
        ;
    }

    /** 
     * @param Array $values
     * @return string
     */
    public function tcVars($values = array())
    {
        return sprintf(
            '<script type="text/javascript">var %s = %s;</script>',
            $this->tcVars,
            $this->serializeWithValues($values)
        );
    }

    /** 
     * @param array $event
     * @param boolean $setAsDefault
     * @return self
     */
    public function addEvent($event, $setAsDefault = false)
    {
        $this->events[$event['name']] = $event;

        if ($setAsDefault || (!$setAsDefault && !$this->defaultEvent)) {
            $this->defaultEvent = $event['name'];
        }

        return $this;
    }

    /**
     * @param string $eventName
     * @param array $values 
     * @param string|null $tracker
     * @return string
     */
    public function tcEvent($eventName, $values = array(), $tracker = null)
    {
        if (is_null($tracker)) {
            $tracker = $this->defaultEvent;
        }

        $function = $this->events[$tracker]['function'];

        $event = new Track($tracker, $eventName, array_merge($this->datalayer->all(), $values));
        $this->dispatcher->dispatch('tc_event', $event);

        return sprintf(
            "%s('%s', %s);",
            $function,
            $eventName,
            $this->serializeWithValues($values)
        );
    }

    /**
     * @param array $container
     * @return self
     */
    public function addContainer($container)
    {
        $this->containers[$container['name']] = $container;

        return $this;
    }

    /**
     * @param string $containerName
     * @return string
     */
    public function tcContainer($containerName)
    {
        $container = $this->containers[$containerName];
        $container_version = $container_alternative = null;

        $container_script = $container['script'];
        $src = $container_script;

        if ($container['version']) {
            $container_version = $container['version'];
            $src .= sprintf('?%s', $container_version);
        }

        $result = sprintf('<script type="text/javascript" src="%s"></script>', $src);

        if ($container['alternative']) {
            $container_alternative = $container['alternative'];
            $result .= sprintf(
                '<noscript><iframe src="%s" width="1" height="1" rel="noindex,nofollow"></iframe></noscript>',
                $container_alternative
            );
        }

        $event = new DeployContainer(
            $containerName,
            $container_script,
            $container_version,
            $container_alternative
        );
        $this->dispatcher->dispatch('tc_container', $event);

        return $result;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return array(

            /* tc_var() */
            new \Twig_SimpleFunction(
                'tc_vars',
                array($this, 'tcVars'),
                array(
                    'is_safe' => array('html'),
                )
            ),

            /* tc_container() */
            new \Twig_SimpleFunction(
                'tc_container',
                array($this, 'tcContainer'),
                array(
                    'is_safe' => array('html'),
                )
            ),

            /* tc_event() */
            new \Twig_SimpleFunction(
                'tc_event',
                array($this, 'tcEvent'),
                array(
                    'is_safe' => array('html'),
                )
            ),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tagcommander_extension';
    }
}
