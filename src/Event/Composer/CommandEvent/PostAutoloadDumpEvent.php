<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostAutoloadDumpEvent extends Event
{
    const NAME = 'composer.commands.post_autoload_dump_event';
}
