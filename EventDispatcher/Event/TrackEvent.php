<?php

namespace Meup\Bundle\TagcommanderBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class TrackEvent extends Event
{
    protected $tracker;
    protected $event;
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

    public function getTrackerName()
    {
        return $this->tracker;
    }

    public function getEventName()
    {
        return $this->event;
    }

    public function getValues()
    {
        return $this->values;
    }
}
