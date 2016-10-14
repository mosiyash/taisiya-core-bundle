<?php

namespace Taisiya\CoreBundle\Event\Composer;

use Taisiya\CoreBundle\Event\Event;

class CommandEvent extends Event
{
    const NAME = 'composer.command_event';
}
