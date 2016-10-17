<?php

namespace Taisiya\CoreBundle\Event\Composer\PluginEvent;

use Taisiya\CoreBundle\Event\Event;

class InitEvent extends Event
{
    const NAME = 'composer.plugins.init_event';
}
