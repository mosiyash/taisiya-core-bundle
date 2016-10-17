<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PreUpdateCmdEvent extends Event
{
    const NAME = 'composer.commands.pre_update_cmd_event';
}
