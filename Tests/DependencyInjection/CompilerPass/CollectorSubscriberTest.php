<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Tests\DependencyInjection\CompilerPass;

use Meup\Bundle\TagcommanderBundle\DependencyInjection\CompilerPass\CollectorSubscriber;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 */
class CollectorSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Definition
     */
    private function getDispatcher()
    {
        $dispatcher = $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\Definition')
            ->setMethods(array('addMethodCall'))
            ->getMock()
        ;
        $dispatcher
            ->expects($this->once())
            ->method('addMethodCall')
            ->with(
                $this->equalTo('addSubscriber'),
                $this->equalTo(array(new Reference('meup_tagcommander.datacollector_subscriber')))
            )
        ;

        return $dispatcher;
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container = $this
            ->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->getMock()
        ;
        $container
            ->method('findDefinition')
            ->willReturn($this->getDispatcher())
        ;

        return $container;
    }

    /**
     *
     */
    public function testCompilerPass()
    {
        $collectorSubscriber = new CollectorSubscriber();
        $collectorSubscriber->process($this->getContainer());
    }
}
