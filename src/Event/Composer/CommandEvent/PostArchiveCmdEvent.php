<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostArchiveCmdEvent extends Event
{
    const NAME = 'composer.commands.post_archive_cmd_event';
}
