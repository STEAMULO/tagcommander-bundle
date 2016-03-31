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

use Symfony\Component\EventDispatcher\Event;

/**
 *
 */
class DeployContainer extends Event
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $script;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $alternative;

    /**
     * @param string $name
     * @param string $script
     * @param string $version
     * @param string $alternative
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
