<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagCommanderBundle\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 *
 */
class TagCommanderExtension extends \Twig_Extension
{
    /**
     * @var ParameterBagInterface
     */
    protected $datalayer;
    protected $used_function;

    /**
     *
     */
    public function __construct(ParameterBagInterface $datalayer, $used_function)
    {
        $this->datalayer     = $datalayer;
        $this->used_function = $used_function;
        $this->serializer    = new Serializer(
            array(new ObjectNormalizer()),
            array(new JsonEncoder())
        );
    }

    /**
     *
     */
    public function getGlobals()
    {
        return array(
            'datalayer' => $this->datalayer,
        );
    }

    /**
     *
     */
    public function tc_event($event_name, $values = array()) {
        $datalayer = clone $this->datalayer;
        return sprintf(
            "%s('%s', %s);",
            $this->used_function,
            $event_name,
            $this->serializer->serialize(
                array_merge(
                    $datalayer->all(), 
                    $values
                ),
                'json'
            )
        );
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tc_event', array($this, 'tc_event')),
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
