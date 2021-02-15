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

use Symfony\Contracts\EventDispatcher\Event;

/**
 * 
 */
class Track extends Event
{
    /**
     * @var string
     */
    protected $tracker;

    /**
     * @var string
     */
    protected $event;

    /**
     * @var array
     */
    protected $values;

    /**
     * @param string $tracker
     * @param string $event
     * @param array $values
     */
    public function __construct($tracker, $event, $values = array())
    {
        $this->tracker = $tracker;
        $this->event   = $event;
        $this->values  = $values;
    }

    /**
     * @return string
     */
    public function getTrackerName()
    {
        return $this->tracker;
    }

    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->event;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }
}
