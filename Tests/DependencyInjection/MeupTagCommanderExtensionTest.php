<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagCommanderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Meup\Bundle\TagCommanderBundle\DependencyInjection\MeupTagCommanderExtension;

/**
 *
 */
class MeupTagCommanderExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MeupTagCommanderExtension
     */
    private $extension;

    /**
     * Root name of the configuration
     *
     * @var string
     */
    private $root;

    /**
     * @return MeupTagCommanderExtension
     */
    protected function getExtension()
    {
        return new MeupTagCommanderExtension();
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container = new ContainerBuilder();

        return $container;
    }

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();

        $this->extension = $this->getExtension();
        $this->root      = "meup_tagcommander";
    }

    /**
     *
     */
    public function testGetConfigWithDefaultValues()
    {
        $this->extension->load(array(), $container = $this->getContainer());

        $this->assertTrue($container->has('meup_tagcommander.datalayer'));
        $this->assertTrue($container->has('meup_tagcommander.twig_extension'));
    }
}