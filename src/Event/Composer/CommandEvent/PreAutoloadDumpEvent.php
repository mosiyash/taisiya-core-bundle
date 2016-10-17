<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PreAutoloadDumpEvent extends Event
{
    const NAME = 'composer.commands.pre_autoload_dump_event';
}
