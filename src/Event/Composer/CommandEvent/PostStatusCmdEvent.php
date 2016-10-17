<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostStatusCmdEvent extends Event
{
    const NAME = 'composer.commands.post_status_cmd_event';
}
