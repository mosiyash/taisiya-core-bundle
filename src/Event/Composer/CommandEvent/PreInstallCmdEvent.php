<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\Composer\ComposerEvent;

class PreInstallCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.pre_install_cmd_event';
}
