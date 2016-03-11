<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 *
 */
class Render extends Event
{
    /**
     *
     */
    protected $view;

    /**
     *
     */
    protected $parameters;

    /**
     *
     */
    public function __construct($view, array $parameters = array())
    {
        $this->view = $view;
        $this->parameters = $parameters;
    }

    /**
     *
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     *
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
