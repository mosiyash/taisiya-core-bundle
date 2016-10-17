<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Event;

class PreInstallCmdEvent extends Event
{
    const NAME = 'composer.commands.pre_install_cmd_event';
}
