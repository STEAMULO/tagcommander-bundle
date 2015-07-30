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

    /**
     *
     */
    public function __construct(ParameterBagInterface $datalayer)
    {
        $this->datalayer = $datalayer;
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
    public function getFunctions()
    {}

    /**
     *
     */
    public function getName()
    {
        return 'tagcommander_extension';
    }
}
