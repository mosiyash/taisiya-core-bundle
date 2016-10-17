<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PostInstallCmdEvent extends Event
{
    const NAME = 'composer.commands.post_install_cmd_event';
}
