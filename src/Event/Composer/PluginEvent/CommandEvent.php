<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\Event;

class CommandEvent extends Event
{
    const NAME = 'composer.plugins.command_event';
}
