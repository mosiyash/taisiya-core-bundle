<?php

namespace Taisiya\CoreBundle\Event\Composer\CommandEvent;

use Taisiya\CoreBundle\Event\ComposerEvent;

class PostInstallCmdEvent extends ComposerEvent
{
    const NAME = 'composer.commands.post_install_cmd_event';
}
