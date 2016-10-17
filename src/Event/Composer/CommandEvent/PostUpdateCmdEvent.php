<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostUpdateCmdEvent extends Event
{
    const NAME = 'composer.commands.post_update_cmd_event';
}
