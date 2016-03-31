<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Meup\Bundle\TagcommanderBundle\DependencyInjection\MeupTagcommanderExtension;

/**
 *
 */
class MeupTagcommanderExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MeupTagcommanderExtension
     */
    private $extension;

    /**
     * Root name of the configuration
     *
     * @var string
     */
    private $root;

    /**
     * @return MeupTagcommanderExtension
     */
    protected function getExtension()
    {
        return new MeupTagcommanderExtension();
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
        $this->root      = 'meup_tagcommander';
    }

    /**
     *
     */
    public function testGetConfigWithDefaultValues()
    {

        $configs = array(
            'default_event'       => 'default',
            'datalayer'           => array(
                'name'            => 'tc_vars',
                'default'         => array(
                    'env'         => '%kernel.environment%',
                    'locale'      => '%locale%',
                ),
            ),
            'containers'          => array(
                array(
                    'name'        => 'ab-test',
                    'script'      => 'my-ab-test-container.js',
                ),
                array(
                    'name'        => 'generic',
                    'script'      => 'my-generic-container.js',
                    'version'     => 'v17.11',
                    'alternative' => '//redirect1578.tagcommander.com/utils/noscript.php?id=3&amp;mode=iframe',
                ),
            ),
            'events'              => array(
                array(
                    'name'        => 'default',
                    'function'    => 'tc_events_1',
                ),
                array(
                    'name'        => 'other_events',
                    'function'    => 'tc_events_2',
                ),
            ),
        );

        $this
            ->extension
            ->load(
                array($configs),
                $container = $this->getContainer()
            )
        ;

        $this->assertTrue($container->hasDefinition($this->root.'.datalayer'));
        $this->assertTrue($container->hasDefinition($this->root.'.twig_extension'));
        $this->assertTrue($container->hasDefinition($this->root.'.datacollector_subscriber'));
    }
}
