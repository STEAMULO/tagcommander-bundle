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

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
     * @var string
     */
    protected $tc_vars;

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
    protected $default_event = null;

    /**
     *
     */
    public function __construct(ParameterBagInterface $datalayer, $tc_vars = 'tc_vars')
    {
        $this->datalayer     = $datalayer;
        $this->tc_vars       = $tc_vars;
        $this->serializer    = new Serializer(
            array(new ObjectNormalizer()),
            array(new JsonEncoder())
        );
    }

    /**
     *
     */
    protected function serializeWithValues($values = array()) {
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

    public function tc_vars($values = array())
    {
        return sprintf(
            '<script type="text/javascript">var %s = %s;</script>',
            $this->tc_vars,
            $this->serializeWithValues($values)
        );
    }

    public function addEvent($event, $set_as_default = false)
    {
        $this->events[$event['name']] = $event;

        if ($set_as_default) {
            $this->default_event = $event['name'];
        }

        return $this;
    }

    public function tc_event($event_name, $values = array(), $tracker = null) {
        if (is_null($tracker)) {
            $tracker = $this->default_event;
        }

        $function = $this->events[$tracker]['function'];

        return sprintf(
            "%s('%s', %s);",
            $function,
            $event_name,
            $this->serializeWithValues($values)
        );
    }

    public function addContainer($container)
    {
        $this->containers[$container['name']] = $container;

        return $this;
    }

    public function tc_container($container_name)
    {
        $container = $this->containers[$container_name];

        $src = $container['script'];

        if ($container['version']) {
            $src.= sprintf('?%s', $container['version']);
        }

        $result = sprintf('<script type="text/javascript" src="%s"></script>', $src);

        if ($container['alternative']) {
            $result.= sprintf('<noscript><iframe src="%s" width="1" height="1" rel="noindex,nofollow"></iframe></noscript>', $container['alternative']);
        }

        return $result;
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tc_vars',      array($this, 'tc_vars')),
            new \Twig_SimpleFunction('tc_container', array($this, 'tc_container')),
            new \Twig_SimpleFunction('tc_event',     array($this, 'tc_event')),
        );
    }

    /**
     *
     */
    public function getName()
    {
        return 'tagcommander_extension';
    }
}
