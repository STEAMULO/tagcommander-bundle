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

use Meup\Bundle\TagcommanderBundle\EventDispatcher\Event\Track;

/**
 *
 */
class TrackTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $tracker = 'lorem';
        $event   = 'ipsum';
        $values  = array('foo' => 'bar');

        $track = new Track($tracker, $event, $values);

        $this->assertEquals($tracker, $track->getTrackerName());
        $this->assertEquals($event, $track->getEventName());
        $this->assertEquals($values, $track->getValues());
    }
}
