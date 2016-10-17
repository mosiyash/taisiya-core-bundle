<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PreUpdateCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.pre_update_cmd_event';
}
