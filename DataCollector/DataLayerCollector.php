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
    }

    /**
     * {@inheritDoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'values' => $this->datalayer->all(),
            'events' => array(),
        );
    }

    public function getValues()
    {
        return $this->data['values'];
    }

    public function getEvents()
    {
        return $this->data['events'];
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'datalayer';
    }
}
