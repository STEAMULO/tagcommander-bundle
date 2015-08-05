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
    protected $used_function;
    protected $tc_vars;

    /**
     *
     */
    public function __construct(ParameterBagInterface $datalayer, $used_function, $tc_vars = 'tc_vars')
    {
        $this->datalayer     = $datalayer;
        $this->tc_vars       = $tc_vars;
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

    public function tc_datalayer($values = array())
    {
        return sprintf(
            '<script type="text/javascript">var %s = %s;</script>',
            $this->tc_vars,
            $this->serializeWithValues($values)
        );
    }

    public function tc_event($event_name, $values = array()) {
        return sprintf(
            "%s('%s', %s);",
            $this->used_function,
            $event_name,
            $this->serializeWithValues($values)
        );
    }

    public function tc_container($container_name)
    {
        return sprintf('<script type="text/javascript" src="%s"></script>', $src);
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction($this->tc_vars, array($this, 'tc_vars')),
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
