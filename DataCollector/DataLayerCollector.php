<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagCommanderBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DataLayerCollector extends DataCollector
{
    public function __construct($datalayer)
    {
        $this->datalayer = $datalayer;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {}

    public function getDataLayer()
    {
        return $this->datalayer;
    }

    public function getName()
    {
        return 'datalayer';
    }
}
