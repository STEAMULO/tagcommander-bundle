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

use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Config\FileLocatorInterface;

/**
 *
 */
class TimedEngine extends Engine
{
    /**
     * {@inheritdoc}
     */
    public function render($name, array $parameters = array())
    {
        $e = $this->container->get('stopwatch')->start(sprintf('template.twig (%s)', $name), 'template');

        $ret = parent::render($name, $parameters);

        $e->stop();

        return $ret;
    }
}
