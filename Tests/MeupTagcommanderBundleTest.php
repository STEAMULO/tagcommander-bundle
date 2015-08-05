<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Tests;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * 
 */
class MeupTagcommanderBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $bundle = $this
            ->getMockBuilder('Meup\Bundle\TagcommanderBundle\MeupTagcommanderBundle')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
        $container = new ContainerBuilder();

        $bundle->build($container);
    }
}
