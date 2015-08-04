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
        $this->datalayer = $datalayer;
        $this->used_function = $used_function;
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

    public function tc_event($arg) {
        return sprintf("%s('%s');", $this->used_function, $arg);
    }

    /**
     *
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('tc_event', array($this, 'tc_event')),
            //new \Twig_SimpleFunction('tc_path',  array($this, '')),
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
