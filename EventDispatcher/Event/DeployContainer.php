<?php

namespace Meup\Bundle\TagcommanderBundle\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class DeployContainer extends Event
{
    protected $name;
    protected $script;
    protected $version;
    protected $alternative;

    /**
     * 
     */
    public function __construct($name, $script, $version = null, $alternative = null)
    {
        $this->name        = $name;
        $this->script      = $script;
        $this->version     = $version;
        $this->alternative = $alternative;
    }

    /**
     * @return string
     */
    public function getContainerName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContainerScript()
    {
        return $this->script;
    }

    /**
     * @return string
     */
    public function getContainerVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getContainerAlternative()
    {
        return $this->alternative;
    }
}
