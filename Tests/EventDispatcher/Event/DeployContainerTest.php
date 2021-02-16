<?php

/**
* This file is part of the Meup TagCommander Bundle.
*
* (c) 1001pharmacies <http://github.com/1001pharmacies/tagcommander-bundle>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Meup\Bundle\TagcommanderBundle\Tests\EventDispatcher\Event;

use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\DeployContainer;

/**
 *
 */
class DeployContainerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $name        = 'lorem';
        $script      = 'ipsum';
        $version     = null;
        $alternative = null;

        $deployContainer = new DeployContainer($name, $script, $version, $alternative);

        $this->assertEquals($name, $deployContainer->getContainerName());
        $this->assertEquals($script, $deployContainer->getContainerScript());
        $this->assertEquals($version, $deployContainer->getContainerVersion());
        $this->assertEquals($alternative, $deployContainer->getContainerAlternative());
    }
}
