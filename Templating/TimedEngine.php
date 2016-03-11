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
    protected $stopwatch;

    /**
     * Constructor.
     *
     * @param \Twig_Environment           $environment A \Twig_Environment instance
     * @param TemplateNameParserInterface $parser      A TemplateNameParserInterface instance
     * @param FileLocatorInterface        $locator     A FileLocatorInterface instance
     * @param Stopwatch                   $stopwatch   A Stopwatch instance
     */
    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser, FileLocatorInterface $locator, Stopwatch $stopwatch)
    {
        parent::__construct($environment, $parser, $locator);

        $this->stopwatch = $stopwatch;
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, array $parameters = array())
    {
        $e = $this->stopwatch->start(sprintf('template.twig (%s)', $name), 'template');

        $ret = parent::render($name, $parameters);

        $e->stop();

        return $ret;
    }
}
