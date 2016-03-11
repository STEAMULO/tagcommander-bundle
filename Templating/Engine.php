<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Templating;

use Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine;
use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\Render;

class Engine extends DelegatingEngine
{
    /**
     * {@inheritdoc}
     */
    public function render($name, array $parameters = array())
    {
        $event = new Render($name, $parameters, $this->container->get('request'));

        $container->get('event_dispatcher')->dispatch('render', $event);
        
        return parent::render($name, $parameters);
    }
}
